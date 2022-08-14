<?php

namespace TaylorNetwork\LaravelSettings\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface SettingOwner
{
    public function settings(): MorphMany;
}
