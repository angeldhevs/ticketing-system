<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketStatusFlowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_status_flow', function (Blueprint $table) {
            $table->bigInteger('from_status_id')->unsigned()->nullable(false);
            $table->bigInteger('to_status_id')->unsigned()->nullable(false);
            $table->timestamps();

            $table
                ->foreign('from_status_id')
                ->references('id')
                ->on('ticket_status')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('to_status_id')
                ->references('id')
                ->on('ticket_status')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['from_status_id', 'to_status_id']);
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
        Schema::dropIfExists('ticket_status_flow');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
