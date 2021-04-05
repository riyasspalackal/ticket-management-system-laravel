<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User;


class UserDetails extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->delete();
        User::create(array(
        'name'     => 'test user',
        'username' => 'admin',
        'email'    => 'admin@gmail.com',
        'password' =>   bcrypt('admin123'),
    ));
    }
}
