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
		Schema::create('withdraw_data', function (Blueprint $table) {
			$table->id();
			$table->foreignId('event_id');
			$table->foreignId('user_id');
			$table->integer('rekening');
			$table->bigInteger('amount');
			$table->enum('status', ['Proses', 'Pending', 'Sukses', 'Gagal']);
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('withdraw_data');
	}
};
