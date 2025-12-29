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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained();
            $table->string('username');
            $table->string('ext_username')->unique();
            $table->string('email');
            $table->string('phone');
            $table->string('password');
            $table->rememberToken();
            $table->string('upline')->nullable();
            $table->decimal('total_dp', 10, 0)->default(0);
            $table->decimal('total_wd', 10, 0)->default(0);
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->enum('status_kyc', ['active', 'pending', 'inactive'])->default('inactive');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
