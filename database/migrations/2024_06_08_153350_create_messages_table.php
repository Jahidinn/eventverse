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
		Schema::dropIfExists('messages');

		Schema::create('messages', function (Blueprint $table) {
			$table->id();
			$table->string('ip');
			$table->string('email');
			$table->string('name');
			$table->string('subjek');
			$table->string('message');
			$table->boolean('is_reply')->default(0);
			$table->string('user_reply')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
	}
};
