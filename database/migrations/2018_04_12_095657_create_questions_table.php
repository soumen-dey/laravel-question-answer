<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('body')->nullable()->default(null);
            $table->string('slug');
            $table->string('reference')->nullable()->default(null);
            $table->tinyInteger('is_anonymous')->default(0);
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('is_moderated')->default(0);
            $table->integer('best_answer_id')->unsigned()->nullable()->default(null);
            $table->integer('topic_id')->unsigned()->nullable()->default(null);
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
        Schema::dropIfExists('questions');
    }
}
