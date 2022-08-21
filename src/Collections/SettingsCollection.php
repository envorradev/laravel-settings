<?php

namespace TaylorNetwork\LaravelSettings\Collections;

use Illuminate\Database\Eloquent\Collection;
use TaylorNetwork\LaravelSettings\Models\Setting;
use TaylorNetwork\LaravelSettings\Contracts\CastsCollections;

/**
 * Class SettingsCollection
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
     */
    public static function from(iterable $items): self
    {
        foreach ($items as $key => $item) {
            $items[$key] = $item instanceof Setting ? $item : Setting::modelFromArray($item);
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
