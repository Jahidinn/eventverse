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
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('username');
			$table->string('email')->unique();
			$table->string('no_tlp')->unique()->nullable();
			$table->text('profile_picture')->nullable();
			$table->bigInteger('no_rekening')->unique()->nullable();
			$table->string('bank')->nullable();
			$table->foreignId('category_id')->default(1);
			$table->foreignId('status')->default(1);
			$table->string('password');
			$table->boolean('verified')->default(false);
			$table->timestamp('email_verified_at')->nullable();
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('users');
	}
};
