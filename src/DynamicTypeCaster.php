<?php

namespace TaylorNetwork\LaravelSettings;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Support\Traits\ForwardsCalls;
use TaylorNetwork\LaravelSettings\Contracts\DynamicallyCastsTypes;
use TaylorNetwork\LaravelSettings\Enums\DataType;

/**
 * @method mixed get(DynamicallyCastsTypes $model, string $key, mixed $value, array $attributes)
 * @method mixed set(DynamicallyCastsTypes $model, string $key, mixed $value, array $attributes)
 */
class DynamicTypeCaster
{
    use HasAttributes;
    use ForwardsCalls;

    protected mixed $castedValue;

    public function __construct(
        protected ?DynamicallyCastsTypes $model = null,
        protected ?string $key = null,
        protected mixed $value = null,
        protected array $modelAttributes = [],
        protected ?DataType $dataType = null,
    ) {
        if($this->key && $this->model) {
            $this->updateCasts();
        }
    }

    public function newInstance(DynamicallyCastsTypes $model, string $key, mixed $value, array $attributes): static
    {
        return new static(
            model: $model,
            key: $key,
            value: $value,
            modelAttributes: $attributes
        );
    }

    public function validateInstance(): bool
    {
        return $this->model && $this->key && array_key_exists($this->key, $this->casts);
    }

    public function getCastedAttribute(): mixed
    {
        if($this->validateInstance()) {
            return $this->castAttribute($this->key, $this->value);
        }
        return null;
    }

    public function setCastedAttribute(): ?string
    {
        if($this->validateInstance()) {
            return $this->model->getDataType()->convertValueToString($this->value);
        }
        return null;
    }

    public function setModel(DynamicallyCastsTypes $model): static
    {
        $this->model = $model;
        return $this;
    }

    public function setKey(string $key): static
    {
        $this->key = $key;
        return $this;
    }

    public function updateCasts(?string $key = null, ?DataType $dataType = null): static
    {
        $this->casts[$key ?? $this->key] = $dataType?->value ?? $this->model->getDataType()->value;
        return $this;
    }

    public function setValue(mixed $value): static
    {
        $this->value = $value;
        return $this;
    }

    public function setModelAttributes(array $attributes): static
    {
        $this->modelAttributes = $attributes;
        return $this;
    }

    public function setDataType(DataType $dataType): static
    {
        $this->dataType = $dataType;
        return $this;
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function __call(string $name, array $arguments): mixed
    {
        if($name === 'get' || $name === 'set') {
            $method = $name.'CastedAttribute';
            return $this->newInstance(...$arguments)->$method();
        }
        return $this->forwardCallTo($this->model, $name, $arguments);
    }
}
