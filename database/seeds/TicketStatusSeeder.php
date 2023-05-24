<?php

use Illuminate\Database\Seeder;
use App\Models\Ticket\TicketStatus;
use App\Models\Ticket\TicketStatusFlow;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            DB::table('ticket_status_flow')->delete();
            DB::table('ticket_status')->delete();

            $new        = TicketStatus::create([ 'name' => 'New', 'description' => 'Status of a newly created ticket that is not assigned to an agent.' ]);
            $open       = TicketStatus::create([ 'name' => 'Open', 'description' => 'Status of a ticket when it is assigned to an agent.' ]);
            $inProgress = TicketStatus::create([ 'name' => 'In Progress', 'description' => 'Status of a ticket when it is being processed by an agent.' ]);
            $needInfo   = TicketStatus::create([ 'name' => 'Needs More Info', 'description' => 'Status of a ticket when the agent needs more information to resolve the issue.' ]);
            $resolved   = TicketStatus::create([ 'name' => 'Resolved', 'description' => 'Status of a ticket when the agent resolves the ticket.'  ]);
            $closed     = TicketStatus::create([ 'name' => 'Closed', 'description' => 'Status of a ticket when the team leader or admin verifies the resolution of the isue.' ]);

            //New => Open
            TicketStatusFlow::create([
                'from_status_id' => $new->id,
                'to_status_id' => $open->id
            ]);

            //Open => In Progress
            TicketStatusFlow::create([
                'from_status_id' => $open->id,
                'to_status_id' => $inProgress->id
            ]);

            //In Progress => Needs More Info
            TicketStatusFlow::create([
                'from_status_id' => $inProgress->id,
                'to_status_id' => $needInfo->id
            ]);

            //Needs More Info => In Progress
            TicketStatusFlow::create([
                'from_status_id' => $needInfo->id,
                'to_status_id' => $inProgress->id
            ]);

            //In Progress => Resolved
            TicketStatusFlow::create([
                'from_status_id' => $inProgress->id,
                'to_status_id' => $resolved->id
            ]);

            //Resolved => Closed
            TicketStatusFlow::create([
                'from_status_id' => $resolved->id,
                'to_status_id' => $closed->id
            ]);

            //Closed => Open
            TicketStatusFlow::create([
                'from_status_id' => $closed->id,
                'to_status_id' => $open->id
            ]);
        });
    }
}
