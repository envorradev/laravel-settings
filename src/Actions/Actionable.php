<?php

namespace Envorra\LaravelSettings\Actions;

use Illuminate\Database\Eloquent\Model;
use Envorra\LaravelSettings\Contracts\Repository;

/**
 * Actionable
 *
 * @package Envorra\LaravelSettings\Actions
 */
class Actionable
{
    public function __construct(
        protected Repository $repository,
        protected Model $model,
        protected array $attributes = [],
    ) {}
}
