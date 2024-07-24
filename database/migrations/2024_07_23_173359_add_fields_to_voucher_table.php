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
        Schema::table('vouchers', function (Blueprint $table) {
            $table->string('document_currency_code', 20);
            $table->string('invoice_type_code', 20);
            $table->string('voucher_series', 20);
            $table->string('voucher_number', 20);
            $table->boolean('voucher_need_update')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn('document_currency_code');
            $table->dropColumn('invoice_type_code');
            $table->dropColumn('voucher_series');
            $table->dropColumn('voucher_number');
            $table->dropColumn('voucher_need_update');
        });
    }
};
