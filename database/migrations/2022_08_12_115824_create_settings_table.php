<?php

/**
 * @noinspection PhpUnused
 * @noinspection PhpEnforceDocCommentInspection
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Envorra\LaravelSettings\Enums\DataType;
use Illuminate\Database\Migrations\Migration;
use Envorra\LaravelSettings\Enums\SettingType;

return new class extends Migration {
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_type')->default('global');
            $table->nullableMorphs('owner');
            $table->string('key');
            $table->text('description')->nullable();
            $table->string('data_type')->default('string');
            $table->longText('value')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
