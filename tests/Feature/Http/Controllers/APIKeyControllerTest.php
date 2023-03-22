<?php

namespace Luchavez\ApiKeysVault\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * Class APIKeyControllerTest
 *
 * @author James Carlo Luchavez <jamescarloluchavez@gmail.com>
 */
class APIKeyControllerTest extends TestCase
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
