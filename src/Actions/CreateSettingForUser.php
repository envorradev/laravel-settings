<?php

namespace Envorra\LaravelSettings\Actions;

use Envorra\LaravelSettings\Models\Setting;

/**
 * CreateSettingForUser
 *
 * @package Envorra\LaravelSettings\Actions
 */
class CreateSettingForUser
{
    /**
     * @param  Actionable  $actionable
     * @return Setting
     */
    public function handle(Actionable $actionable): Setting
    {
        return new Setting();
    }
}
