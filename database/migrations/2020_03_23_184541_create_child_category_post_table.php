<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildCategoryPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_categoryPost', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('child_category_id')->unsigned();
            $table->bigInteger('post_id')->unsigned();
            $table->foreign('child_category_id')->references('id')->on('child_categories');
            $table->foreign('post_id')->references('id')->on('posts');
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
        Schema::dropIfExists('child_category_post');
    }
}
