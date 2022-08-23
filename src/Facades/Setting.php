<?php

namespace Envorra\LaravelSettings\Facades;

use Illuminate\Support\Facades\Facade;
use Envorra\LaravelSettings\Repositories\SettingsRepository;

/**
 * Setting
 *
 * @package Envorra\LaravelSettings\Facades
 *
 * @mixin SettingsRepository
 */
class Setting extends Facade
{
    /**
     * @inheritDoc
     * @noinspection PhpUnused
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Setting';
    }
}
