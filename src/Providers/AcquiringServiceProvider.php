<?php

namespace Aleksandr\SberbankAcquiring\Providers;

use Aleksandr\SberbankAcquiring\Client\ApiClient;
use Aleksandr\SberbankAcquiring\Client\ApiClientInterface;
use Aleksandr\SberbankAcquiring\Client\Client;
use Aleksandr\SberbankAcquiring\Client\Curl\Curl;
use Aleksandr\SberbankAcquiring\Client\Curl\CurlInterface;
use Aleksandr\SberbankAcquiring\Client\HttpClient;
use Aleksandr\SberbankAcquiring\Client\HttpClientInterface;
use Aleksandr\SberbankAcquiring\Commands\UpdateStatusCommand;
use Aleksandr\SberbankAcquiring\Factories\PaymentsFactory;
use Aleksandr\SberbankAcquiring\Models\AcquiringPayment;
use Aleksandr\SberbankAcquiring\Models\AcquiringPaymentStatus;
use Aleksandr\SberbankAcquiring\Repositories\AcquiringPaymentRepository;
use Aleksandr\SberbankAcquiring\Repositories\AcquiringPaymentStatusRepository;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class AcquiringServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/sberbank-acquiring.php',
            'sberbank-acquiring'
        );

        $this->app->register(EventServiceProvider::class);

        $this->registerBindings();

//        $this->registerEloquentFactories();

        $this->registerCommands();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/sberbank-acquiring.php' => config_path('sberbank-acquiring.php'),
        ], 'config');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    /**
     * Регистрация фабрик
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
//    private function registerEloquentFactories()
//    {
//        $factory = $this->app->make(Factory::class);
//        $factory->load(base_path('vendor/team-kotik/laravel-sberbank-acquiring/database/factories'));
//    }

    /**
     * Регистрация биндингов
     */
    private function registerBindings()
    {
        $this->app->bind(CurlInterface::class, Curl::class);
        $this->app->bind(HttpClientInterface::class, HttpClient::class);
        $this->app->bind(ApiClientInterface::class, function ($app) {
            $httpClient = $app->make(HttpClientInterface::class);
            return new ApiClient(['httpClient' => $httpClient]);
        });
        $this->app->singleton(PaymentsFactory::class, function ($app) {
            return new PaymentsFactory();
        });
        $this->app->singleton(AcquiringPaymentRepository::class, function ($app) {
            return new AcquiringPaymentRepository(new AcquiringPayment());
        });
        $this->app->singleton(AcquiringPaymentStatusRepository::class, function ($app) {
            return new AcquiringPaymentStatusRepository(new AcquiringPaymentStatus());
        });
        $this->app->bind(Client::class, Client::class);
    }

    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                UpdateStatusCommand::class,
            ]);
        }
    }
}
