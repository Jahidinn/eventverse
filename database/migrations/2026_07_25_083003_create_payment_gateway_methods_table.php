<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_gateway_methods', function (Blueprint $table) {

            $table->id();

            $table->foreignId('payment_gateway_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('payment_method_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('gateway_code');

            $table->enum('fee_type', [
                'fixed',
                'percent',
            ])->default('fixed');

            $table->decimal('fee_value', 12, 2)->default(0);

            $table->decimal('fee_min', 12, 2)->nullable();

            $table->decimal('fee_max', 12, 2)->nullable();

            $table->unsignedInteger('sort_order')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(
                ['payment_gateway_id', 'payment_method_id'],
                'pgm_gateway_method_unique'
            );

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_gateway_methods');
    }
};