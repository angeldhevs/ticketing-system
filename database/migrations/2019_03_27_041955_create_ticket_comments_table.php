<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ticket_id')->unsigned()->nullable(false);
            $table->bigInteger('parent_comment_id')->unsigned()->nullable(true);
            $table->bigInteger('commenter_id')->unsigned()->nullable(false);
            $table->string('comment', 300)->nullable(false);
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreign('parent_comment_id')->references('id')->on('ticket_comments');
            $table->foreign('commenter_id')->references('id')->on('users');
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
        Schema::dropIfExists('ticket_comments');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
