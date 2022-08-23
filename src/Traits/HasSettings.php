<?php

namespace Envorra\LaravelSettings\Traits;

use Envorra\LaravelSettings\Models\Setting;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * HasSettings
 *
 * @package Envorra\LaravelSettings\Traits
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
