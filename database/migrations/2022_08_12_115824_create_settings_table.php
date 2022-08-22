<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Envorra\LaravelSettings\Enums\DataType;
use Envorra\LaravelSettings\Enums\SettingType;

return new class extends Migration {
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->enum('setting_type', SettingType::values());
            $table->nullableMorphs('owner');
            $table->string('key');
            $table->text('description')->nullable();
            $table->enum('data_type', DataType::values());
            $table->longText('value')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
