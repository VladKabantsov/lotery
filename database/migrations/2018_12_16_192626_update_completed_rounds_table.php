<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCompletedRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('completed_rounds', function (Blueprint $table) {
            $table->unsignedInteger('room_id')->nullable();
            $table->foreign('room_id')
                ->references('id')->on('rooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('completed_rounds', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropColumn(['room_id']);
        });
    }
}
