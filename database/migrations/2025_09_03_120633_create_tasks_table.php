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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string("name");

            $table->foreignId("scope_id")->constrained("scopes")->cascadeOnUpdate()->cascadeOnDelete();
            $table->text("description")->nullable();
            $table->foreignId("status_id")->constrained("statuses")->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId("rate_id")->constrained("rates")->cascadeOnUpdate()->cascadeOnDelete();
            $table->float("rate_value")->default(0);

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
        Schema::dropIfExists('tasks');
    }
};
