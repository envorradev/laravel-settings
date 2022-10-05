<?php declare(strict_types=1);

namespace Envorra\LaravelSettings\Tests\Casters;

use Illuminate\Database\Eloquent\Model;
use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Casters\SettingTypeCaster;
use Envorra\LaravelSettings\SettingTypes\AppSettingType;
use Envorra\LaravelSettings\SettingTypes\GlobalSettingType;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Casters\SettingTypeCaster
 */
class SettingTypeCasterTest extends TestCase
{
    /**
     * @test
     * @covers ::set
     */
    public function it_can_cast_from_setting_type(): void
    {
        $this->assertEquals(
            'global',
            $this->caster()->set($this->model(), 'setting_type', new GlobalSettingType(), [])
        );
    }

    /**
     * @test
     * @covers ::get
     */
    public function it_can_cast_to_setting_type(): void
    {
        $this->assertEquals(
            new AppSettingType(),
            $this->caster()->get($this->model(), 'setting_type', 'app', [])
        );
    }

    protected function caster(): SettingTypeCaster
    {
        return new SettingTypeCaster();
    }

    protected function model(): Model
    {
        return new class extends Model {
        };
    }
}
