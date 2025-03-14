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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('provider')->nullable()->comment('google, github, etc.');
            $table->string('provider_id')->nullable()->comment('Provider-specific user ID');
            $table->text('provider_token')->nullable()->comment('OAuth access token');
            $table->text('provider_refresh_token')->nullable()->comment('OAuth refresh token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'provider',
                'provider_id',
                'provider_token',
                'provider_refresh_token'
            ]);
        });
    }
};
