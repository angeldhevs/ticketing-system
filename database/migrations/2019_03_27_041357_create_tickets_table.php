<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ticket_number')->nullable(false);
            $table->string('ticket_title')->nullable(false);
            $table->string('client_name')->nullable(false);
            $table->string('client_email')->nullable(false);
            $table->longText('ticket_details')->nullable();
            
            $table->bigInteger('assignee_id')->unsigned()->nullable(true);
            $table->bigInteger('reporter_id')->unsigned()->nullable(true);
            $table->bigInteger('source_id')->unsigned()->nullable(false);
            $table->bigInteger('severity_id')->unsigned()->nullable(false);
            $table->bigInteger('status_id')->unsigned()->nullable(false);

            $table
                ->foreign('source_id')
                ->references('id')
                ->on('ticket_sources')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                
            $table
                ->foreign('severity_id')
                ->references('id')
                ->on('ticket_severities')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('status_id')
                ->references('id')
                ->on('ticket_status')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('assignee_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('reporter_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('tickets');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
