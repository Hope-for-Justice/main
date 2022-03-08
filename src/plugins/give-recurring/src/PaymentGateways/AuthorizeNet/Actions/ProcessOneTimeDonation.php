<?php

namespace GiveRecurring\PaymentGateways\AuthorizeNet\Actions;

use Give_Recurring_Authorize;
use Give_Recurring_Authorize_eCheck;
use Give_Recurring_Gateway;
use GiveAuthorizeNet\AuthorizeNet\DataTransferObjects\DonationData;
use GiveAuthorizeNet\AuthorizeNet\PaymentProcessors\BankAccountProcessor;
use GiveAuthorizeNet\AuthorizeNet\PaymentProcessors\CreditCardProcessor;
use GiveRecurring\Infrastructure\Log;

/**
 * @since 1.13.0
 */
class ProcessOneTimeDonation
{
    /**
     * @since 1.13.0
     * @unreleased Redirect back to donation form with error notice on payment failure.
     *
     * @param Give_Recurring_Authorize|Give_Recurring_Authorize_eCheck $recurringAuthorizeNet
     */
    public function __invoke(Give_Recurring_Gateway $recurringAuthorizeNet)
    {
        if (
            give_get_errors() ||
            !in_array($recurringAuthorizeNet->id, ['authorize_echeck', 'authorize'])
        ) {
            return;
        }

        // Authorize.net does not process initial payment immediately for subscription. It can take a day or few hours.
        // To provide immediate donation feedback to donor, initial payment process as onetime donation.
        // link: https://developer.authorize.net/api/reference/features/recurring_billing.html#Payment_Schedule

        try {
            $processor = 'authorize_echeck' === $recurringAuthorizeNet->id
                ? give(BankAccountProcessor::class)
                : give(CreditCardProcessor::class);

            $paymentResponse = $processor->process(DonationData::fromArray($recurringAuthorizeNet->purchase_data));

            if ($paymentResponse->isTransactionCompleted()) {
                give_update_payment_status($recurringAuthorizeNet->payment_id, 'publish');
                give_set_payment_transaction_id(
                    $recurringAuthorizeNet->payment_id,
                    $paymentResponse->getTransactionId()
                );
                $recurringAuthorizeNet->subscriptions['status'] = 'active';
            } elseif ($paymentResponse->isHeldForReview()) {
                give_set_payment_transaction_id(
                    $recurringAuthorizeNet->payment_id,
                    $paymentResponse->getTransactionId()
                );
                give_insert_payment_note(
                    $recurringAuthorizeNet->payment_id,
                    __(
                        'Authorize.net transaction flagged this donation through the fraud filter. Please approve or void this transaction within your Authorize.net merchant dashboard.',
                        'give-recurring'
                    )
                );
            } else {
                $errorCode = $paymentResponse->getErrorCode();
                $errorText = $paymentResponse->getErrorText();

                if (!empty($errorCode) && '17' === $errorCode) {
                    $errorMessage = esc_html__(
                        'The subscription could not be charged because the type of credit card used is not accepted. Please try again with a supported card type.',
                        'give-recurring'
                    );
                } else {
                    // Not approved. An error with the payment.
                    $errorMessage = !empty($errorText) ?
                        $errorText :
                        __(
                            'The transaction has been declined.',
                            'give-recurring'
                        );
                    $errorMessage = sprintf(
                        esc_html__('The donation could not be charged. Please try again. Reason: %s', 'give-recurring'),
                        $errorMessage
                    );
                }

                give_set_error('authorize_request_error', $errorMessage);
                Log::error('Authorize.net Error', ['error' => $errorMessage]);
            }
        } catch (\Exception $e) {
            give_set_error(
                'authorize_request_error',
                esc_html__('The donation could not be charged. Please try again.', 'give-recurring')
            );
            Log::error('Authorize.net Error', ['error' => $e->getMessage()]);
        }

        if (give_get_errors()) {
            give_update_payment_status($recurringAuthorizeNet->payment_id, 'failed');
            give_send_back_to_checkout('?payment-mode=' . $recurringAuthorizeNet->id);
        }
    }

}
