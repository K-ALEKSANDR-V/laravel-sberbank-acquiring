<?php

declare(strict_types=1);

namespace Aleksandr\SberbankAcquiring\Factories;

use Aleksandr\SberbankAcquiring\Models\AcquiringPayment;
use Aleksandr\SberbankAcquiring\Models\AcquiringPaymentOperation;
use Aleksandr\SberbankAcquiring\Models\SberbankPayment;
use Aleksandr\SberbankAcquiring\Models\ApplePayPayment;
use Aleksandr\SberbankAcquiring\Models\GooglePayPayment;
use Aleksandr\SberbankAcquiring\Models\SamsungPayPayment;

class PaymentsFactory
{
    /**
     * @return AcquiringPayment
     */
    public function createAcquiringPayment(): AcquiringPayment
    {
        return new AcquiringPayment();
    }

    /**
     * @return SberbankPayment
     */
    public function createSberbankPayment(): SberbankPayment
    {
        return new SberbankPayment();
    }

    /**
     * @return ApplePayPayment
     */
    public function createApplePayPayment(): ApplePayPayment
    {
        return new ApplePayPayment();
    }

    /**
     * @return SamsungPayPayment
     */
    public function createSamsungPayPayment(): SamsungPayPayment
    {
        return new SamsungPayPayment();
    }

    /**
     * @return GooglePayPayment
     */
    public function createGooglePayPayment(): GooglePayPayment
    {
        return new GooglePayPayment();
    }

    /**
     * @return AcquiringPaymentOperation
     */
    public function createPaymentOperation(): AcquiringPaymentOperation
    {
        return new AcquiringPaymentOperation();
    }
}
