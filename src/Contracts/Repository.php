<?php

/** @noinspection PhpUnused */

namespace Envorra\LaravelSettings\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Envorra\LaravelSettings\Models\AbstractSettingModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Repository
 *
 * @package Envorra\LaravelSettings\Contracts
 */
interface Repository
{
    /**
     * @param  string  $name
     * @param  array   $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments): mixed;

    /**
     * @return AbstractSettingModel
     */
    public static function settingsModel(): AbstractSettingModel;

    /**
     * @return class-string<AbstractSettingModel>
     */
    public static function settingsModelClass(): string;

    /**
     * @param  string  $name
     * @param  array   $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed;

    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param  string  $key
     * @return AbstractSettingModel|null
     */
    public function find(string $key): ?AbstractSettingModel;

    /**
     * @param  string  $key
     * @return AbstractSettingModel
     * @throws ModelNotFoundException
     */
    public function findOrFail(string $key): AbstractSettingModel;

    /**
     * @param  string      $key
     * @param  mixed|null  $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * @return Repository
     */
    public function newInstance(): Repository;

    /**
     * @return Builder
     */
    public function newQuery(): Builder;

    /**
     * @return Builder
     */
    public function query(): Builder;

    /**
     * @param  mixed       $column
     * @param  mixed|null  $operator
     * @param  mixed|null  $value
     * @param  string      $boolean
     * @return self
     */
    public function where(mixed $column, mixed $operator = null, mixed $value = null, string $boolean = 'and'): self;

    /**
     * @param  string  $key
     * @return self
     */
    public function whereKey(string $key): self;
}
