<?php

namespace Envorra\LaravelSettings\Collections;

use Envorra\LaravelSettings\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Envorra\LaravelSettings\Contracts\CastsCollections;
use Envorra\LaravelSettings\Exceptions\CastCollectionException;

/**
 * SettingsCollection
 *
 * @package  Envorra\LaravelSettings\Collections
 *
 * @method Setting first(callable $callback = null, $default = null)
 * @method Setting firstOrFail($key = null, $operator = null, $value = null)
 *
 * @implements CastsCollections<array-key, Setting>
 * @extends Collection<array-key, Setting>
 */
class SettingsCollection extends Collection implements CastsCollections
{
    /**
     * @inheritDoc
     * @throws CastCollectionException
     */
    public static function from(iterable $items): self
    {
        foreach ($items as $key => $item) {
            if (!is_iterable($item) && !$item instanceof Setting) {
                throw new CastCollectionException('Cannot cast to SettingsCollection.');
            }

            $items[$key] = !$item instanceof Setting ? Setting::modelFromArray($item) : $item;
        }

        return new self($items);
    }

    /**
     * @inheritDoc
     * @throws CastCollectionException
     */
    public static function fromArray(array $array): self
    {
        return self::from($array);
    }

    /**
     * @inheritDoc
     * @throws CastCollectionException
     */
    public static function fromJson(string $json): self
    {
        return self::fromArray(json_decode($json, true));
    }
}
