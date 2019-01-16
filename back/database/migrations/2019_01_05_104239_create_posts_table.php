<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('content');
            $table->text('title');
            $table->string('slug', 200);
            $table->text('excerpt')->nullable();
            $table->unsignedTinyInteger('type')->default(1);
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedTinyInteger('comment_status')->default(1);
            $table->boolean('featured')->default(false);
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('posts');
    }
}
