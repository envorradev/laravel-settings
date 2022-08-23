<?php

namespace Envorra\LaravelSettings\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * HasOwner
 *
 * @package Envorra\LaravelSettings\Traits
 *
 * @property ?Model $model
 * @property Model  $owner
 * @property class-string $owner_type
 * @property int $owner_id
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

    /**
     * @inheritDoc
     */
    public function setOwner(Model $owner): static
    {
        if(!$this->exists && !empty($owner->id)) {
            $this->owner_type = get_class($owner);
            $this->owner_id = $owner->id;
        }
        return $this;
    }
}
