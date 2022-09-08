<?php

namespace Envorra\LaravelSettings\Traits;

use Illuminate\Database\Eloquent\Model;
use Envorra\LaravelSettings\Helpers\ConfigHelper;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * OwnsSettings
 *
 * @package Envorra\LaravelSettings\Traits
 *
 * @mixin Model
 */
trait OwnsSettings
{
    /**
     * @inheritDoc
     */
    public function settings(): MorphMany
    {
        return $this->morphMany(ConfigHelper::model(), ConfigHelper::ownerRelation());
    }
}
