<?php

use App\Models\Status;
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
        Status::insert([
            [
                "index" => 1,
                "name" => "oczekuje",
                "icon" => "timer-sand",
                "color" => "#c60000",
            ],
            [
                "index" => 2,
                "name" => "w toku",
                "icon" => "account-hard-hat",
                "color" => "#3e61d3",
            ],
            [
                "index" => 3,
                "name" => "w testach",
                "icon" => "test-tube",
                "color" => "#973ed3",
            ],
            [
                "index" => 4,
                "name" => "częściowo wdrożone",
                "icon" => "circle-half",
                "color" => "#d3ae3e",
            ],
            [
                "index" => 5,
                "name" => "wdrożone",
                "icon" => "check-circle",
                "color" => "#7ad33e",
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
