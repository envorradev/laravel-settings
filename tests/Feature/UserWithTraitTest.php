<?php

namespace Envorra\LaravelSettings\Tests\Feature;

use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Exceptions\DataTypeException;
use Envorra\LaravelSettings\Collections\SettingsCollection;
use Envorra\LaravelSettings\Tests\Environment\Models\UserUsingTrait;

class UserWithTraitTest extends TestCase
{

    /**
     * @test
     * @throws DataTypeException
     */
    public function it_can_get_a_users_settings(): void
    {
        $user = UserUsingTrait::first();
        $settings = $user->settings;
        $this->assertInstanceOf(SettingsCollection::class, $settings);
        $this->assertSettingsAreValid($settings);
    }
}
