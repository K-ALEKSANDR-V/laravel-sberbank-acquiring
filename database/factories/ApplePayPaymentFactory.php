<?php

declare(strict_types=1);

use Aleksandr\SberbankAcquiring\Models\AcquiringPayment;
use Aleksandr\SberbankAcquiring\Models\ApplePayPayment;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(ApplePayPayment::class, function (Faker $faker) {
    return [
        'order_number' => Str::random(32),
        'description' => $faker->sentence,
        'language' => $faker->languageCode,
        'additional_parameters' => json_encode([$faker->word => $faker->word, $faker->word => $faker->word]),
        'pre_auth' => $faker->randomElement(['true', 'false']),
        'payment_token' => Str::random(100),
    ];
});
