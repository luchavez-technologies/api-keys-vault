<?php

namespace Luchavez\ApiKeysVault\Feature\Models;

use Tests\TestCase;

/**
 * Class ApiKeyTest
 *
 * @author James Carlo Luchavez <jamescarloluchavez@gmail.com>
 */
class ApiKeyTest extends TestCase
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
