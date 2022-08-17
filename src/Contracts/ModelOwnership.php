<?php

namespace TaylorNetwork\LaravelSettings\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Contract ModelOwnership
 *
 * @package TaylorNetwork\LaravelSettings
 */
interface ModelOwnership
{
    /**
     * Owner relation.
     *
     * @return MorphTo
     */
    public function owner(): MorphTo;

    /**
     * Is a Model the owner of this Model?
     *
     * @param Model $model
     * @return bool
     */
    public function belongsToModel(Model $model): bool;
}
