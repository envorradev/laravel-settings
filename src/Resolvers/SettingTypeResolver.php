<?php

namespace Envorra\LaravelSettings\Resolvers;

use ReflectionClass;
use DirectoryIterator;
use ReflectionException;
use Envorra\LaravelSettings\Helpers\ConfigHelper;
use Envorra\LaravelSettings\Contracts\SettingType;

/**
 * SettingTypeResolver
 *
 * @package Envorra\LaravelSettings\Resolvers
 */
class SettingTypeResolver
{
    /**
     * @var array<string>
     */
    protected array $directories = [
        __DIR__.'/../SettingTypes',
    ];
    /**
     * @var array<string, class-string>
     */
    private array $basenameMap = [];
    /**
     * @var array<string, SettingType>
     */
    private array $instanceMap = [];
    /**
     * @var array<string, string>
     */
    private array $shortNameMap = [];

    /**
     * @param  string  $abstract
     */
    protected function __construct(
        protected string $abstract
    ) {
        $this->directories = array_merge($this->directories, ConfigHelper::get('setting_type_directories', []));
        $this->scanDirectories();
    }

    /**
     * @param  string  $abstract
     * @return SettingType|null
     */
    public static function resolve(string $abstract): ?SettingType
    {
        return (new self($abstract))->resolveInstance();
    }

    /**
     * @param  SettingType  $settingType
     * @return void
     */
    protected function add(SettingType $settingType): void
    {
        if (!$this->exists($settingType)) {
            $this->shortNameMap[$settingType->name()] = class_basename($settingType);
            $this->basenameMap[class_basename($settingType)] = $settingType::class;
            $this->instanceMap[$settingType::class] = $settingType;
        }
    }

    /**
     * @param  SettingType  $settingType
     * @return bool
     */
    protected function exists(SettingType $settingType): bool
    {
        return in_array(class_basename($settingType), $this->shortNameMap)
            && in_array($settingType::class, $this->basenameMap)
            && in_array($settingType, $this->instanceMap);
    }

    /**
     * @param  string  $basename
     * @return SettingType|null
     */
    protected function instanceFromBasename(string $basename): ?SettingType
    {
        if (array_key_exists($basename, $this->basenameMap)) {
            return $this->instanceFromMap($this->basenameMap[$basename]);
        }
        return null;
    }

    /**
     * @param  string  $class
     * @return SettingType|null
     */
    protected function instanceFromMap(string $class): ?SettingType
    {
        if (array_key_exists($class, $this->instanceMap)) {
            return $this->instanceMap[$class];
        }
        return null;
    }

    /**
     * @param  string  $shortName
     * @return SettingType|null
     */
    protected function instanceFromShortName(string $shortName): ?SettingType
    {
        if (array_key_exists($shortName, $this->shortNameMap)) {
            return $this->instanceFromBasename($this->shortNameMap[$shortName]);
        }
        return null;
    }

    /**
     * @return SettingType|null
     */
    protected function resolveInstance(): ?SettingType
    {
        return $this->instanceFromMap($this->abstract)
            ?? $this->instanceFromBasename($this->abstract)
            ?? $this->instanceFromShortName($this->abstract);
    }

    /**
     * @return void
     */
    protected function scanDirectories(): void
    {
        foreach ($this->directories as $directory) {
            $this->scanDirectory($directory);
        }
    }

    /**
     * @param  DirectoryIterator|string  $directory
     * @return void
     */
    protected function scanDirectory(DirectoryIterator|string $directory): void
    {
        if (is_string($directory)) {
            $directory = new DirectoryIterator($directory);
        }

        /** @var DirectoryIterator $file */
        foreach ($directory as $file) {
            if ($file->isFile() && $file->isReadable()) {
                $class = ClassResolver::resolve($file);

                try {
                    $reflection = new ReflectionClass($class);

                    if (!$reflection->isAbstract()) {
                        $instance = new $class();

                        if ($instance instanceof SettingType) {
                            $this->add($instance);
                        }
                    }
                } catch (ReflectionException) {
                    // skip class
                }
            }
        }
    }
}
