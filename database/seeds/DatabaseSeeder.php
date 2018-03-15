<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numOfUsers = 10;
        for ($i = 1; $i <= $numOfUsers; $i++){
            User::query()->create([
                'name' => "User $i " . str_random(10),
                'balance' => rand(0,10000)
            ]);
        }
    }
}
