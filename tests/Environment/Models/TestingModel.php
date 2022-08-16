<?php

namespace TaylorNetwork\LaravelSettings\Tests\Environment\Models;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

abstract class TestingModel extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    protected $guarded = [];

    protected $table = 'users';
}
