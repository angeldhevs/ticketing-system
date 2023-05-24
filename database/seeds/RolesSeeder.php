<?php

use Illuminate\Database\Seeder;
use App\Models\Manage\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        Role::create(array('name' => 'admin', 'display_name' => 'Administrator'));
        // Role::create(array('name' => 'team_leader', 'display_name' => 'Team Leader'));
        Role::create(array('name' => 'agent', 'display_name' => 'Agent'));
        Role::create(array('name' => 'superadmin', 'display_name' => 'Super Admin'));
    }
}
