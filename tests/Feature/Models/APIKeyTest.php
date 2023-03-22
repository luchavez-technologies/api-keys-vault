<?php

namespace Luchavez\ApiKeysVault\Feature\Models;

use Tests\TestCase;

/**
 * Class APIKeyTest
 *
 * @author James Carlo Luchavez <jamescarloluchavez@gmail.com>
 */
class APIKeyTest extends TestCase
{
    /**
     * Example Test
     *
     * @test
     */
    public function example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
