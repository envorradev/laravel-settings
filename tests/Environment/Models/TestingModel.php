<?php

namespace TaylorNetwork\LaravelSettings\Tests\Environment\Models;

use Illuminate\Database\Eloquent\Model;

abstract class TestingModel extends Model
{
    protected $guarded = [];

    protected $table = 'users';
}
