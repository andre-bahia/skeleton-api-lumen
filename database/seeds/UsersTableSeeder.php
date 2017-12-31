<?php

use App\Entities\User;
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
        User::truncate();
        $data = [];

        array_push($data, [
            'name'       => 'André Luis',
            'email'      => 'dev.andreluis@gmail.com',
            'password'   => app('hash')->make('123456'),
            'phone'       => '(44) 99129-8097',
            'active'     => 1
        ]);

        array_push($data, [
            'name'       => 'Chaves',
            'email'      => 'chaves@fake.com',
            'password'   => app('hash')->make('123456'),
            'phone'       => '(44) 89944-1245',
            'active'     => 1
        ]);

        User::insert($data);
    }
}
