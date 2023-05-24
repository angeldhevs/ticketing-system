<?php

use Illuminate\Database\Seeder;
use App\Models\Ticket\TicketSeverity;

class TicketSeveritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_severities')->delete();

        TicketSeverity::create([ 'name' => 'Unclassified'   ]);
        TicketSeverity::create([ 'name' => 'Low'            ]);
        TicketSeverity::create([ 'name' => 'Medium'         ]);
        TicketSeverity::create([ 'name' => 'High'           ]);
        TicketSeverity::create([ 'name' => 'Critical'       ]);
    }
}
