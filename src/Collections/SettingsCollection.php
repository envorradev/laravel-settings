<?php

namespace TaylorNetwork\LaravelSettings\Collections;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;
use TaylorNetwork\LaravelSettings\Contracts\CastsCollections;

/**
 * @template TKey of array-key
 * @template TModel of \TaylorNetwork\LaravelSettings\Models\Setting
 *
 * @extends SettingsCollection<TKey, TModel>
 */
class SettingsCollection extends Collection implements CastsCollections
{
    /**
     * @inheritDoc
     */
    public static function from(iterable $iterable): static
    {
        return new static($iterable);
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $array): static
    {
        return static::from($array);
    }

    /**
     * @inheritDoc
     */
    public static function fromJson(string $json): static
    {
        return static::fromArray(json_decode($json, true));
    }

    /**
     * @inheritDoc
     */
    public static function fromCollection(BaseCollection $collection): static
    {
        if($collection instanceof static) {
            return $collection;
        }

        return static::from($collection);
    }
}
