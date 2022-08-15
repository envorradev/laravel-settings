<?php

namespace TaylorNetwork\LaravelSettings\Contracts;

use Illuminate\Support\Collection;

interface CastsCollections
{
    public static function from(iterable $iterable): static;

    public static function fromArray(array $array): static;

    public static function fromJson(string $json): static;

    public static function fromCollection(Collection $collection): static;
}
