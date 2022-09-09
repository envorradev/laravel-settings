<?php

namespace Envorra\LaravelSettings\Tests\Unit\Repositories;

use ReflectionClass;
use ReflectionException;
use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Models\Setting;
use Envorra\TypeHandler\Contracts\Types\Type;
use Envorra\LaravelSettings\Contracts\SettingType;
use Envorra\LaravelSettings\Contracts\SettingOwner;
use Envorra\TypeHandler\Types\Primitives\DoubleType;
use Envorra\LaravelSettings\SettingTypes\AppSettingType;
use Envorra\LaravelSettings\Models\AbstractSettingModel;
use Envorra\LaravelSettings\SettingTypes\GlobalSettingType;
use Envorra\LaravelSettings\Repositories\SettingsRepository;
use Envorra\LaravelSettings\Tests\Environment\Models\UserUsingTrait;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Repositories\SettingsRepository
 */
class SettingsRepositoryTest extends TestCase
{
    /**
     * @test
     * @covers ::addDataTypeScope
     * @throws ReflectionException
     */
    public function it_can_execute_addDataTypeScope_method(): void
    {
        $repository = new SettingsRepository();

        $this->assertPropertyEquals(null, 'scopeDataType', $repository);

        $repository->addDataTypeScope(DoubleType::make());

        $this->assertScopeDataType(DoubleType::make(), $repository);
    }

    /**
     * @test
     * @covers ::addOwnerScope
     * @throws ReflectionException
     */
    public function it_can_execute_addOwnerScope_method(): void
    {
        $repository = new SettingsRepository();

        $this->assertPropertyEquals(null, 'scopeOwner', $repository);

        $repository->addOwnerScope(UserUsingTrait::first());

        $this->assertScopeOwner(UserUsingTrait::first(), $repository);
    }

    /**
     * @test
     * @covers ::addSettingTypeScope
     * @throws ReflectionException
     */
    public function it_can_execute_addSettingTypeScope_method(): void
    {
        $repository = new SettingsRepository();

        $this->assertPropertyEquals(null, 'scopeSettingType', $repository);

        $repository->addSettingTypeScope(new AppSettingType());

        $this->assertScopeSettingType(new AppSettingType(), $repository);
    }

    /**
     * @test
     * @covers ::all
     */
    public function it_can_execute_all_method(): void
    {

    }

    /**
     * @test
     * @covers ::findOrFail
     */
    public function it_can_execute_findOrFail_method(): void
    {

    }

    /**
     * @test
     * @covers ::find
     */
    public function it_can_execute_find_method(): void
    {

    }

    /**
     * @test
     * @covers ::get
     */
    public function it_can_execute_get_method(): void
    {

    }

    /**
     * @test
     * @covers ::modelClass
     */
    public function it_can_execute_modelClass_method(): void
    {
        $this->assertIsString(SettingsRepository::modelClass());
    }

    /**
     * @test
     * @covers ::model
     */
    public function it_can_execute_model_method(): void
    {
        $this->assertInstanceOf(AbstractSettingModel::class, SettingsRepository::model());
        $this->assertInstanceOf(SettingsRepository::modelClass(), SettingsRepository::model());
    }

    /**
     * @test
     * @covers ::newInstance
     */
    public function it_can_execute_newInstance_method(): void
    {

    }

    /**
     * @test
     * @covers ::newQuery
     */
    public function it_can_execute_newQuery_method(): void
    {

    }

    /**
     * @test
     * @covers ::query
     */
    public function it_can_execute_query_method(): void
    {

    }

    /**
     * @test
     * @covers ::whereKey
     */
    public function it_can_execute_whereKey_method(): void
    {

    }

    /**
     * @test
     * @covers ::where
     */
    public function it_can_execute_where_method(): void
    {

    }

    /**
     * @test
     * @covers ::__call
     */
    public function it_can_forward_calls_to_builder(): void
    {

    }

    /**
     * @test
     * @covers ::__callStatic
     */
    public function it_can_forward_static_calls_to_builder(): void
    {

    }

    /**
     * @test
     * @covers ::__construct
     */
    public function it_can_instantiate(): void
    {
        $this->assertInstanceOf(SettingsRepository::class, new SettingsRepository());
    }

    /**
     * @test
     * @covers ::__call
     * @throws ReflectionException
     */
    public function it_can_make_scoped_instance_from_non_static_call(): void
    {
        $repository = new SettingsRepository();

        /** @phpstan-ignore-next-line */
        $this->assertScopeSettingType(new GlobalSettingType, $repository->global());
    }

    /**
     * @test
     * @covers ::__callStatic
     * @throws ReflectionException
     */
    public function it_can_make_scoped_instance_from_static_call(): void
    {
        /** @phpstan-ignore-next-line */
        $this->assertScopeSettingType(new AppSettingType, SettingsRepository::app());
    }

    /**
     * @throws ReflectionException
     */
    protected function assertPropertyEquals(mixed $expected, string $propertyName, SettingsRepository $repository): void
    {
        $this->assertEquals($expected, $this->getPropertyValue($repository, $propertyName));
    }

    /**
     * @throws ReflectionException
     */
    protected function assertPropertyInstanceOf(
        string $class,
        string $propertyName,
        SettingsRepository $repository
    ): void {
        $this->assertInstanceOf($class, $this->getPropertyValue($repository, $propertyName));
    }

    /**
     * @throws ReflectionException
     */
    protected function assertScopeDataType(Type $dataType, SettingsRepository $repository): void
    {
        $this->assertPropertyInstanceOf($dataType::class, 'scopeDataType', $repository);
        $this->assertPropertyEquals($dataType, 'scopeDataType', $repository);
    }

    /**
     * @throws ReflectionException
     */
    protected function assertScopeOwner(SettingOwner $owner, SettingsRepository $repository): void
    {
        $this->assertPropertyInstanceOf($owner::class, 'scopeOwner', $repository);
        $this->assertPropertyEquals($owner, 'scopeOwner', $repository);
    }

    /**
     * @throws ReflectionException
     */
    protected function assertScopeSettingType(SettingType $settingType, SettingsRepository $repository): void
    {
        $this->assertPropertyInstanceOf($settingType::class, 'scopeSettingType', $repository);
        $this->assertPropertyEquals($settingType, 'scopeSettingType', $repository);
    }

    /**
     * @throws ReflectionException
     */
    protected function getPropertyValue(SettingsRepository $repository, string $property): mixed
    {
        return (new ReflectionClass($repository))->getProperty($property)->getValue($repository);
    }
}
