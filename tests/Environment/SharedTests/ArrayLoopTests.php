<?php

namespace Envorra\LaravelSettings\Tests\Environment\SharedTests;

trait ArrayLoopTests
{
    protected function assertAllInstanceOf(string $class, iterable $items): void
    {
        foreach ($items as $item) {
            $this->assertInstanceOf($class, $item);
        }
    }

    protected function assertAllStrings(array $array): void
    {
        foreach ($array as $item) {
            $this->assertIsString($item);
        }
    }
}
