<?php

use App\Models\Shipyard\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ([
            ["app_name", "qwp"],
            ["app_accent_color_1_dark", "#17ecb0"],
            ["app_accent_color_1_light", "#17ecb0"],
            ["app_accent_color_2_dark", "#2f8b71"],
            ["app_accent_color_2_light", "#2f8b71"],
            ["app_accent_color_3_dark", "#afa329"],
            ["app_accent_color_3_light", "#afa329"],
        ] as [$field, $value]) {
            Setting::find($field)->update(["value" => $value]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
