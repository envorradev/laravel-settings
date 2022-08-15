<?php

namespace TaylorNetwork\LaravelSettings\Tests\CustomTests;

trait ClassTests
{
    protected function assertMethodExists($class, string $method): void
    {
        $this->assertTrue(method_exists($class, $method));
    }
}
