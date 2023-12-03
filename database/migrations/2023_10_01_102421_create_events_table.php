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
		Schema::create('events', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id');
			$table->string('title');
			$table->string('slug');
			$table->foreignId('category');
			$table->foreignId('theme');
			$table->string('location_jenis');
			$table->string('location_province')->nullable();
			$table->string('location_city')->nullable();
			$table->string('location_detail')->nullable();
			$table->integer('price_category')->nullable();
			$table->date('start_date');
			$table->date('end_date');
			$table->text('description')->nullable();
			$table->text('terms')->nullable();
			$table->string('image');
			$table->integer('visitor')->default(0);
			$table->integer('selected_event')->default(0);
			$table->integer('promotion')->default(0);
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('events');
	}
};
