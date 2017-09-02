<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTopPickColumnToGiftListSuggestionPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gift_list_suggestion', function (Blueprint $table) {
            $table->boolean('top_pick')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gift_list_suggestion', function (Blueprint $table) {
            $table->dropColumn(['top_pick']);
        });
    }
}
