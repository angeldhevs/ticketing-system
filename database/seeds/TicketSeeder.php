<?php

use Illuminate\Database\Seeder;
use App\Models\Ticket\Ticket;
use Faker\Factory as Faker;
use App\Models\Manage\User;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $sources = DB::table('ticket_sources')->pluck('id');
        $severity_ids = DB::table('ticket_severities')->pluck('id');
        $user_ids = User::all()->pluck('id');
        // $reporter_ids = UserRole::where('role_id', 1)->get()->pluck('user_id');
        // $assignee_ids = UserRole::where('role_id', 2)->get()->pluck('user_id');

        foreach (range(1,30) as $index) {
            $data = [
                'ticket_title'      => implode(' ', $faker->words(10)),
                'client_name'       => $faker->name,
                'client_email'      => $faker->email,
                'ticket_details'    => $faker->paragraph(1),
                'source_id'         => $faker->randomElement($sources),
                'severity_id'       => $faker->randomElement($severity_ids),
            ];

            if($data['source_id'] === 1) {
                $data['severity_id'] = 1;
                $data['status_id'] = 1;
            }

            if($data['severity_id'] > 1) {
                $data += [
                    'reporter_id'   => $faker->randomElement($user_ids),
                    'assignee_id'   => $faker->randomElement($user_ids)
                ];
            }

            Ticket::create($data);
        }
    }
}
