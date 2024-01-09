<?php

declare(strict_types=1);

use Aleksandr\SberbankAcquiring\Models\AcquiringPayment;
use Aleksandr\SberbankAcquiring\Models\SberbankPayment;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(SberbankPayment::class, function (Faker $faker) {
    return [
        'order_number' => Str::random(32),
        'amount' => $faker->numberBetween(),
        'currency' => $faker->numberBetween(100, 999),
        'return_url' => $faker->url,
        'fail_url' => $faker->url,
        'description' => $faker->sentence,
        'language' => $faker->languageCode,
        'client_id' => Str::random(20),
        'page_view' => $faker->randomElement(['MOBILE', 'DESKTOP']),
        'json_params' => json_encode([$faker->word => $faker->word, $faker->word => $faker->word]),
        'session_timeout_secs' => $faker->randomNumber(9),
        'expiration_date' => $faker->dateTimeBetween('+1 hour', '+2 hour'),
        'features' => Str::random('10'),
        'bank_form_url' => $faker->url,
    ];
});
