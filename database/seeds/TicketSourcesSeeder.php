<?php

use Illuminate\Database\Seeder;
use App\Models\Ticket\TicketSource;

class TicketSourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_sources')->delete();

        TicketSource::create(array('name' => 'Email'));
        TicketSource::create(array('name' => 'Created'));
    }
}
