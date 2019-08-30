<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreateUsersTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('users', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('first_name');
				$table->string('last_name')->nullable();
				$table->timestamp('date_of_birth');
				$table->string('birthplace');
				$table->char('gender');
				$table->string('phone')->unique();
				$table->string('password');
				$table->integer('type')->default(0);
				$table->boolean('active')->default(false);
				$table->timestamps();
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('users');
		}
	}
