<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name'                  => 'admin',
            'username'              => 'admin',
            'email'                 => 'admin@gmail.com',
            'is_admin'              => true,
            'password'              => Hash::make('admin123'),
            'email_verified_at'     => date('Y-m-d H:i:s'),
            'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s')
        ]);

        \DB::table('users')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name'                  => 'user',
            'username'              => 'user',
            'email'                 => 'user@gmail.com',
            'is_admin'              => false,
            'password'              => Hash::make('user123'),
            'email_verified_at'     => date('Y-m-d H:i:s'),
            'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s')
        ]);
    }
}
