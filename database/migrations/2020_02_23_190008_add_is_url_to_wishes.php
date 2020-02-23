<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsUrlToWishes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wishes', function (Blueprint $table) {
            $table->boolean('is_url')->after('where_to_buy')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wishes', function (Blueprint $table) {
            $table->dropColumn(['is_url']);
        });
    }
}
