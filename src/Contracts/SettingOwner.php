<?php

namespace TaylorNetwork\LaravelSettings\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface SettingOwner
{
    /**
     * This Model's settings.
     *
     * @return MorphMany
     */
    public function settings(): MorphMany;
}
