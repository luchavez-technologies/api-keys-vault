<?php

namespace Luchavez\ApiKeysVault;

use Carbon\Carbon;
use DateInterval;
use DateTimeInterface;
use Luchavez\ApiKeysVault\Models\ApiKey;

/**
 * Class AbstractApiIntegration
 *
 * @author James Carlo Luchavez <jamescarloluchavez@gmail.com>
 *
 * @since  2021-12-03
 */
abstract class AbstractApiIntegration
{
    protected Carbon|DateInterval|DateTimeInterface|int|null $expirationDate;

    /**
     * Check if the API Key will really connect to the Third Party API.
     *
     * Note: Do not expect `id` and `uuid` of $apiKey to be usable yet since it might not be persisted to database.
     *
     * @param  ApiKey  $apiKey
     * @return bool
     */
    abstract public function healthCheck(ApiKey $apiKey): bool;

    /**
     * Set Expiration Date of Keys
     *
     * @param  Carbon|DateInterval|DateTimeInterface|int|null  $expirationDate
     */
    public function setExpirationDate(Carbon|DateInterval|DateTimeInterface|int|null $expirationDate): void
    {
        $this->expirationDate = $expirationDate;
    }

    /**
     * Get Expiration Date of Keys
     *
     * @param  ApiKey|null  $apiKey
     * @return Carbon|DateInterval|DateTimeInterface|int|null
     */
    public function getExpirationDate(ApiKey $apiKey = null): Carbon|DateInterval|DateTimeInterface|int|null
    {
        return $this->expirationDate;
    }
}
