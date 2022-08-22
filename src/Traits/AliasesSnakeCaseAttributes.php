<?php

namespace Envorra\LaravelSettings\Traits;

use Illuminate\Support\Str;

/**
 * AliasesSnakeCaseAttributes
 *
 * @package Envorra\LaravelSettings
 */
trait AliasesSnakeCaseAttributes
{
    /**
     * @inheritDoc
     */
    public function getAttribute($key): mixed
    {
        return parent::getAttribute($key) ?? parent::getAttribute(Str::snake($key));
    }

    /**
     * @inheritDoc
     */
    public function setAttribute($key, $value): mixed
    {
        $snakeKey = Str::snake($key);

        if ($snakeKey === $key) {
            return parent::setAttribute($key, $value);
        }

        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());

        return parent::setAttribute(
            key: in_array($snakeKey, $columns) ? $snakeKey : $key,
            value: $value
        );
    }
}
