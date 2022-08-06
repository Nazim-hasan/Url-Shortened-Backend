<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('clients')->insert([
            'name'=>'Nazim Hasan',
            'password'=>'nazu12345',
            'email'=>'nazim@gmail.com',
            'status'=>'active',
        ]);
        DB::table('clients')->insert([
            'name'=>Str::random(10),
            'password'=>Str::random(15),
            'email'=>Str::random(10).'@gmail.com',
            'status'=>Str::random(10),
        ]);
    }
}
