<?php

declare(strict_types=1);

use Aleksandr\SberbankAcquiring\Models\AcquiringPayment;
use Aleksandr\SberbankAcquiring\Models\GooglePayPayment;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(GooglePayPayment::class, function (Faker $faker) {
    return [
        'order_number' => Str::random(32),
        'description' => $faker->sentence,
        'language' => $faker->languageCode,
        'additional_parameters' => json_encode([$faker->word => $faker->word, $faker->word => $faker->word]),
        'pre_auth' => $faker->randomElement(['true', 'false']),
        'client_id' => Str::random(30),
        'ip' => $faker->ipv6,
        'amount' => $faker->numberBetween(),
        'currency_code' => (string)$faker->numberBetween(100, 999),
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'return_url' => $faker->url,
        'fail_url' => $faker->url,
        'payment_token' => Str::random(100),
    ];
});
