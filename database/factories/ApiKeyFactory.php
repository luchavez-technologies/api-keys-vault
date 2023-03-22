<?php

namespace Luchavez\ApiKeysVault\Database\Factories;

// Model
use Luchavez\ApiKeysVault\Models\ApiKey;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class ApiKeyFactory
 *
 * @author James Carlo Luchavez <jamescarloluchavez@gmail.com>
 */
class ApiKeyFactory extends Factory
{
    protected $model = ApiKey::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
