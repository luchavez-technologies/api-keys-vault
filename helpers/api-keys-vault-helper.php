<?php

/**
 * @author James Carlo Luchavez <jamescarloluchavez@gmail.com>
 *
 * @since  2021-12-02
 */

use Luchavez\ApiKeysVault\ApiKeysVault;

if (! function_exists('apiKeysVault')) {
    /**
     * @param  string  $package
     * @param  string|null  $config_key
     * @return ApiKeysVault
     */
    function apiKeysVault(string $package, ?string $config_key = null): ApiKeysVault
    {
        return resolve(
            'api-keys-vault',
            [
                'package' => $package,
                'config_key' => $config_key,
            ]
        );
    }
}

if (! function_exists('api_keys_vault')) {
    /**
     * @param  string  $package
     * @param  string|null  $config_key
     * @return ApiKeysVault
     */
    function api_keys_vault(string $package, ?string $config_key = null): ApiKeysVault
    {
        return apiKeysVault($package, $config_key);
    }
}
