<?php

namespace Envorra\LaravelSettings\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * HasOwner
 *
 * @package Envorra\LaravelSettings
 *
 * @property ?Model $model
 * @property Model  $owner
 */
trait HasOwner
{
    /**
     * @inheritDoc
     */
    public function belongsToModel(Model $model): bool
    {
        return !empty($this->owner?->id) && !empty($model->id) && $this->owner->id === $model->id;
    }

    /**
     * @inheritDoc
     */
    public function owner(): MorphTo
    {
        return $this->morphTo();
    }
}
