<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });

        

        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });

        Schema::table('languages', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });

        Schema::table('interests', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();

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

        Schema::table('personal_information', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->unsignedInteger('user_id')->change(); 
        });
        Schema::table('interests', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->unsignedInteger('user_id')->change(); 
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->unsignedInteger('user_id')->change(); 
        });

        Schema::table('languages', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->unsignedInteger('user_id')->change(); 
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->unsignedInteger('user_id')->change(); 
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->unsignedInteger('user_id')->change(); 
        });
    }
};