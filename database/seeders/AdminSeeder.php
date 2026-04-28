<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::updateOrCreate(
            ['email' => 'admin@askdocph.com'],
            [
                'fname' => 'System',
                'lname' => 'Admin',
                'mname' => null,
                'password' => Hash::make('password123'),
                'gender' => 'other',
                'bday' => '1990-01-01',
                'avatar_url' => null,
            ]
        );
    }
}
