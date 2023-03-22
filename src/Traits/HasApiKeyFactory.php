<?php

namespace Luchavez\ApiKeysVault\Traits;

use Luchavez\ApiKeysVault\Database\Factories\ApiKeyFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Trait HasApiKeyFactory
 *
 * @author James Carlo Luchavez <jamescarloluchavez@gmail.com>
 */
trait HasApiKeyFactory
{
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return ApiKeyFactory::new();
    }
}
