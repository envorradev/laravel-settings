<?php

namespace TaylorNetwork\LaravelSettings\Traits;

use Illuminate\Support\Str;

trait AliasesSnakeCaseAttributes
{
    public function getAttribute($key)
    {
        return parent::getAttribute($key) ?? parent::getAttribute(Str::snake($key));
    }

    public function setAttribute($key, $value)
    {
        $snakeKey = Str::snake($key);

        return parent::setAttribute(
            $key === $snakeKey || !in_array($snakeKey, array_keys($this->getAttributes())) ? $key : $snakeKey,
            $value
        );
    }
}
