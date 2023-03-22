<?php

namespace Luchavez\ApiKeysVault;

use Luchavez\ApiKeysVault\Models\ApiKey;
use Luchavez\ApiKeysVault\Observers\ApiKeyObserver;
use Luchavez\ApiKeysVault\Policies\ApiKeyPolicy;
use Luchavez\ApiKeysVault\Repositories\ApiKeyRepository;
use Luchavez\StarterKit\Abstracts\BaseStarterKitServiceProvider as ServiceProvider;

class ApiKeysVaultServiceProvider extends ServiceProvider
{
    protected array $morph_map = [
        'api_key' => ApiKey::class,
    ];

    protected array $policy_map = [
        ApiKeyPolicy::class => ApiKey::class,
    ];

    protected array $repository_map = [
        ApiKeyRepository::class => ApiKey::class,
    ];

    protected array $observer_map = [
        ApiKeyObserver::class => ApiKey::class,
    ];

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        // Register the service the package provides.
        $this->app->bind(
            'api-keys-vault',
            function ($app, $params) {
                return new ApiKeysVault($params['package'], $params['config_key']);
            }
        );

        parent::register();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['api-keys-vault'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes(
            [
                __DIR__.'/../config/api-keys-vault.php' => config_path('api-keys-vault.php'),
            ],
            'api-keys-vault.config'
        );
    }
}
