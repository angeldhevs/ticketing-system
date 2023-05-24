<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Ticket\Ticket;

class TicketCommentsSeeder extends Seeder
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

        foreach($tickets as $ticket) {
            $commenter_ids = array($ticket->assignee_id, $ticket->reporter_id);
            $comments = $faker->paragraphs($faker->numberBetween(0, 4));

            foreach($comments as $comment) {
                $cmt = $ticket->addComment($comment, $faker->randomElement($commenter_ids));
                $replies = $faker->paragraphs($faker->numberBetween(0, 3));

                foreach($replies as $reply) {
                    $cmt->reply($reply, $faker->randomElement($commenter_ids));
                }
            }
        }
    }
}
