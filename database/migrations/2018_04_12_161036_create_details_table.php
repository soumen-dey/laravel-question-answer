<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->increments('id');
            $table->text('bio')->nullable()->default(null);
            $table->string('qualification')->nullable()->default(null);
            $table->string('works_at')->nullable()->default(null);
            $table->string('college')->nullable()->default(null);
            $table->string('designation')->nullable()->default(null);
            $table->date('dob')->nullable()->default(null);
            $table->integer('city_id')->nullable()->default(null);
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('details');
    }
}
