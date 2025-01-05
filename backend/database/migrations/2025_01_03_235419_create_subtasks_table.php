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
        Schema::create("subtasks", function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("subtitle");
            $table->string("description")->nullable();
            $table->enum("status", [
                "pending", "done", "removed"
            ])->default("pending");
            $table->unsignedInteger("task_id");
            $table->foreign("task_id")
                ->references("id")
                ->on("tasks")
                ->onDelete("cascade");
            $table->unsignedInteger("created_by_user_id");
            $table->foreign("created_by_user_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("subtasks");
    }
};
