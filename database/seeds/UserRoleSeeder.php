<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Manage\User;
use App\Models\Manage\Role;
use App\Models\Manage\UserRole;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $userIds = User::all()->pluck('id');
        // $roleIds = Role::all()->pluck('id');

        // foreach ($userIds as $userId) {
        //     UserRole::create([
        //         'user_id' => $userId,
        //         'role_id' => $roleIds[$userId % $roleIds->count()]
        //     ]);
        // }
        UserRole::create([
          'user_id' => User::first()->id,
          'role_id' => Role::where('name', 'superadmin')->first()->id
        ]);
    }
}
