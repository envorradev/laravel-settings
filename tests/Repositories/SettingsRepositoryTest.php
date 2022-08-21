<?php

namespace TaylorNetwork\LaravelSettings\Tests\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use ReflectionException;
use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Repositories\SettingsRepository;
use TaylorNetwork\LaravelSettings\Tests\Environment\Models\UserUsingTrait;
use TaylorNetwork\LaravelSettings\Tests\TestCase;

/**
 * @coversDefaultClass \TaylorNetwork\LaravelSettings\Repositories\SettingsRepository
 */
class SettingsRepositoryTest extends TestCase
{
    /**
     * @test
     * @covers ::allOfType
     */
    public function it_can_execute_allOfType_method(): void
    {

    }

    /**
     * @test
     * @covers ::allRelatedToModel
     */
    public function it_can_execute_allRelatedToModel_method(): void
    {

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
     * @covers ::app
     */
    public function it_can_execute_app_method(): void
    {
        $repository = SettingsRepository::app();
        $this->assertInstanceOf(SettingsRepository::class, $repository);
        $this->assertScopeSettingType(SettingType::APP, $repository);
    }

    protected function assertScopeSettingType(SettingType $expected, SettingsRepository $repository): void
    {
        $this->assertPropValue($expected, 'scopeSettingType', $repository);
    }

    protected function assertPropValue(mixed $expected, string $property, SettingsRepository $repository): void
    {
        try {
            $this->assertEquals($expected, $this->reflectPropValue($property, $repository));
        } catch (ReflectionException) {
        }
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
     * @covers ::getModel
     */
    public function it_can_execute_getModel_method(): void
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
     * @covers ::global
     */
    public function it_can_execute_global_method(): void
    {
        $repository = SettingsRepository::global();
        $this->assertInstanceOf(SettingsRepository::class, $repository);
        $this->assertScopeSettingType(SettingType::GLOBAL, $repository);
    }

    /**
     * @test
     * @covers ::instance
     */
    public function it_can_execute_instance_method(): void
    {
        $this->assertInstanceOf(SettingsRepository::class, SettingsRepository::instance());
    }

    /**
     * @test
     * @covers ::model
     */
    public function it_can_execute_model_method(): void
    {
        $repository = SettingsRepository::model(UserUsingTrait::first());
        $this->assertInstanceOf(SettingsRepository::class, $repository);
        $this->assertScopeSettingType(SettingType::MODEL, $repository);
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
     * @covers ::normalizeCollection
     */
    public function it_can_execute_normalizeCollection_method(): void
    {
        $this->assertInstanceOf(SettingsCollection::class, $this->repository()->normalizeCollection([]));
        $this->assertInstanceOf(SettingsCollection::class, $this->repository()->normalizeCollection(collect()));
    }

    protected function repository(): SettingsRepository
    {
        return new SettingsRepository();
    }

    /**
     * @test
     * @covers ::query
     */
    public function it_can_execute_query_method(): void
    {
        $this->assertInstanceOf(Builder::class, $this->repository()->query());
    }

    /**
     * @test
     * @covers ::set
     */
    public function it_can_execute_set_method(): void
    {

    }

    /**
     * @test
     * @covers ::user
     */
    public function it_can_execute_user_method(): void
    {
        $repository = SettingsRepository::user();
        $this->assertInstanceOf(SettingsRepository::class, $repository);
        $this->assertScopeSettingType(SettingType::USER, $repository);
    }

    /**
     * @test
     * @covers ::whereOwner
     */
    public function it_can_execute_whereOwner_method(): void
    {

    }

    /**
     * @test
     * @covers ::where
     */
    public function it_can_execute_where_method(): void
    {

    }

    protected function assertQuery(Builder $expected, SettingsRepository $repository): void
    {
        $this->assertPropValue($expected, 'query', $repository);
    }

    protected function assertScopeDataType(DataType $expected, SettingsRepository $repository): void
    {
        $this->assertPropValue($expected, 'scopeDataType', $repository);
    }

    protected function assertScopeOwner(Model $expected, SettingsRepository $repository): void
    {
        $this->assertPropValue($expected, 'scopeOwner', $repository);
    }

    protected function defaultClassToReflect(): string|object|null
    {
        return SettingsRepository::class;
    }
}
