<?php

namespace TaylorNetwork\LaravelSettings\Tests\Units\Package\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ItemNotFoundException;
use ReflectionClass;
use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Models\Setting;
use TaylorNetwork\LaravelSettings\Repositories\SettingsRepository;
use TaylorNetwork\LaravelSettings\Tests\Environment\database\seeders\TestingSeeder;
use TaylorNetwork\LaravelSettings\Tests\Environment\Models\UserUsingTrait;
use TaylorNetwork\LaravelSettings\Tests\TestCase;

/**
 * @coversDefaultClass \TaylorNetwork\LaravelSettings\Repositories\SettingsRepository
 */
class SettingsRepositoryTest extends TestCase
{
    protected function assertScopeSettingType(SettingType $settingType, SettingsRepository $repository): void
    {
        $reflection = new ReflectionClass(SettingsRepository::class);
        $this->assertIsSettingType($settingType, $reflection->getProperty('scopeSettingType')->getValue($repository));
    }

    protected function assertScopeDataType(DataType $dataType, SettingsRepository $repository): void
    {
        $reflection = new ReflectionClass(SettingsRepository::class);
        $this->assertIsDataType($dataType, $reflection->getProperty('scopeDataType')->getValue($repository));
    }

    protected function assertScopeOwner(Model $owner, SettingsRepository $repository): void
    {
        $reflection = new ReflectionClass(SettingsRepository::class);
        $this->assertEquals($owner, $reflection->getProperty('scopeOwner')->getValue($repository));
    }

    protected function assertQuery(Builder $query, SettingsRepository $repository): void
    {
        $reflection = new ReflectionClass(SettingsRepository::class);
        $this->assertEquals($query, $reflection->getProperty('query')->getValue($repository));
    }

    protected function repository(...$args): SettingsRepository
    {
        return new SettingsRepository(...$args);
    }

    /**
     * @test
     * @covers ::allRelatedToModel
     */
    public function it_can_get_all_related_to_model(): void
    {
        $settings = $this->repository()->allRelatedToModel(UserUsingTrait::first());
        $this->assertInstanceOf(SettingsCollection::class, $settings);
        $this->assertCount(1, $settings);
        $this->assertAllInstanceOf(Setting::class, $settings);
    }

    /**
     * @test
     * @covers ::all
     */
    public function it_can_get_all_settings(): void
    {
        $settings = $this->repository()->all();
        $this->assertInstanceOf(SettingsCollection::class, $settings);
        $this->assertCount(TestingSeeder::totalSettingsSeeded(), $settings);
        $this->assertAllInstanceOf(Setting::class, $settings);
    }

    /**
     * @test
     * @covers ::app
     */
    public function it_can_get_app_scoped_settings(): void
    {
        $this->assertScopeSettingType(SettingType::APP, SettingsRepository::app());
    }

    /**
     * @test
     * @covers ::get
     */
    public function it_can_use_get_method(): void
    {
        $value = $this->repository()->get('global.test.multi_dimensional_array1', 'default value');
        $this->assertIsDataType(DataType::ARRAY, $value);
        $this->assertEquals([
            'name' => 'item1',
            'listing' => ['list1', 'list2', 'list3']
        ], $value);

        $this->assertEquals('default value', $this->repository()->get('an-unknown-key', 'default value'));
        $this->assertNull($this->repository()->get('an-unknown-key'));
    }

    /**
     * @test
     * @covers ::normalizeCollection
     */
    public function it_can_normalize_collections(): void
    {
        $collection = new Collection(['one','two','three','four']);
        $normalized = $this->repository()->normalizeCollection($collection);

        $this->assertNotInstanceOf(SettingsCollection::class, $collection);
        $this->assertInstanceOf(SettingsCollection::class, $normalized);
        $this->assertSameSize($collection, $normalized);
        $this->assertEquals($collection->toArray(), $normalized->toArray());
    }

    /**
     * @test
     * @covers ::find
     */
    public function it_can_find_a_setting(): void
    {
        $repository = SettingsRepository::instance();

        $this->assertInstanceOf(Setting::class, $repository->find('global.test.array1'));
        $this->assertModelExists($repository->find('global.test.array1'));
        $this->assertEquals(['one','two','three'], $repository->find('global.test.array1')->value);
        $this->assertNull($repository->find('an-unknown-key'));
    }

    /**
     * @test
     * @covers ::query
     */
    public function it_can_get_query_builder(): void
    {
        $this->assertInstanceOf(Builder::class, $this->repository()->query());
    }

