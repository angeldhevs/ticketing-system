<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tickets')->delete();

        $this->call(RolesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(TicketSeveritiesSeeder::class);
        $this->call(TicketSourcesSeeder::class);
        $this->call(TicketStatusSeeder::class);
        // $this->call(TicketSeeder::class);
        // $this->call(TicketActivitySeeder::class);
        // $this->call(TicketCommentsSeeder::class);
    }
}
