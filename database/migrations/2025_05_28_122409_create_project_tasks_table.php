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
        Schema::create('project_tasks', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description")->nullable();
            $table->foreignId("area_id")->constrained();
            $table->foreignId("status_id")->constrained("project_task_statuses");
            $table->foreignId("rate_id")->nullable()->constrained();
            
            $table->float("estimated_hours")->nullable();

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
        Schema::dropIfExists('project_tasks');
    }
};
