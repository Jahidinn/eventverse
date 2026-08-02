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
        Schema::table('transaction_forms', function (Blueprint $table) {
            $table->longText('form_value')
                ->nullable()
                ->change();

            $table->index('transaction_id');
            $table->index('form_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_forms', function (Blueprint $table) {
            $table->dropIndex(['transaction_id']);
            $table->dropIndex(['form_id']);

            $table->dropColumn('form_value');

            $table->string('form_value')->nullable();
        });
    }
};
