<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'        => 'Administrator',
            'admin'       => 1,
            'customer_id' => 1,
            'username'    => 'Admin',
            'email'       => 'dnall@rex3.com',
            'password'    => bcrypt('secret')
        ]);
    }
}
