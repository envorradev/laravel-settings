<?php

namespace TaylorNetwork\LaravelSettings\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Trait HasOwner
 *
 * @package TaylorNetwork\LaravelSettings
 *
 * @property ?Model $model
 */
trait HasOwner
{
    /**
     * @inheritDoc
     */
    public function belongsToModel(Model $model): bool
    {
        return $this->owner === $model;
    }

    /**
     * @inheritDoc
     */
    public function owner(): MorphTo
    {
        return $this->morphTo();
    }
}
