<?php

/** @noinspection PhpUnused */

namespace Envorra\LaravelSettings\Tests\Environment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\Authenticatable;
use Envorra\LaravelSettings\Traits\OwnsSettings;
use Envorra\LaravelSettings\Contracts\SettingOwner;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

/**
 * @mixin Builder
 */
abstract class TestingModel extends Model implements Authenticatable, SettingOwner
{
    use AuthenticatableTrait;
    use OwnsSettings;

    protected $guarded = [];

    protected $table = 'users';
}
