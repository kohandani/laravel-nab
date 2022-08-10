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
        Schema::create('shops', function (Blueprint $table) {

            $table->id();
            $table->foreignId('guild_id')->constrained()->onDelete("cascade");
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('video')->nullable();
            $table->text('address');
            $table->string('website')->nullable();
            $table->string('license')->nullable();
            $table->string('page_link')->unique();

            $table->string('top_box_title');
            $table->text('top_box_body');

            $table->string('mid_box_title');
            $table->text('mid_box_body');

            $table->string('bot_box_title');
            $table->text('bot_box_body');

            $table->boolean("show_status")->default(0);
            $table->unsignedInteger('stablished_at');
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
        Schema::dropIfExists('shops');
    }
};
