<?php

namespace Luchavez\ApiKeysVault\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * Class ApiKeyControllerTest
 *
 * @author James Carlo Luchavez <jamescarloluchavez@gmail.com>
 */
class ApiKeyControllerTest extends TestCase
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
