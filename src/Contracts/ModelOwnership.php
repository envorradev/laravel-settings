<?php

/** @noinspection PhpUnused */

namespace Envorra\LaravelSettings\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * ModelOwnership
 *
 * @package Envorra\LaravelSettings\Contracts
 */
interface ModelOwnership
{
    /**
     * Is a Model the owner of this Model?
     *
     * @param  Model  $model
     * @return bool
     */
    public function belongsToModel(Model $model): bool;

    /**
     * Does the model have an owner?
     *
     * @return bool
     */
    public function hasOwner(): bool;

    /**
     * Owner relation.
     *
     * @return MorphTo
     */
    public function owner(): MorphTo;

    /**
     * Set the owner of the model if new.
     *
     * @param  Model  $owner
     * @return $this
     */
    public function setOwner(Model $owner): static;
}
