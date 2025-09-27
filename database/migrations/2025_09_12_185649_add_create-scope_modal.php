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
            "name" => "create-scope",
            "visible" => 1,
            "heading" => "Utwórz zakres",
            "fields" => [
                [
                    "name",
                    "text",
                    "Nazwa zakresu",
                    model("scopes")::getFields()["name"]["icon"],
                    true,
                ],
            ],
            "target_route" => "scopes.create",
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Modal::where("name", "create-scope")->delete();
    }
};
