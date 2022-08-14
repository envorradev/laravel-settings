<?php

namespace TaylorNetwork\LaravelSettings\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use TaylorNetwork\LaravelSettings\Models\Setting;

trait HasSettings
{
    public function settings(): MorphMany
    {
        return $this->morphMany(Setting::class, 'owner');
    }
}
