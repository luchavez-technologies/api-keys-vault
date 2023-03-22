<?php

namespace Luchavez\ApiKeysVault;

use Luchavez\ApiKeysVault\Exceptions\InvalidVendorPackageException;
use Luchavez\ApiKeysVault\Models\ApiKey;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use JsonException;

class ApiKeysVault
{
    /**
     * @var string|null
     */
    protected ?string $vendor_name = null;

    /**
     * @var string|null
     */
    protected ?string $package_name = null;

    /**
     * @var array|null
     */
    protected ?array $cache_tags = null;

    /**
     * @param  string  $package
     * @param  string|null  $config_key
     *
     * @throws InvalidVendorPackageException
     */
    public function __construct(protected string $package, protected ?string $config_key = null)
    {
        $this->setVendorAndPackageName($package);
        $this->setCacheTags();
    }

    /*****
     * GETTERS & SETTERS
     *****/

    /**
     * @param  string  $package
     *
     * @throws InvalidVendorPackageException
     */
    private function setVendorAndPackageName(string $package): void
    {
        if (count($temp = explode('/', $package)) === 2) {
            [$this->vendor_name, $this->package_name] = $temp;
        } else {
            throw new InvalidVendorPackageException();
        }
    }

    private function setCacheTags(): void
    {
        if ($this->getVendorName() && $this->getPackageName()) {
            $this->cache_tags = [$this->getVendorName(), $this->getPackageName()];

            if ($this->getConfigKey()) {
                $this->cache_tags[] = $this->getConfigKey();
            }
        }
    }

    /**
     * @return string
     */
    public function getPackageName(): string
    {
        return $this->package_name;
    }

    /**
     * @return string
     */
    public function getVendorName(): string
    {
        return $this->vendor_name;
    }

    /**
     * @return string|null
     */
    public function getConfigKey(): ?string
    {
        return $this->config_key;
    }

    /**
     * @return array|null
     */
    public function getCacheTags(): ?array
    {
        return $this->cache_tags;
    }

    /**
     * @param  string|null  $key
     * @return mixed
     */
    public function getConfig(string $key = null): mixed
    {
        return config(
            $this->package_name.($this->getConfigKey() ? '.'.$this->getConfigKey() : '').($key ? '.'.$key : ''),
            []
        );
    }

    /**
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return ApiKey::package($this);
    }

    /**
     * @return ApiKey|null
     */
    public function getKey(): ?ApiKey
    {
        return Cache::tags($this->getCacheTags())->get('keys');
    }

    /*****
     * OTHER FUNCTIONS
     *****/

    /**
     * @param  AbstractApiIntegration|null  $integration
     * @return bool
     *
     * @throws JsonException
     */
    public function sync(AbstractApiIntegration $integration = null): bool
    {
        // Get package keys from config
        $config = collect($this->getConfig());

        // Get latest package keys from database
        $latest = $this->getQuery()->latest()->first();

        // Prepare the $healthChecker anonymous function
        $healthChecker = static function (ApiKey $apiKey) use ($integration) {
            if ($integration) {
                return $integration->healthCheck($apiKey);
            }

            return true;
        };

        // Prepare the $apiKeyCacher anonymous function
        $apiKeyCacher = function (ApiKey $apiKey) use ($integration) {
            $apiKey->save();
            $expiresAt = $integration?->getExpirationDate($apiKey);

            return Cache::tags($this->getCacheTags())->put('keys', $apiKey, $expiresAt);
        };

        // Check if latest key exists and is an instance of ApiKey
        if ($latest instanceof ApiKey) {
            // Get hashed value of latest key
            $hashedValue = $latest->hashed_value;

            // Check if `config` key matches the latest key by hash check then check if it passes health check
            if ($hashedValue && Hash::check(collection_encode($config), $hashedValue) && $healthChecker($latest)) {
                return $apiKeyCacher($latest);
            }
        }

        // If latest key does not exist, or if it failed health check, treat config as latest key
        $latest = $this->syncConfigToDatabase();

        return $healthChecker($latest) && $apiKeyCacher($latest);
    }

    /**
     * Make package's `env` variable as ApiKey instance.
     */
    public function syncConfigToDatabase(): ApiKey
    {
        $key = new ApiKey();
        $key->vendor_name = $this->getVendorName();
        $key->package_name = $this->getPackageName();
        $key->config_key = $this->getConfigKey();
        $key->value = collect($this->getConfig());

        return $key;
    }
}
