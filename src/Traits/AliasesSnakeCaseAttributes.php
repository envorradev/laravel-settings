<?php

namespace TaylorNetwork\LaravelSettings\Traits;

use Illuminate\Support\Str;

/**
 * Trait AliasesSnakeCaseAttributes
 *
 * @package TaylorNetwork\LaravelSettings
 */
trait AliasesSnakeCaseAttributes
{
    /**
     * @inheritDoc
     */
    public function getAttribute($key)
    {
        return parent::getAttribute($key) ?? parent::getAttribute(Str::snake($key));
    }

    /**
     * @inheritDoc
     */
    public function setAttribute($key, $value)
    {
        $snakeKey = Str::snake($key);

        return parent::setAttribute(
            $key === $snakeKey || !in_array($snakeKey, array_keys($this->getAttributes())) ? $key : $snakeKey,
            $value
        );
    }
}
