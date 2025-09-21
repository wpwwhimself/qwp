<?php

use App\Models\Shipyard\NavItem;
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
        $navItem = NavItem::create([
            "name" => "Statystyki",
            "visible" => 1,
            "icon" => "finance",
            "target_type" => 1,
            "target_name" => "clients.stats-for-client",
        ]);
        $navItem->roles()->sync(["client"]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        NavItem::where("target_name", "clients.stats-for-client")->delete();
    }
};
