<?php

namespace TaylorNetwork\LaravelSettings\Collections;

use Illuminate\Database\Eloquent\Collection;
use TaylorNetwork\LaravelSettings\Models\Setting;
use TaylorNetwork\LaravelSettings\Contracts\CastsCollections;
use TaylorNetwork\LaravelSettings\Exceptions\CastCollectionException;

/**
 * SettingsCollection
 *
 * @package  TaylorNetwork\LaravelSettings
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

            $items[$key] = !$item instanceof Setting ? Setting::modelFromArray($item): $item;
        }

        return new self($items);
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $array): self
    {
        return self::from($array);
    }

    /**
     * @inheritDoc
     */
    public static function fromJson(string $json): self
    {
        return self::fromArray(json_decode($json, true));
    }
}
