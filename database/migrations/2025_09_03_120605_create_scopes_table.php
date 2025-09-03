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
        Schema::create('scopes', function (Blueprint $table) {
            $table->id();
            $table->string("name");

            $table->foreignId("project_id")->constrained("projects")->cascadeOnUpdate()->cascadeOnDelete();
            $table->text("description")->nullable();
            $table->string("icon")->nullable();

            $table->foreignId("created_by")->nullable()->constrained("users")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId("updated_by")->nullable()->constrained("users")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId("deleted_by")->nullable()->constrained("users")->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scopes');
    }
};
