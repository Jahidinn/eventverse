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
		Schema::create('organisations', function (Blueprint $table) {
			$table->id();
			$table->string('org_id');
			$table->string('org_name');
			$table->string('org_institution');
			$table->string('org_address');
			$table->string('org_contact');
			$table->enum('org_type', ['Public', 'Private'])->default('Public');
			$table->integer('org_status')->default(1);
			$table->string('org_image')->nullable();
			$table->boolean('verified')->default(false);
			$table->foreignId('user_created');
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('organisations');
	}
};
