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
        Schema::create('tasks_arches', function (Blueprint $table) {
            $table->id();
            $table->string('task_id')->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('description')->nullable(true);
            $table->string('priority')->nullable(false);
            $table->date('execution_date')->nullable(false);
            $table->string('status')->nullable(false);
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks_arches');
    }
};
