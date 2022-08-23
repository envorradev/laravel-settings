<?php

namespace Envorra\LaravelSettings\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * SettingOwner
 *
 * @package Envorra\LaravelSettings\Contracts
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
