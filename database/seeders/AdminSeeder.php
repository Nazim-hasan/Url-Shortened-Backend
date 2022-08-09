<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('admins')->insert([
            'name'=>'admin',
            'password'=>'admin123',
            'email'=>'admn@gmail.com',
            'spamming_limit'=>3,
            'waiting_time'=>5,
        ]);
        DB::table('admins')->insert([
            'name'=>Str::random(10),
            'password'=>Str::random(15),
            'email'=>Str::random(10).'@gmail.com',
            'spamming_limit'=>3,
            'waiting_time'=>5,
        ]);
    }
}
