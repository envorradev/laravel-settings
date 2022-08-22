<?php

namespace Envorra\LaravelSettings\Tests\Environment\Models;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static static first()
 */
abstract class TestingModel extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    protected $guarded = [];

    protected $table = 'users';
}
