<?php

use Illuminate\Support\Facades\Hash;
use App\User;
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
        $user = new User;
        $user->forceFill([
            'name'      => 'jason',
            'balance'   => 123.45,
            'password'  => Hash::make('password'),
        ])->save();
    }
}
