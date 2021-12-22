<?php

namespace GiveRecurring\PaymentGateways\AuthorizeNet\Actions;

/**
 * @since 1.13.0
 */
class EditSubscriptionTransactionRequestArgs
{
    /**
     * @since 1.13.0
     *
     * @param array $transactionRequestArgs
     *
     * @return array AuthorizeNet subscription request arguments.
     */
    public function __invoke(array $transactionRequestArgs)
    {
        $totalOccurrences = $transactionRequestArgs['subscription']['paymentSchedule']['totalOccurrences'];
        $startDate        = $transactionRequestArgs['subscription']['paymentSchedule']['startDate'];
        $frequency        = $transactionRequestArgs['subscription']['paymentSchedule']['interval']['length'];
        $interval         = $transactionRequestArgs['subscription']['paymentSchedule']['interval']['unit'];
        $newStartDate     = date('Y-m-d', strtotime("+ {$frequency} {$interval}", strtotime($startDate)));

        $transactionRequestArgs['subscription']['paymentSchedule']['totalOccurrences'] = $totalOccurrences - 1;
        $transactionRequestArgs['subscription']['paymentSchedule']['startDate']        = $newStartDate;

        return $transactionRequestArgs;
    }
}
