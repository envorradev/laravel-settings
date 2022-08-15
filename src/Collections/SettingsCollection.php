<?php

namespace TaylorNetwork\LaravelSettings\Collections;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;
use TaylorNetwork\LaravelSettings\Contracts\CastsCollections;

class SettingsCollection extends Collection implements CastsCollections
{
    public static function from(iterable $iterable): static
    {
        return new static($iterable);
    }

    public static function fromArray(array $array): static
    {
        return static::from($array);
    }

    public static function fromJson(string $json): static
    {
        return static::fromArray(json_decode($json, true));
    }

    public static function fromCollection(BaseCollection $collection): static
    {
        if($collection instanceof static) {
            return $collection;
        }

        return static::from($collection);
    }
}
