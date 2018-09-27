<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FeatureVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('user_id');
            $table->foreign('feature_id')->references('id')->on('features');
            $table->unsignedInteger('feature_id');
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
        Schema::dropIfExists('feature_votes');
    }
}
