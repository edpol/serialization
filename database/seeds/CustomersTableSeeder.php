<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            'name' => "REX3"
        ]);

        if (strtolower(env('APP_ENV'))!="production"){
            factory(App\Customer::class,9)->create();
        }
    }

//  don't forget php artisan passport:install to generate keys

}
