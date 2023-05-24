<?php

use Illuminate\Database\Seeder;
use App\Models\Manage\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        User::create([ 'name'  => 'Super Admin', 'email' => 'superadmin@ticketing.com' , 'password' => 'P@ssword01' ]);
        // User::create([ 'name'  => 'Benedict L. Semilla', 'email' => 'benedict.11394@hotmail.com' , 'password' => 'secret' ]);
        // User::create([ 'name'  => 'Terjohn Torbela', 'email' => 'terjohnaldrixtorbela@gmail.com' , 'password' => 'secret' ]);
        // User::create([ 'name'  => 'Angela Rachel Bernardo', 'email' => 'sampletestghelay@gmail.com' , 'password' => 'secret' ]);
    }
}
