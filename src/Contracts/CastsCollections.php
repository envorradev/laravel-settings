<?php

namespace Envorra\LaravelSettings\Contracts;


/**
 * CastsCollections
 *
 * @package  Envorra\LaravelSettings\Contracts
 *
 * @template TKey of array-key
 * @template TValue
 */
interface CastsCollections
{
    /**
     * @param  iterable  $items
     * @return CastsCollections<TKey, TValue>
     */
    public static function from(iterable $items): CastsCollections;

    /**
     * New collection from array.
     *
     * @param  array  $array
     * @return CastsCollections<TKey, TValue>
     */
    public static function fromArray(array $array): CastsCollections;

    /**
     * New collection from JSON.
     *
     * @param  string  $json
     * @return CastsCollections<TKey, TValue>
     */
    public static function fromJson(string $json): CastsCollections;
}
