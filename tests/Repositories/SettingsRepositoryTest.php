<?php declare(strict_types=1);

namespace Envorra\LaravelSettings\Tests\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Envorra\LaravelSettings\Models\Setting;
use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Traits\OwnsSettings;
use Envorra\LaravelSettings\Contracts\SettingOwner;
use Envorra\TypeHandler\Types\Primitives\StringType;
use Envorra\LaravelSettings\SettingTypes\AppSettingType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Envorra\LaravelSettings\SettingTypes\GlobalSettingType;
use Envorra\LaravelSettings\Repositories\SettingsRepository;
use Envorra\LaravelSettings\Tests\Environment\Database\Seeders\SettingSeeder;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Repositories\SettingsRepository
 */
class SettingsRepositoryTest extends TestCase
{
    /**
     * @test
     * @covers ::addDataTypeScope
     */
    public function it_can_add_data_type_scope(): void
    {
        $repository = $this->repository();

        $this->assertNull($repository->getScopeDataType());
        $this->assertInstanceOf(
            SettingsRepository::class,
            $repository->addDataTypeScope(StringType::make())
        );
        $this->assertEquals(StringType::make(), $repository->getScopeDataType());
    }

    /**
     * @test
     * @covers ::addOwnerScope
     */
    public function it_can_add_owner_scope(): void
    {
        $repository = $this->repository();

        $this->assertNull($repository->getScopeOwner());
        $this->assertInstanceOf(
            SettingsRepository::class,
            $repository->addOwnerScope($this->owner())
        );
        $this->assertEquals($this->owner(), $repository->getScopeOwner());
    }

    /**
     * @test
     * @covers ::addSettingTypeScope
     */
    public function it_can_add_setting_type_scope(): void
    {
        $repository = $this->repository();

        $this->assertNull($repository->getScopeSettingType());
        $this->assertInstanceOf(
            SettingsRepository::class,
            $repository->addSettingTypeScope(new AppSettingType())
        );
        $this->assertEquals(new AppSettingType(), $repository->getScopeSettingType());
    }

    /**
     * @test
     * @covers ::whereKey
     */
    public function it_can_add_where_key_to_builder(): void
    {
        $builder = Setting::query();
        $repository = $this->repository();

        $this->assertEquals($builder, $repository->query());
        $this->assertInstanceOf(SettingsRepository::class, $repository->whereKey('app.test.float1'));
        $this->assertEquals($builder->where('key', 'app.test.float1'), $repository->query());
    }

    /**
     * @test
     * @covers ::where
     */
    public function it_can_execute_where_method(): void
    {
        $builder = Setting::query();
        $repository = $this->repository();

        $this->assertEquals($builder, $repository->query());
        $this->assertInstanceOf(SettingsRepository::class, $repository->where('key', 'app.test.float1'));
        $this->assertEquals($builder->where('key', 'app.test.float1'), $repository->query());
    }

    /**
     * @test
     * @covers ::find
     */
    public function it_can_find_a_setting(): void
    {
        $this->assertModelExists($this->repository()->find('app.test.float1'));
    }

    /**
     * @test
     * @covers ::__call
     */
    public function it_can_forward_calls_to_builder(): void
    {
        $this->assertFalse(method_exists($this->repository(), 'count'));

        // count() is available on Builder class.
        $this->assertIsInt($this->repository()->count());
    }

    /**
     * @test
     * @covers ::__callStatic
     */
    public function it_can_forward_static_calls_to_instance(): void
    {
        $this->assertInstanceOf(GlobalSettingType::class, SettingsRepository::global()->getScopeSettingType());
    }

    /**
     * @test
     * @covers ::newQuery
     */
    public function it_can_get_a_new_query(): void
    {
        $this->assertInstanceOf(Builder::class, $this->repository()->newQuery());
    }

    /**
     * @test
     * @covers ::all
     */
    public function it_can_get_all_scoped_settings(): void
    {
        $this->assertCount(count(SettingSeeder::APP_SETTINGS), $this->repository()->app()->all());
        $this->assertCount(count(SettingSeeder::GLOBAL_SETTINGS), $this->repository()->global()->all());
    }

    /**
     * @test
     * @covers ::all
     */
    public function it_can_get_all_settings(): void
    {
        $this->assertCount(SettingSeeder::count(), $this->repository()->all());
    }

    /**
     * @test
     * @covers ::get
     */
    public function it_can_get_default_value_when_not_found(): void
    {
        $this->assertNull($this->repository()->get('this.does.not.exist'));
        $this->assertSame('default', $this->repository()->get('this.does.not.exist', 'default'));
        $this->assertSame(10, $this->repository()->get('this.does.not.exist', 10));
    }

    /**
     * @test
     * @covers ::newInstance
     */
    public function it_can_get_new_instance(): void
    {
        $this->assertInstanceOf(SettingsRepository::class, $this->repository()->newInstance());
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
     * @covers ::settingsModelClass
     */
    public function it_can_get_setting_model_class(): void
    {
        $this->assertEquals(Setting::class, SettingsRepository::settingsModelClass());
    }

    /**
     * @test
     * @covers ::get
     */
    public function it_can_get_setting_value(): void
    {
        $this->assertSame(7.5, $this->repository()->get('app.test.float1'));
    }

    /**
     * @test
     * @covers ::settingsModel
     */
    public function it_can_get_settings_model_instance(): void
    {
        $this->assertInstanceOf(Setting::class, SettingsRepository::settingsModel());
    }

    /**
     * @test
     * @covers ::__construct
     */
    public function it_can_instantiate_via_new(): void
    {
        $this->assertInstanceOf(
            SettingsRepository::class,
            $this->repository()
        );

        $this->assertInstanceOf(
            GlobalSettingType::class,
            $this->repository(scopeSettingType: new GlobalSettingType())->getScopeSettingType()
        );

        $this->assertInstanceOf(
            SettingOwner::class,
            $this->repository(scopeOwner: $this->owner())->getScopeOwner()
        );

        $this->assertEquals(
            StringType::make(),
            $this->repository(scopeDataType: StringType::make())->getScopeDataType()
        );
    }

    /**
     * @test
     * @covers ::__call
     */
    public function it_can_make_new_instance_with_setting_type_from_call(): void
    {
        $this->assertNull($this->repository()->getScopeSettingType());
        $this->assertInstanceOf(AppSettingType::class, $this->repository()->app()->getScopeSettingType());
    }

    /**
     * @test
     * @covers ::find
     */
    public function it_returns_null_when_not_found(): void
    {
        $this->assertNull($this->repository()->find('this.does.not.exist'));
    }

    /**
     * @test
     * @covers ::findOrFail
     */
    public function it_throws_exception_when_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repository()->findOrFail('this.does.not.exist');
    }

    protected function owner(): SettingOwner
    {
        return new class extends Model implements SettingOwner {
            use OwnsSettings;
        };
    }

    protected function repository(...$arguments): SettingsRepository
    {
        return new SettingsRepository(...$arguments);
    }
}
