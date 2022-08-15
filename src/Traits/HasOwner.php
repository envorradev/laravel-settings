<?php

namespace TaylorNetwork\LaravelSettings\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property ?Model $owner
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
