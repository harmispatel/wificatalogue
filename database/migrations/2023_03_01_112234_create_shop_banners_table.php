<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_banners', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id');
            $table->string('key');

            $table->string('title')->nullable();
            $table->string('en_title')->nullable();
            $table->string('fr_title')->nullable();
            $table->string('el_title')->nullable();
            $table->string('it_title')->nullable();
            $table->string('es_title')->nullable();
            $table->string('de_title')->nullable();
            $table->string('bg_title')->nullable();
            $table->string('tr_title')->nullable();
            $table->string('ro_title')->nullable();
            $table->string('sr_title')->nullable();
            $table->string('zh_title')->nullable();
            $table->string('ru_title')->nullable();
            $table->string('pl_title')->nullable();
            $table->string('ka_title')->nullable();

            $table->string('image')->nullable();
            $table->string('en_image')->nullable();
            $table->string('fr_image')->nullable();
            $table->string('el_image')->nullable();
            $table->string('it_image')->nullable();
            $table->string('es_image')->nullable();
            $table->string('de_image')->nullable();
            $table->string('bg_image')->nullable();
            $table->string('tr_image')->nullable();
            $table->string('ro_image')->nullable();
            $table->string('sr_image')->nullable();
            $table->string('zh_image')->nullable();
            $table->string('ru_image')->nullable();
            $table->string('pl_image')->nullable();
            $table->string('ka_image')->nullable();

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
        Schema::dropIfExists('shop_banners');
    }
}
