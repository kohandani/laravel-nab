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
        Schema::create('images', function (Blueprint $table) {

            $table->id();

            $table->foreignId('shop_id')->constrained()->onDelete("cascade");

            $table->enum("type" , ["banner","normal"])->nullable();

            $table->enum("position" , ["top","mid","bot"])->nullable();

            $table->string("image_src");

            $table->string("image_alt");

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
        Schema::dropIfExists('images');
    }
};
