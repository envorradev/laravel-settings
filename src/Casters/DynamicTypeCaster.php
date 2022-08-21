<?php

namespace TaylorNetwork\LaravelSettings\Casters;

use Illuminate\Support\Traits\ForwardsCalls;
use TaylorNetwork\LaravelSettings\Enums\DataType;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use TaylorNetwork\LaravelSettings\Contracts\DynamicallyCastsTypes;

/**
 * DynamicTypeCaster
 *
 * @package TaylorNetwork\LaravelSettings
 *
 * @method mixed get(DynamicallyCastsTypes $model, string $key, mixed $value, array $attributes)
 * @method mixed set(DynamicallyCastsTypes $model, string $key, mixed $value, array $attributes)
 */
class DynamicTypeCaster
{
    use HasAttributes;
    use ForwardsCalls;

    /**
     * DynamicTypeCaster.
     *
     * @param ?DynamicallyCastsTypes  $model
     * @param ?string                 $key
     * @param  mixed                  $value
     * @param  array                  $modelAttributes
     * @param ?DataType               $dataType
     */
    public function __construct(
        protected ?DynamicallyCastsTypes $model = null,
        protected ?string $key = null,
        protected mixed $value = null,
        protected array $modelAttributes = [],
        protected ?DataType $dataType = null,
    ) {
        if ($this->key && $this->model) {
            $this->updateCasts();
        }
    }

    /**
     * Forwards calls to Model, handles get and set methods from HasAttributes.
     *
     * @param  string  $name
     * @param  array   $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        if ($name === 'get' || $name === 'set') {
            $method = $name.'CastedAttribute';
            return $this->newInstance(...$arguments)->$method();
        }
        return $this->forwardCallTo($this->model, $name, $arguments);
    }

    /**
     * Cast attribute from string to @DataType.
     *
     * @return mixed
     */
    public function getCastedAttribute(): mixed
    {
        if ($this->validateInstance()) {
            return $this->castAttribute($this->key, $this->value);
        }
        return null;
    }

    /**
     * Prevents HasAttributes trait from checking for incrementing attribute on this class.
     *
     * @return false
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * New DynamicTypeCaster instance.
     *
     * @param  DynamicallyCastsTypes  $model
     * @param  string                 $key
     * @param  mixed                  $value
     * @param  array                  $attributes
     * @return self
     */
    public function newInstance(DynamicallyCastsTypes $model, string $key, mixed $value, array $attributes): self
    {
        return new self(
            model: $model,
            key: $key,
            value: $value,
            modelAttributes: $attributes
        );
    }

    /**
     * Cast attribute from @DataType to string.
     *
     * @return ?string
     */
    public function setCastedAttribute(): ?string
    {
        if ($this->validateInstance()) {
            return $this->model->getDataType()->convertValueToString($this->value);
        }
        return null;
    }

    /**
     * Set the @DataType.
     *
     * @param  DataType  $dataType
     * @return $this
     */
    public function setDataType(DataType $dataType): static
    {
        $this->dataType = $dataType;
        return $this;
    }

    /**
     * Set the key.
     *
     * @param  string  $key
     * @return $this
     */
    public function setKey(string $key): static
    {
        $this->key = $key;
        return $this;
    }

    /**
     * Set the model.
     *
     * @param  DynamicallyCastsTypes  $model
     * @return $this
     */
    public function setModel(DynamicallyCastsTypes $model): static
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Set the model attributes.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function setModelAttributes(array $attributes): static
    {
        $this->modelAttributes = $attributes;
        return $this;
    }

    /**
     * Set the value to be cast.
     *
     * @param  mixed  $value
     * @return $this
     */
    public function setValue(mixed $value): static
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Update the casts array.
     *
     * @param ?string    $key
     * @param ?DataType  $dataType
     * @return $this
     */
    public function updateCasts(?string $key = null, ?DataType $dataType = null): static
    {
        $this->casts[$key ?? $this->key] = $dataType?->value ?? $this->model->getDataType()->value;
        return $this;
    }

    /**
     * Is this instance valid?
     *
     * @return bool
     */
    public function validateInstance(): bool
    {
        return $this->model && $this->key && array_key_exists($this->key, $this->casts);
    }
}
