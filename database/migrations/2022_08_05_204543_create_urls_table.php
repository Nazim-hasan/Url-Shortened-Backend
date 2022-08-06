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
        Schema::create('urls', function (Blueprint $table) {
            $table->id('url_id');
            $table->string('main_url');
            $table->string('converted_url')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('client_id')->on('clients')->onDelete('cascade');
            $table->string('client_ip_address');
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
        Schema::dropIfExists('urls');
    }
};
