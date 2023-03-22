<?php

namespace Luchavez\ApiKeysVault\Models;

use Luchavez\ApiKeysVault\ApiKeysVault;
use Luchavez\ApiKeysVault\Traits\HasApiKeyFactory;
use Luchavez\StarterKit\Traits\UsesUUIDTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ApiKey
 *
 * @method static Builder package(ApiKeysVault|string $package)
 *
 * @author James Carlo Luchavez <jamescarloluchavez@gmail.com>
 */
class ApiKey extends Model
{
    use UsesUUIDTrait;
    use SoftDeletes;
    use HasApiKeyFactory;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vendor_name',
        'package_name',
        'config_key',
        'value',
        'hashed_value',
        'deleted_at',
        'expires_at',
    ];

    protected $casts = [
        'value' => AsCollection::class,
        'expires_at' => 'datetime',
    ];

    /********
     * RELATIONSHIPS
     ********/

    //

    /*****
     * ACCESSORS & MUTATORS
     *****/

    //

    /********
     * OTHER METHODS
     ********/

    /**
     * @param  Builder  $query
     * @param  ApiKeysVault|string  $package
     * @return Builder
     */
    public function scopePackage(Builder $query, ApiKeysVault|string $package): Builder
    {
        if (! $package instanceof ApiKeysVault) {
            $package = apiKeysVault($package);
        }

        return $query
            ->where('vendor_name', $package->getVendorName())
            ->where('package_name', $package->getPackageName())
            ->where('config_key', $package->getConfigKey());
    }
}
