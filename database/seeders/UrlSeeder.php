<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('urls')->insert([
            'main_url'=>Str::random(10),
            'converted_url'=>Str::random(15),
            'user_id'=>1,
            'client_ip_address'=> 0,
        ]);
    }
}
