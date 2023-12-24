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
		Schema::create('tickets', function (Blueprint $table) {
			$table->id();
			$table->foreignId('event_id');
			$table->string('ticket_name');
			$table->text('ticket_description')->nullable();
			$table->integer('ticket_quota');
			$table->integer('ticket_price');
			$table->date('ticket_start');
			$table->date('ticket_deadline');
			$table->string('ticket_button');
			$table->integer('more_quantity')->default(1);
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('tickets');
	}
};
