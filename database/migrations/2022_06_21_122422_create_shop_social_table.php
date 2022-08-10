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
        Schema::create('shop_social', function (Blueprint $table) {

            $table->foreignId('shop_id')->constrained()->onDelete("cascade");
            $table->foreignId('social_id')->constrained()->onDelete("cascade");
            $table->string("link");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_social');
    }
};
