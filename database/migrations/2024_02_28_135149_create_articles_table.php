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
		# Migrasi database artikel
		Schema::create('articles', function (Blueprint $table) {
			$table->id();
			$table->foreignId('category_id');
			$table->foreignId('user_id');
			$table->string('title');
			$table->string('slug')->unique();
			$table->string('input_image')->nullable();
			$table->text('excerpt');
			$table->text('body');
			$table->integer('article_code')->default(1);
			$table->string('tag')->nullable();
			$table->timestamp('published_at')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('articles');
	}
};
