<?php

namespace TaylorNetwork\LaravelSettings\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * SettingOwner
 *
 * @package TaylorNetwork\LaravelSettings
 */
interface SettingOwner
{
    /**
     * This Model's settings.
     *
     * @return MorphMany
     */
    public function settings(): MorphMany;
}
