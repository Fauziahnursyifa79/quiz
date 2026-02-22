<?php


namespace Database\Seeders;


// tambahkan 3 baris kode dibawah
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = User::create([
            'name' => 'Administrator',
            'email'=> 'admin@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        $admin->assignRole('admin');
    }
}
