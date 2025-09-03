<?php

use App\Models\Shipyard\Role;
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
        Role::create([
            "name" => "client",
            "icon" => "account-tie",
            "description" => "Ma dostęp do własnych projektów i ich pochodnych",
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Role::find("client")->delete();
    }
};
