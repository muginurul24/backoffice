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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained();
            $table->enum('bank_name', [
                'QRIS',
                'TELKOMSEL', 'XL',
                'BTC', 'USDT', 'BNB', 'SOL', 'XRP',
                'BCA', 'BNI', 'BRI', 'BSI', 'CIMB', 'MANDIRI', 'PERMATA', 'JAGO', 'SEABANK', 'NEOBANK',
                'DANA', 'OVO', 'GOPAY', 'LINKAJA', 'SAKUKU', 'SHOPEEPAY'
            ]);
            $table->enum('bank_type', ['qris', 'pulsa', 'crypto', 'bank', 'wallet']);
            $table->string('account_number');
            $table->string('account_name');
            $table->boolean('status')->default(true);
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