    /**
     * @test
     * @covers ::findOrFail
     */
    public function it_can_find_a_setting_or_throw_an_exception(): void
    {
        $repository = SettingsRepository::instance();

        $this->assertInstanceOf(Setting::class, $repository->findOrFail('global.test.array1'));
        $this->assertModelExists($repository->findOrFail('global.test.array1'));
        $this->assertEquals(['one','two','three'], $repository->findOrFail('global.test.array1')->value);

        $this->expectException(ItemNotFoundException::class);
        $repository->findOrFail('an-unknown-key');
    }

    /**
     * @test
     * @covers ::getModel
     */
    public function it_can_get_settings_model(): void
    {
        $this->assertInstanceOf(Setting::class, $this->repository()->getModel());
    }

    /**
     * @test
     * @covers ::instance
     */
    public function it_can_make_an_instance(): void
    {
        $query = Setting::query()->whereNotNull('description');

        $this->assertInstanceOf(SettingsRepository::class, SettingsRepository::instance());
        $this->assertScopeOwner(UserUsingTrait::find(2), SettingsRepository::instance(scopeOwner: UserUsingTrait::find(2)));
        $this->assertScopeDataType(DataType::FLOAT, SettingsRepository::instance(scopeDataType: DataType::FLOAT));
        $this->assertScopeSettingType(SettingType::GLOBAL, SettingsRepository::instance(scopeSettingType: SettingType::GLOBAL));
        $this->assertQuery($query, SettingsRepository::instance(query: $query));
    }

    /**
     * @test-skip
     * @covers ::set
     */
    public function it_can_set_settings(): void
    {
        // @todo add set tests...
    }

    /**
     * @test
     * @covers ::where
     */
    public function it_can_use_where_clauses(): void
    {
        $repository = $this->repository();
        $query = Setting::query()->where('key', 'LIKE', 'global%');

        $this->assertInstanceOf(Builder::class, $repository->where('key', 'LIKE', 'global%'));
        $this->assertQuery($query, $repository);
    }

    /**
     * @test
     * @covers ::allOfType
     */
    public function it_can_get_all_of_a_setting_type(): void
    {
        $settings = $this->repository()->allOfType(SettingType::APP);
        $this->assertInstanceOf(SettingsCollection::class, $settings);
        $this->assertAllOfSettingType(SettingType::APP, $settings);
    }

    /**
     * @test
     * @covers ::global
     */
    public function it_can_get_global_scoped_settings(): void
    {
        $this->assertScopeSettingType(SettingType::GLOBAL, SettingsRepository::global());
    }

    /**
     * @test
     * @covers ::whereOwner
     */
    public function it_can_filter_by_setting_owner(): void
    {
        $model = UserUsingTrait::find(3);
        $query = $this->repository()->query()->whereMorphedTo('owner', $model);
        $this->assertInstanceOf(Builder::class, $this->repository()->whereOwner($model));
        $this->assertEquals($query, $this->repository()->whereOwner($model));
    }

    /**
     * @test
     * @covers ::user
     */
    public function it_can_get_user_scoped_settings(): void
    {
        Auth::login(UserUsingTrait::first());
        $repository = SettingsRepository::user();
        $this->assertScopeSettingType(SettingType::USER, $repository);
        $this->assertScopeOwner(UserUsingTrait::first(), $repository);
        Auth::logout();
    }

    /**
     * @test
     * @covers ::model
     */
    public function it_can_get_model_scoped_settings(): void
    {
        $repository = SettingsRepository::model(UserUsingTrait::first());
        $this->assertScopeSettingType(SettingType::MODEL, $repository);
        $this->assertScopeOwner(UserUsingTrait::first(), $repository);
    }

    /**
     * @test
     * @covers ::newQuery
     */
    public function it_can_make_a_new_query(): void
    {
        $repository = SettingsRepository::app();
        $repository->where('data_type', DataType::OBJECT);

        $currentQuery = Setting::query()->where('setting_type', SettingType::APP)
                                        ->where('data_type', DataType::OBJECT);

        // Check that we have a query that is different from the base query.
        $this->assertQuery($currentQuery, $repository);

        // Check that the newQuery() method returns an instance of the query builder.
        $this->assertInstanceOf(Builder::class, $repository->newQuery());

        // Check that after running newQuery() the query is reset to the base query.
        $this->assertQuery(Setting::query()->where('setting_type', SettingType::APP), $repository);
    }
}
