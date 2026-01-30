<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCategoryInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_category_interests', function (Blueprint $table) {
        
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
        $table->string('guest_id')->nullable(); // session_id
        $table->foreignId('category_id')->constrained()->cascadeOnDelete();
        $table->unsignedInteger('score')->default(0);
        $table->timestamps();

        $table->unique(['user_id', 'category_id']);
        $table->unique(['guest_id', 'category_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_category_interests');
    }
}
