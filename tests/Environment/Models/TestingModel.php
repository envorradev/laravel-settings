<?php

namespace Envorra\LaravelSettings\Tests\Environment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

/**
 * @mixin Builder
 */
abstract class TestingModel extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    protected $guarded = [];

    protected $table = 'users';
}
