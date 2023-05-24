<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ticket_id')->unsigned()->nullable(false);
            $table->bigInteger('status_id')->unsigned()->nullable(false);
            $table->bigInteger('assignee_id')->unsigned()->nullable(true);
            $table->bigInteger('reporter_id')->unsigned()->nullable(true);
            $table->longText('remarks')->nullable();

            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreign('status_id')->references('id')->on('ticket_status');
            $table->foreign('assignee_id')->references('id')->on('users');
            $table->foreign('reporter_id')->references('id')->on('users');
            
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('ticket_activities');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
