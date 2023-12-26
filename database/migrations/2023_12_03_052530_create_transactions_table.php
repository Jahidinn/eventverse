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
		Schema::create('transactions', function (Blueprint $table) {
			$table->id();
			$table->foreignId('ticket_id');
			$table->foreignId('event_id');
			$table->string('name');
			$table->string('phone');
			$table->string('email');
			$table->integer('quantity');
			$table->bigInteger('total_price');
			$table->enum('status', ['Paid', 'Unpaid', 'Pending', 'Expired']);
			$table->string('transaction_id')->nullable();
			$table->string('payment_type')->nullable();
			$table->integer('is_login')->default(0);
			$table->integer('user_login_id')->default(0);
			$table->date('checkin')->nullable();
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('transactions');
	}
};
