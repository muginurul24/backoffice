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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url')->unique();
            $table->string('title');
            $table->text('description');
            $table->text('keywords');
            $table->text('marquee');
            $table->text('logo');
            $table->text('favicon');
            $table->text('card');
            $table->enum('type', ['nexus-amb', 'nexus-siam', 'infini', 'idn-sports', 'idn-slots', 'onix']);
            $table->string('theme');
            $table->decimal('balance', 10, 0)->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
