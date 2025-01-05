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
        Schema::create("user_task_accesses", function (Blueprint $table) {
            $table->id();
            $table->enum("access_type", ["read", "write"])
                ->comment("Indicates the type of access: read or write");
            $table->unsignedInteger("user_id");
            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");
            $table->unsignedInteger("task_id");
            $table->foreign("task_id")
                ->references("id")
                ->on("tasks")
                ->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("user_task_accesses");
    }
};
