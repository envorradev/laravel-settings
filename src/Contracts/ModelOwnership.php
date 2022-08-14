<?php

namespace TaylorNetwork\LaravelSettings\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

interface ModelOwnership
{
    public function owner(): MorphTo;

    public function belongsToModel(Model $model): bool;
}
