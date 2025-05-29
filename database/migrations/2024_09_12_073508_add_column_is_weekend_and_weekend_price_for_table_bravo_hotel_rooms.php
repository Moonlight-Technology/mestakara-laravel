<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsWeekendAndWeekendPriceForTableBravoHotelRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bravo_hotel_rooms', function (Blueprint $table) {
            $table->boolean('is_weekend')->default(false);
            $table->integer('weekend_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bravo_hotel_rooms', function (Blueprint $table) {
            $table->dropColumn('is_weekend')->default(false);
            $table->dropColumn('weekend_price')->nullable();
        });
    }
}
