<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
          'name'=>'Администратор',
            'email'=>'vasian@mail.ru',
            'password'=>bcrypt('11111111'),
            'is_admin'=>1,
        ]);
    }
}
