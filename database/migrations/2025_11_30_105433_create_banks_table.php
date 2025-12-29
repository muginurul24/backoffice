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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained();
            $table->enum('bank_name', [
                'BCA', 'BNI', 'BRI', 'BSI', 'CIMB', 'MANDIRI', 'PERMATA', 'JAGO', 'SEABANK', 'NEOBANK',
                'DANA', 'OVO', 'GOPAY', 'LINKAJA', 'SAKUKU', 'SHOPEEPAY'
            ]);
            $table->enum('bank_type', ['bank', 'wallet']);
            $table->string('account_number');
            $table->string('account_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
