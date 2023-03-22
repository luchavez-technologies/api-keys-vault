<?php

namespace Luchavez\ApiKeysVault\Policies;

use App\Models\User;
use Luchavez\ApiKeysVault\Models\ApiKey;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

/**
 * Class ApiKeyPolicy
 *
 * @author James Carlo Luchavez <jamescarloluchavez@gmail.com>
 */
class ApiKeyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  ApiKey  $apiKey
     * @return Response|bool
     */
    public function view(User $user, ApiKey $apiKey): Response|bool
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  ApiKey  $apiKey
     * @return Response|bool
     */
    public function update(User $user, ApiKey $apiKey): Response|bool
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  ApiKey  $apiKey
     * @return Response|bool
     */
    public function delete(User $user, ApiKey $apiKey): Response|bool
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  ApiKey  $apiKey
     * @return Response|bool
     */
    public function restore(User $user, ApiKey $apiKey): Response|bool
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  ApiKey  $apiKey
     * @return Response|bool
     */
    public function forceDelete(User $user, ApiKey $apiKey): Response|bool
    {
        return Response::allow();
    }
}
