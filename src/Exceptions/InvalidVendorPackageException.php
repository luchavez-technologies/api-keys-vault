<?php

namespace Luchavez\ApiKeysVault\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class InvalidVendorPackageException
 *
 * @author James Carlo Luchavez <jamescarloluchavez@gmail.com>
 */
class InvalidVendorPackageException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        return customResponse()
            ->data([])
            ->message('Invalid package name. Vendor name and package name required.')
            ->generate();
    }
}
