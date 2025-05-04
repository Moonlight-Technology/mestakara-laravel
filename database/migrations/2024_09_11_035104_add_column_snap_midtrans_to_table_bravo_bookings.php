<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSnapMidtransToTableBravoBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bravo_bookings', function (Blueprint $table) {
            $table->text('snap_midtrans')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bravo_bookings', function (Blueprint $table) {
            $table->dropColumn('snap_midtrans')->nullable();
        });
    }
}
