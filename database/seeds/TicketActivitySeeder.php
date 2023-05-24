<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketStatus;
use App\Models\Manage\User;

class TicketActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $tickets = Ticket::has('assignee')->get();
        $user_ids = User::all()->pluck('id');
        // $assignee_ids = UserRole::where('role_id', 2)->get()->pluck('user_id');
        // $reporter_ids = UserRole::where('role_id', 1)->get()->pluck('user_id');

        foreach($tickets as $ticket) {
            $curr_status = $ticket->status;

            do {
                //Evaluate current status from the list of next status
                $next_status_ids =  $curr_status->next->pluck('id')->all();
                $curr_status_id = $faker->randomElement($next_status_ids);
                $curr_status = TicketStatus::find($curr_status_id);

                if($ticket->severity->name === 'Unclassified' || $curr_status === null || rand() % 17 === 0) {
                    break;
                }

                if($curr_status->name === 'Open') {
                    $ticket->update([
                        'status_id' => $curr_status->id,
                        'reporter_id' => $faker->randomElement($user_ids),
                        'assignee_id' => $faker->randomElement($user_ids)
                    ]);
                } else {
                    $ticket->update([
                        'status_id' => $curr_status->id
                    ]);
                }

            } while($curr_status !== null);
        }
    }
}
