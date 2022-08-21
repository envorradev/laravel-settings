<?php

namespace TaylorNetwork\LaravelSettings\Traits;

use TaylorNetwork\LaravelSettings\Models\Setting;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * HasSettings
 *
 * @package TaylorNetwork\LaravelSettings
 */
trait HasSettings
{
    /**
     * Model has settings.
     *
     * @return MorphMany
     */
    public function settings(): MorphMany
    {
        return $this->morphMany(Setting::class, 'owner');
    }
}
