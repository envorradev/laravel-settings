<?php

namespace Envorra\LaravelSettings\Tests\Environment\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
abstract class TestingModel extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    protected $guarded = [];

    protected $table = 'users';
}
