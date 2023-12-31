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
			$table->bigInteger('rekening');
			$table->string('bank');
			$table->bigInteger('amount');
			$table->enum('status', ['Proses', 'Sukses', 'Gagal', 'Batal']);
			$table->integer('admin_check')->default(0);
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
