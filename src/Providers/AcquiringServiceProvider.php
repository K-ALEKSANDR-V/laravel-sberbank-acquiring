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
use Aleksandr\SberbankAcquiring\Traits\HasConfig;
use Illuminate\Support\ServiceProvider;

class AcquiringServiceProvider extends ServiceProvider
{
    use HasConfig;

    /**
     * Migration list
     *
     * @var array
     */
    public $migrations = [
        [
            'table' => 'payment_operation_types',
            'file' => 'create_acquiring_payment_operation_types_table.php'
        ],
        [
            'table' => 'payment_statuses',
            'file' => 'create_acquiring_payment_statuses_table.php'
        ],
        [
            'table' => 'payment_systems',
            'file' => 'create_acquiring_payment_systems_table.php'
        ],
        [
            'table' => 'payments',
            'file' => 'create_acquiring_payments_table.php'
        ],
        [
            'table' => 'payment_operations',
            'file' => 'create_acquiring_payment_operations_table.php'
        ],
        [
            'table' => 'sberbank_payments',
            'file' => 'create_acquiring_sberbank_payments_table.php'
        ],
        [
            'table' => 'apple_pay_payments',
            'file' => 'create_acquiring_apple_pay_payments_table.php'
        ],
        [
            'table' => 'samsung_pay_payments',
            'file' => 'create_acquiring_samsung_pay_payments_table.php'
        ],
        [
            'table' => 'google_pay_payments',
            'file' => 'create_acquiring_google_pay_payments_table.php'
        ],
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/sberbank-acquiring.php',
            'sberbank-acquiring'
        );

        $this->app->register(EventServiceProvider::class);

        $this->registerBindings();

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

        $date = date('Y_m_d_His', time());
        foreach ($this->migrations as $index => $migration) {
            $tableName = $this->getTableName($migration['table']);
            $timestamp = substr($date, 0, -1) . $index;
            $this->publishes([
                __DIR__ . '/../../database/migrations/' . $migration['file'] => database_path("/migrations/{$timestamp}_create_{$tableName}_table.php"),
            ], 'migrations');
        }
    }

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
