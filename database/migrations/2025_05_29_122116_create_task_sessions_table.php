<?php

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
        Schema::create('task_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("task_id")->constrained("project_tasks");
            $table->float("hours")->default(0);
            $table->boolean("is_open")->default(true);

            $table->foreignId("created_by")->nullable()->constrained("users");
            $table->foreignId("updated_by")->nullable()->constrained("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_sessions');
    }
};
