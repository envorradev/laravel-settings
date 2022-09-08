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
     * @return MorphMany
     */
    public function settings(): MorphMany;
}
