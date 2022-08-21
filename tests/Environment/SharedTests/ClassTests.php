<?php

namespace TaylorNetwork\LaravelSettings\Tests\Environment\SharedTests;

trait ClassTests
{
    protected function assertMethodExists($class, string $method): void
    {
        $this->assertTrue(method_exists($class, $method));
    }


}
