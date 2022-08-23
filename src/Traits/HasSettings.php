<?php

namespace Envorra\LaravelSettings\Traits;

use Envorra\LaravelSettings\Models\Setting;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * HasSettings
 *
 * @package Envorra\LaravelSettings\Traits
 */
trait HasSettings
{
    /**
     * Define a polymorphic one-to-many relationship.
     *
     * @param  string   $related
     * @param  string   $name
     * @param  ?string  $type
     * @param  ?string  $id
     * @param  ?string  $localKey
     * @return MorphMany
     * @noinspection PhpMissingReturnTypeInspection
     */
    abstract public function morphMany($related, $name, $type = null, $id = null, $localKey = null);

    /**
     * Model has settings.
     *
     * @return MorphMany
     */
    public function settings(): MorphMany
    {
        return $this->morphMany(Setting::class, 'owner');
    }
}
