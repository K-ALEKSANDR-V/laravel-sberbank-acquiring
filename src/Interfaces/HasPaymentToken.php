<?php

declare(strict_types=1);

namespace Aleksandr\SberbankAcquiring\Interfaces;

interface HasPaymentToken
{
    /**
     * @param string $token
     *
     * @return mixed
     */
    public function setPaymentToken(string $token): void;

    /**
     * @return string
     */
    public function getPaymentToken(): ?string;
}
