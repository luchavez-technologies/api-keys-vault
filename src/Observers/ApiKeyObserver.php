<?php

namespace Luchavez\ApiKeysVault\Observers;

use Luchavez\ApiKeysVault\Models\ApiKey;
use Illuminate\Support\Facades\Hash;

/**
 * Class ApiKeyObserver
 *
 * @author James Carlo Luchavez <jamescarloluchavez@gmail.com>
 */
class ApiKeyObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the ApiKey "created" event.
     *
     * @param  ApiKey  $apiKey
     * @return void
     */
    public function saving(ApiKey $apiKey): void
    {
        $apiKey->hashed_value = Hash::make($apiKey->value);
    }
}
