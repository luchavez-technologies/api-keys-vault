<?php

namespace Luchavez\ApiKeysVault\Http\Controllers;

use Luchavez\ApiKeysVault\Events\ApiKey\ApiKeyArchived;
use Luchavez\ApiKeysVault\Events\ApiKey\ApiKeyCollected;
use Luchavez\ApiKeysVault\Events\ApiKey\ApiKeyCreated;
// Model
use Luchavez\ApiKeysVault\Events\ApiKey\ApiKeyRestored;
// Requests
use Luchavez\ApiKeysVault\Events\ApiKey\ApiKeyShown;
use Luchavez\ApiKeysVault\Events\ApiKey\ApiKeyUpdated;
use Luchavez\ApiKeysVault\Http\Requests\ApiKey\DeleteApiKey;
use Luchavez\ApiKeysVault\Http\Requests\ApiKey\IndexApiKey;
use Luchavez\ApiKeysVault\Http\Requests\ApiKey\RestoreApiKey;
use Luchavez\ApiKeysVault\Http\Requests\ApiKey\ShowApiKey;
// Events
use Luchavez\ApiKeysVault\Http\Requests\ApiKey\StoreApiKey;
use Luchavez\ApiKeysVault\Http\Requests\ApiKey\UpdateApiKey;
use Luchavez\ApiKeysVault\Models\ApiKey;
use Luchavez\ApiKeysVault\Repositories\ApiKeyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class ApiKeyController
 *
 * @author James Carlo Luchavez <jamescarloluchavez@gmail.com>
 */
class ApiKeyController extends Controller
{
    public function __construct(public ApiKeyRepository $apiKeyRepository)
    {
    }

    /**
     * ApiKey List
     *
     * @group ApiKey Management
     *
     * @param  IndexApiKey  $request
     * @return JsonResponse
     */
    public function index(IndexApiKey $request): JsonResponse
    {
        $data = new ApiKey();

        if ($request->has('full_data') === true) {
            $data = $data->get();
        } else {
            $data = $data->simplePaginate($request->get('per_page', 15));
        }

        event(new ApiKeyCollected($data));

        return customResponse()
            ->data($data)
            ->message('Successfully collected record.')
            ->success()
            ->generate();
    }

    /**
     * Create ApiKey
     *
     * @group ApiKey Management
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = $request->all();

        $model = ApiKey::create($data)->fresh();

        event(new ApiKeyCreated($model));

        return customResponse()
            ->data($model)
            ->message('Successfully created record.')
            ->success()
            ->generate();
    }

    /**
     * Store ApiKey
     *
     * @group ApiKey Management
     *
     * @param  StoreApiKey  $request
     * @return JsonResponse
     */
    public function store(StoreApiKey $request): JsonResponse
    {
        $data = $request->all();

        $model = ApiKey::create($data)->fresh();

        event(new ApiKeyCreated($model));

        return customResponse()
            ->data($model)
            ->message('Successfully created record.')
            ->success()
            ->generate();
    }

    /**
     * Show ApiKey
     *
     * @group ApiKey Management
     *
     * @param  ShowApiKey  $request
     * @param  ApiKey  $apiKey
     * @return JsonResponse
     */
    public function show(ShowApiKey $request, ApiKey $apiKey): JsonResponse
    {
        event(new ApiKeyShown($apiKey));

        return customResponse()
            ->data($apiKey)
            ->message('Successfully collected record.')
            ->success()
            ->generate();
    }

    /**
     * Edit ApiKey
     *
     * @group ApiKey Management
     *
     * @param  Request  $request
     * @param  ApiKey  $apiKey
     * @return JsonResponse
     */
    public function edit(Request $request, ApiKey $apiKey): JsonResponse
    {
        // Logic here...

        event(new ApiKeyUpdated($apiKey));

        return customResponse()
            ->data($apiKey)
            ->message('Successfully updated record.')
            ->success()
            ->generate();
    }

    /**
     * Update ApiKey
     *
     * @group ApiKey Management
     *
     * @param  UpdateApiKey  $request
     * @param  ApiKey  $apiKey
     * @return JsonResponse
     */
    public function update(UpdateApiKey $request, ApiKey $apiKey): JsonResponse
    {
        // Logic here...

        event(new ApiKeyUpdated($apiKey));

        return customResponse()
            ->data($apiKey)
            ->message('Successfully updated record.')
            ->success()
            ->generate();
    }

    /**
     * Archive ApiKey
     *
     * @group ApiKey Management
     *
     * @param  DeleteApiKey  $request
     * @param  ApiKey  $apiKey
     * @return JsonResponse
     */
    public function destroy(DeleteApiKey $request, ApiKey $apiKey): JsonResponse
    {
        $apiKey->delete();

        event(new ApiKeyArchived($apiKey));

        return customResponse()
            ->data($apiKey)
            ->message('Successfully archived record.')
            ->success()
            ->generate();
    }

    /**
     * Restore ApiKey
     *
     * @group ApiKey Management
     *
     * @param  RestoreApiKey  $request
     * @param    $apiKey
     * @return JsonResponse
     */
    public function restore(RestoreApiKey $request, $apiKey): JsonResponse
    {
        $data = ApiKey::withTrashed()->find($apiKey)->restore();

        event(new ApiKeyRestored($data));

        return customResponse()
            ->data($data)
            ->message('Successfully restored record.')
            ->success()
            ->generate();
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function rollback(Request $request): JsonResponse
    {
        return customResponse()
            ->data([])
            ->message('Rolled back to previous keys.')
            ->success()
            ->generate();
    }
}
