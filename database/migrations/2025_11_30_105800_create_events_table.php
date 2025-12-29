<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('banner');
            $table->enum('allowed_for', ['new', 'all'])->default('all');
            $table->enum('rule', ['turnover', 'winover'])->default('turnover');
            $table->enum('category', ['all', 'hot', 'limited', 'slot'])->default('all');
            $table->integer('target');
            $table->integer('percentage');
            $table->dateTime('ended_at')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
