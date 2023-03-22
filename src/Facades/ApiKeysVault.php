<?php

namespace Luchavez\ApiKeysVault\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ApiKeysVault
 *
 * @author James Carlo Luchavez <jamescarloluchavez@gmail.com>
 *
 * @since  2022-01-17
 * @see \Luchavez\ApiKeysVault\ApiKeysVault
 */
class ApiKeysVault extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'api-keys-vault';
    }
}
