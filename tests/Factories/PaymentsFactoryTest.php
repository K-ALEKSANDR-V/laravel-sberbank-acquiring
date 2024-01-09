<?php

declare(strict_types=1);

namespace Aleksandr\SberbankAcquiring\Tests\Factories;

use Aleksandr\SberbankAcquiring\Factories\PaymentsFactory;
use Aleksandr\SberbankAcquiring\Models\AcquiringPayment;
use Aleksandr\SberbankAcquiring\Models\AcquiringPaymentOperation;
use Aleksandr\SberbankAcquiring\Models\ApplePayPayment;
use Aleksandr\SberbankAcquiring\Models\AcquiringPaymentOperationType;
use Aleksandr\SberbankAcquiring\Models\AcquiringPaymentStatus;
use Aleksandr\SberbankAcquiring\Models\AcquiringPaymentSystem;
use Aleksandr\SberbankAcquiring\Models\GooglePayPayment;
use Aleksandr\SberbankAcquiring\Models\SamsungPayPayment;
use Aleksandr\SberbankAcquiring\Models\SberbankPayment;
use Aleksandr\SberbankAcquiring\Tests\TestCase;

class PaymentsFactoryTest extends TestCase
{
    /**
     * @var PaymentsFactory
     */
    private $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new PaymentsFactory();
    }

    /**
     * @test
     */
    public function it_creates_new_acquiring_payment_model()
    {
        $acquiringPayment = $this->factory->createAcquiringPayment();

        $this->assertInstanceOf(AcquiringPayment::class, $acquiringPayment);
        $this->assertFalse($acquiringPayment->exists);
    }

    /**
     * @test
     */
    public function it_creates_new_sberbank_payment_model()
    {
        $sberbankPayment = $this->factory->createSberbankPayment();

        $this->assertInstanceOf(SberbankPayment::class, $sberbankPayment);
        $this->assertFalse($sberbankPayment->exists);
    }

    /**
     * @test
     */
    public function it_creates_new_apple_pay_payment_model()
    {
        $applePayPayment = $this->factory->createApplePayPayment();

        $this->assertInstanceOf(ApplePayPayment::class, $applePayPayment);
        $this->assertFalse($applePayPayment->exists);
    }

    /**
     * @test
     */
    public function it_creates_new_samsung_pay_payment_model()
    {
        $samsungPayPayment = $this->factory->createSamsungPayPayment();

        $this->assertInstanceOf(SamsungPayPayment::class, $samsungPayPayment);
        $this->assertFalse($samsungPayPayment->exists);
    }

    /**
     * @test
     */
    public function it_creates_new_google_pay_payment_model()
    {
        $googlePayPayment = $this->factory->createGooglePayPayment();

        $this->assertInstanceOf(GooglePayPayment::class, $googlePayPayment);
        $this->assertFalse($googlePayPayment->exists);
    }

    /**
     * @test
     */
    public function it_creates_acquiring_payment_operation_model()
    {
        $operation = $this->factory->createPaymentOperation();

        $this->assertInstanceOf(AcquiringPaymentOperation::class, $operation);
        $this->assertFalse($operation->exists);
    }
}
