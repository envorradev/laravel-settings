<?php

namespace Envorra\LaravelSettings\Tests\Unit\Repositories;

use ReflectionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Envorra\LaravelSettings\Enums\DataType;
use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Models\Setting;
use Illuminate\Support\ItemNotFoundException;
use Envorra\LaravelSettings\Enums\SettingType;
use Envorra\LaravelSettings\Exceptions\DataTypeException;
use Envorra\LaravelSettings\Collections\SettingsCollection;
use Envorra\LaravelSettings\Repositories\SettingsRepository;
use Envorra\LaravelSettings\Tests\Environment\Models\UserUsingTrait;
use Envorra\LaravelSettings\Tests\Environment\Database\Seeders\SettingsSeeder;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Repositories\SettingsRepository
 */
class SettingsRepositoryTest extends TestCase
{
    /**
     * @test
     * @covers ::allOfDataType
     * @throws DataTypeException
     */
    public function it_can_execute_allOfDataType_method(): void
    {
        $this->assertAllOfDataType(
            dataType: DataType::ARRAY,
            items: $this->repository()->allOfDataType(DataType::ARRAY)
        );
    }

    /**
     * @test
     * @covers ::allOfSettingType
     */
    public function it_can_execute_allOfSettingType_method(): void
    {
        $this->assertAllOfSettingType(
            settingType: SettingType::USER,
            items: $this->repository()->allOfSettingType(SettingType::USER)
        );
    }

    /**
     * @test
     * @covers ::allRelatedToModel
     */
    public function it_can_execute_allRelatedToModel_method(): void
    {
        /** @phpstan-ignore-next-line */
        $model = UserUsingTrait::find(3);

        foreach ($this->repository()->allRelatedToModel($model) as $setting) {
            $this->assertEquals($model, $setting->owner);
        }
    }

    /**
     * @test
     * @covers ::all
     */
    public function it_can_execute_all_method(): void
    {
        $settings = $this->repository()->all();

        $this->assertCount(SettingsSeeder::groupSeedCount(), $settings);
        $this->assertInstanceOf(SettingsCollection::class, $settings);
        $this->assertAllInstanceOf(Setting::class, $settings);
    }

    /**
     * @test
     * @covers ::findOrFail
     * @throws DataTypeException
     */
    public function it_can_execute_findOrFail_method(): void
    {
        $result = $this->repository()->findOrFail('global.test.array1');
        $this->assertModelExists($result);
        $this->assertInstanceOf(Setting::class, $result);
        $this->assertIsDataType(DataType::ARRAY, $result->value);
        $this->assertEquals(['one', 'two', 'three'], $result->value);

        $this->expectException(ItemNotFoundException::class);
        $this->repository()->findOrFail('unknown-key');
    }

    /**
     * @test
     * @covers ::find
     * @throws DataTypeException
     */
    public function it_can_execute_find_method(): void
    {
        $result = $this->repository()->find('app.test.float1');
        $this->assertModelExists($result);
        $this->assertInstanceOf(Setting::class, $result);
        $this->assertIsDataType(DataType::FLOAT, $result->value);
        $this->assertEquals(7.5, $result->value);

        $this->assertNull($this->repository()->find('unknown-key'));
    }

    /**
     * @test
     * @covers ::getModel
     */
    public function it_can_execute_getModel_method(): void
    {
        $this->assertInstanceOf(Setting::class, $this->repository()->getModel());
    }

    /**
     * @test
     * @covers ::get
     * @throws DataTypeException
     */
    public function it_can_execute_get_method(): void
    {
        $result = $this->repository()->get('model.test.collection1');
        $this->assertIsDataType(DataType::COLLECTION, $result);

        $this->assertEquals('default value', $this->repository()->get('unknown-key', 'default value'));
    }

