<?php

namespace GiveRecurring\Webhooks\Stripe\Listeners;

use Give\PaymentGateways\PayPalCommerce\Webhooks\Listeners\EventListener;
use Give_Subscription;
use Give_Subscriptions_DB;
use Stripe\Event as StripeEvent;

/**
 * Class InvoicePaymentSucceeded
 * @package GiveRecurring\Webhooks\Stripe\Listeners
 *
 * @since 1.12.6
 */
class InvoicePaymentSucceeded implements EventListener
{

    /**
     * Processes invoice.payment_succeeded event.
     *
     * @since 1.12.6
     *
     * @param StripeEvent $event Stripe Event received via webhooks.
     *
     * @return void
     */
    public function processEvent($event)
    {
        $invoice = $event->data->object;
        $subscription = $this->getSubscription($event);

        // Exit if we did not find subscription for given webhook notification.
        if (!$subscription->id) {
            return;
        }

        /**
         * This action hook will be used to extend processing the invoice payment succeeded event.
         *
         * @since 1.9.4
         */
        do_action('give_recurring_stripe_process_invoice_payment_succeeded', $event);

        $totalPayments = (int)$subscription->get_total_payments();
        $billTimes = (int)$subscription->bill_times;

        // We can create renewal If:
        //  1. Subscription is ongoing
        //  2. bill_times is less than total payments.
        if ($this->shouldCreateRenewal($billTimes, $totalPayments)) {
            // Look to see if we have set the transaction ID on the parent payment yet.
            if (!$subscription->get_transaction_id()) {
                // This is the initial transaction payment aka first subscription payment.
                $subscription->set_transaction_id($invoice->charge);

                if ($this->isDonationCompleted($subscription->parent_payment_id)) {
                    give_update_payment_status($subscription->parent_payment_id, 'publish');
                }
            } else {
                $this->addRenewal($subscription, $invoice);
            }
        } else {
            $this->completeSubscriptionAndCancelOnStripe(
                $subscription,
                $totalPayments,
                $billTimes
            );
        }
    }

    /**
     * @since 1.15.0
     *
     * @param int $billTimes
     * @param int $totalPayments
     *
     * @return bool
     */
    private function shouldCreateRenewal($billTimes, $totalPayments)
    {
        return 0 === $billTimes || $totalPayments < $billTimes;
    }

    /**
     * @since 1.15.0
     *
     * @param int $subscriptionParentDonationId
     *
     * @return bool
     */
    private function isDonationCompleted($subscriptionParentDonationId)
    {
        $paymentStatus = give_get_payment_status($subscriptionParentDonationId);

        return in_array($paymentStatus, ['pending', 'processing'], true);
    }

    /**
     * @since 1.15.0
     *
     * @param Give_Subscription $subscription
     * @param object $invoice
     */
    private function addRenewal($subscription, $invoice)
    {
        $donationId = give_get_purchase_id_by_transaction_id($invoice->charge);

        // Check if donation id empty that means renewal donation not made so please create it.
        // We have a renewal.
        if (empty($donationId)) {
            $args = [
                'amount' => give_stripe_cents_to_dollars($invoice->total),
                'transaction_id' => $invoice->charge,
                'post_date' => date_i18n('Y-m-d H:i:s', $invoice->created),
            ];

            $subscription->add_payment($args);
            $subscription->renew();
        }

        $this->completeSubscriptionAndCancelOnStripe(
            $subscription,
            $subscription->get_total_payments(),
            $subscription->bill_times
        );
    }

    /**
     * @param StripeEvent $event
     *
     * @return Give_Subscription
     */
    private function getSubscription($event)
    {
        $subscription = new Give_Subscription(
            $event->data->object->subscription,
            true
        );

        if (!$subscription->id) {
            $donationMetaData = $event->data->object->lines->data[0]->metadata;
            $donationId = !empty($donationMetaData['Donation Post ID']) ? $donationMetaData['Donation Post ID'] : 0;
            $subscription = give_recurring_get_subscription_by( 'payment', $donationId );
        }

        return $subscription;
    }

    /**
     * @since 1.15.0
     * @param Give_Subscription $subscription
     * @param int $totalPayments
     * @param int $billTimes
     * @return void
     */
    private function completeSubscriptionAndCancelOnStripe(Give_Subscription $subscription, $totalPayments, $billTimes)
    {
        // If the billing cycle is completed for a subscription then we have to complete the subscription to prevent further payments on Stripe.
        // This function completes the subscription in the GiveWP database and cancels it on Stripe.
        give_recurring_stripe_is_subscription_completed(
            $subscription,
            $totalPayments,
            $billTimes
        );
    }
}
