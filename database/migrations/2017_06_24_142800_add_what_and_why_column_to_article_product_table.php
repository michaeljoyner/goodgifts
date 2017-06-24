<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWhatAndWhyColumnToArticleProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_product', function (Blueprint $table) {
            $table->text('what')->nullable();
            $table->text('why')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_product', function (Blueprint $table) {
            $table->dropColumn(['what', 'why']);
        });
    }
}