    /**
     * @test
     * @covers ::newQuery
     */
    public function it_can_execute_newQuery_method(): void
    {
        $repository = SettingsRepository::app();
        $query = $repository->where('description', 'test description');
        $expectedQuery = Setting::query()->where('setting_type', SettingType::APP)
            ->where('description', 'test description');

        $scopedQuery = Setting::query()->where('setting_type', SettingType::APP);

        // Check that the current query is not the default.
        $this->assertEquals($expectedQuery, $query);
        $this->assertQuery($expectedQuery, $repository);

        // Reset the query and check that it matches scope.
        $this->assertInstanceOf(Builder::class, $repository->newQuery());
        $this->assertQuery($scopedQuery, $repository);
        $this->assertEquals($scopedQuery, $repository->query());
    }

    /**
     * @test
     * @covers ::query
     */
    public function it_can_execute_query_method(): void
    {
        $this->assertInstanceOf(Builder::class, $this->repository()->query());
        $this->assertEquals(Setting::query(), $this->repository()->query());
    }

    /**
     * @test
     * @covers ::set
     */
    public function it_can_execute_set_method(): void
    {
        // starting values
        $this->assertEquals(4, $this->repository()->get('user.test.int1'));
        $this->assertNull($this->repository()->get('some-test-key-to-be-set'));

        // set new values
        $this->assertModelExists($this->repository()->set('user.test.int1', 8));
        $this->assertModelExists($this->repository()->set('some-test-key-to-be-set', 'a value'));

        // check if they persist
        $this->assertEquals(8, $this->repository()->get('user.test.int1'));
        $this->assertEquals('a value', $this->repository()->get('some-test-key-to-be-set'));
    }

    /**
     * @test
     * @covers ::app
     */
    public function it_can_execute_static_app_method(): void
    {
        $repository = SettingsRepository::app();
        $this->assertInstanceOf(SettingsRepository::class, $repository);
        $this->assertScopeSettingType(SettingType::APP, $repository);
    }

    /**
     * @test
     * @covers ::global
     */
    public function it_can_execute_static_global_method(): void
    {
        $repository = SettingsRepository::global();
        $this->assertInstanceOf(SettingsRepository::class, $repository);
        $this->assertScopeSettingType(SettingType::GLOBAL, $repository);
    }

    /**
     * @test
     * @covers ::instance
     */
    public function it_can_execute_static_instance_method(): void
    {
        $this->assertInstanceOf(SettingsRepository::class, SettingsRepository::instance());
    }

    /**
     * @test
     * @covers ::model
     */
    public function it_can_execute_static_model_method(): void
    {
        $repository = SettingsRepository::model(UserUsingTrait::first());
        $this->assertInstanceOf(SettingsRepository::class, $repository);
        $this->assertScopeSettingType(SettingType::MODEL, $repository);
    }

    /**
     * @test
     * @covers ::user
     */
    public function it_can_execute_static_user_method(): void
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
        /** @phpstan-ignore-next-line */
        $owner = UserUsingTrait::find(3);
        $expectedQuery = Setting::query()->whereMorphedTo('owner', $owner);

        $repository = $this->repository();
        $query = $repository->whereOwner($owner);

        $this->assertInstanceOf(Builder::class, $query);
        $this->assertEquals($expectedQuery, $query);
        $this->assertQuery($expectedQuery, $repository);
    }

    /**
     * @test
     * @covers ::where
     */
    public function it_can_execute_where_method(): void
    {
        $expectedQuery = Setting::query()->where('description', 'LIKE', '%some value%');

        $repository = $this->repository();
        $query = $repository->where('description', 'LIKE', '%some value%');

        $this->assertInstanceOf(Builder::class, $query);
        $this->assertEquals($expectedQuery, $query);
        $this->assertQuery($expectedQuery, $repository);
    }

    protected function assertPropValue(mixed $expected, string $property, SettingsRepository $repository): void
    {
        try {
            $this->assertEquals($expected, $this->reflectPropValue($property, $repository));
        } catch (ReflectionException) {
        }
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

    protected function assertScopeSettingType(SettingType $expected, SettingsRepository $repository): void
    {
        $this->assertPropValue($expected, 'scopeSettingType', $repository);
    }

    protected function defaultClassToReflect(): string|object|null
    {
        return SettingsRepository::class;
    }

    protected function repository(): SettingsRepository
    {
        return new SettingsRepository();
    }
}
