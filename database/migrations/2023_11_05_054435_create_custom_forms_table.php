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
		Schema::create('custom_forms', function (Blueprint $table) {
			$table->id();
			$table->foreignId('event_id');
			$table->string('form_name');
			$table->integer('form_status')->default(0);
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('custom_forms');
	}
};
