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
        Schema::create('project_task_statuses', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description")->nullable();
            $table->string("icon");
            $table->string("color");

            $table->foreignId("created_by")->nullable()->constrained("users");
            $table->foreignId("updated_by")->nullable()->constrained("users");
            $table->timestamps();
        });

        Schema::create("project_task_status_next_statuses", function (Blueprint $table) {
            $table->id();
            $table->foreignId("from_status_id")->constrained("project_task_statuses", "id", "status_id");
            $table->foreignId("to_status_id")->constrained("project_task_statuses");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_task_status_next_statuses');
        Schema::dropIfExists('project_task_statuses');
    }
};
