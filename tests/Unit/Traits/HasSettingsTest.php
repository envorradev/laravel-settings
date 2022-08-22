<?php

namespace Envorra\LaravelSettings\Tests\Unit\Traits;

use Illuminate\Database\Eloquent\Model;
use Envorra\LaravelSettings\Traits\HasSettings;
use Envorra\LaravelSettings\Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Envorra\LaravelSettings\Collections\SettingsCollection;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Traits\HasSettings
 */
class HasSettingsTest extends TestCase
{
    protected function anonymousModel(): Model
    {
        return new class extends Model {
            use HasSettings;
        };
    }


    /**
     * @test
     * @covers ::settings
     */
    public function it_can_execute_settings_method(): void
    {
        /** @phpstan-ignore-next-line */
        $this->assertInstanceOf(MorphMany::class, $this->anonymousModel()->settings());

        /** @phpstan-ignore-next-line */
        $this->assertInstanceOf(SettingsCollection::class, $this->anonymousModel()->settings);

        /** @phpstan-ignore-next-line */
        $this->assertCount(0, $this->anonymousModel()->settings);
    }
}
