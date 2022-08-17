<?php

namespace TaylorNetwork\LaravelSettings\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use TaylorNetwork\LaravelSettings\Models\Setting;

/**
 * Trait HasSettings
 *
 * @package LaravelSettings
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
