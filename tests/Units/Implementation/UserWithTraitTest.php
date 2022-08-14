<?php

namespace TaylorNetwork\LaravelSettings\Tests\Units\Implementation;

use TaylorNetwork\LaravelSettings\Tests\Environment\Models\UserUsingTrait;
use TaylorNetwork\LaravelSettings\Tests\TestCase;

class UserWithTraitTest extends TestCase
{
    /** @test */
    public function it_can_get_a_users_settings(): void
    {
        $user = UserUsingTrait::first();
        $this->assertIsInt($user->settings->first()->value);
    }
}
