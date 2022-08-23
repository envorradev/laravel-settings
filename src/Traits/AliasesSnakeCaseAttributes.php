<?php

namespace Envorra\LaravelSettings\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Connection;

/**
 * AliasesSnakeCaseAttributes
 *
 * @package Envorra\LaravelSettings\Traits
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

    /**
     * Get the database connection for the model.
     *
     * @return Connection
     */
    abstract public function getConnection();

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    abstract public function getTable();
}
