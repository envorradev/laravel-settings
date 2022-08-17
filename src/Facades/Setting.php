<?php

namespace TaylorNetwork\LaravelSettings\Facades;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Repositories\SettingsRepository;
use TaylorNetwork\LaravelSettings\Models\Setting as SettingModel;
/**
 * Class Setting
 *
 * @package LaravelSettings
 *
 * @method SettingModel findOrFail(string $key)
 * @method SettingModel|null find(string $key)
 * @method mixed get(string $key, mixed $default = null)
 * @method SettingModel set(string $key, mixed $value, ?SettingType $settingType = null)
 * @method Builder where(string $field, mixed $operatorOrValue, mixed $valueOrNull = null)
 * @method SettingModel getModel()
 * @method Builder query()
 * @method SettingsCollection all()
 * @method SettingsCollection allOfType(SettingType $settingType)
 * @method SettingsCollection allRelatedToModel(Model $model, array|SettingType $filterTypes = [])
 * @method SettingsCollection normalizeCollection(iterable $iterable)
 * @method static SettingsRepository instance()
 * @method static SettingType|null repositorySettingType()
 * @method static SettingsRepository scope(string $scope)
 * @method static SettingsRepository global()
 * @method static SettingsRepository app()
 * @method static SettingsRepository model()
 * @method static SettingsRepository user()
 *
 * @see SettingsRepository
 */
class Setting extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Setting';
    }
}
