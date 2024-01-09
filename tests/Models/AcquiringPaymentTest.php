<?php

declare(strict_types=1);

namespace Aleksandr\SberbankAcquiring\Tests\Models;

use Aleksandr\SberbankAcquiring\Models\ApplePayPayment;
use Aleksandr\SberbankAcquiring\Models\AcquiringPaymentStatus;
use Aleksandr\SberbankAcquiring\Models\AcquiringPaymentSystem;
use Aleksandr\SberbankAcquiring\Models\GooglePayPayment;
use Aleksandr\SberbankAcquiring\Models\SamsungPayPayment;
use Aleksandr\SberbankAcquiring\Models\SberbankPayment;
use Aleksandr\SberbankAcquiring\Tests\TestCase;

class AcquiringPaymentTest extends TestCase
{
    /**
     * @test
     */
    public function it_has_operations_relation()
    {
        $acquiringPayment = $this->createAcquiringPayment();
        $acquiringPaymentOperation = $this->createAcquiringPaymentOperation(['payment_id' => $acquiringPayment->id]);

        $this->assertTrue($acquiringPayment->operations->contains($acquiringPaymentOperation));
        $this->assertEquals(1, $acquiringPayment->operations->count());
    }

    /**
     * @test
     */
    public function it_has_system_relation()
    {
        $acquiringPayment = $this->createAcquiringPayment();

        $this->assertInstanceOf(AcquiringPaymentSystem::class, $acquiringPayment->system);
    }

    /**
     * @test
     */
    public function it_has_status_relation()
    {
        $acquiringPayment = $this->createAcquiringPayment();

        $this->assertInstanceOf(AcquiringPaymentStatus::class, $acquiringPayment->status);
    }

    /**
     * @test
     */
    public function it_has_sberbank_payment_morph_relation()
    {
        $acquiringPayment = $this->createAcquiringPayment([]);

        $payment = $acquiringPayment->payment;
        $this->assertInstanceOf(SberbankPayment::class, $payment);
    }

    /**
     * @test
     */
    public function it_has_apple_pay_payment_morph_relation()
    {
        $acquiringPayment = $this->createAcquiringPayment([], 'applePay');

        $payment = $acquiringPayment->payment;
        $this->assertInstanceOf(ApplePayPayment::class, $payment);
    }

    /**
     * @test
     */
    public function it_has_samsung_pay_payment_morph_relation()
    {
        $acquiringPayment = $this->createAcquiringPayment([], 'samsungPay');

        $payment = $acquiringPayment->payment;
        $this->assertInstanceOf(SamsungPayPayment::class, $payment);
    }

    /**
     * @test
     */
    public function it_has_google_pay_payment_morph_relation()
    {
        $acquiringPayment = $this->createAcquiringPayment([], 'googlePay');

        $payment = $acquiringPayment->payment;
        $this->assertInstanceOf(GooglePayPayment::class, $payment);
    }
}
