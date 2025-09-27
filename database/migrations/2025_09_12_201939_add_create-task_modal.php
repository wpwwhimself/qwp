<?php

use App\Models\Shipyard\Modal;
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
        Modal::create([
            "name" => "create-task",
            "visible" => 1,
            "heading" => "Utwórz zadanie",
            "fields" => [
                [
                    "name",
                    "text",
                    "Nazwa",
                    model("tasks")::getFields()["name"]["icon"],
                    true,
                ],
                [
                    "description",
                    "TEXT",
                    "Opis",
                    model("tasks")::getFields()["description"]["icon"],
                    false,
                ],
            ],
            "target_route" => "tasks.create",
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Modal::where("name", "create-task")->delete();
    }
};
