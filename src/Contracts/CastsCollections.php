<?php

namespace TaylorNetwork\LaravelSettings\Contracts;

use Illuminate\Support\Collection;

/**
 * Contract CastsCollections
 *
 * @package TaylorNetwork\LaravelSettings
 */
interface CastsCollections
{
    /**
     * New collection from data.
     *
     * @param iterable $iterable
     * @return static
     */
    public static function from(iterable $iterable): static;

    /**
     * New collection from array.
     *
     * @param array $array
     * @return static
     */
    public static function fromArray(array $array): static;

    /**
     * New collection from JSON.
     *
     * @param string $json
     * @return static
     */
    public static function fromJson(string $json): static;

    /**
     * New collection from other collection.
     *
     * @param Collection $collection
     * @return static
     */
    public static function fromCollection(Collection $collection): static;
}
