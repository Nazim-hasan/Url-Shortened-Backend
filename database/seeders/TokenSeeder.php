<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tokens')->insert([
            'name'=>'Nazim Hasan',
            'token'=>'OaBasiB3AX7SeSB25JThGgJQvH0MRivPNJJF62LYlVzhXkYt3N0XwVD89oCxYprm',
        ]);
    }
}
