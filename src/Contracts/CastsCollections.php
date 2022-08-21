<?php

namespace TaylorNetwork\LaravelSettings\Contracts;


/**
 * Contract CastsCollections
 *
 * @package  TaylorNetwork\LaravelSettings
 *
 * @template TKey of array-key
 * @template TValue
 */
interface CastsCollections
{
    /**
     * @param  iterable  $items
     * @return self<TKey, TValue>
     */
    public static function from(iterable $items): self;

    /**
     * New collection from array.
     *
     * @param  array  $array
     * @return self<TKey, TValue>
     */
    public static function fromArray(array $array): self;

    /**
     * New collection from JSON.
     *
     * @param  string  $json
     * @return self<TKey, TValue>
     */
    public static function fromJson(string $json): self;
}
