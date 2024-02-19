<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'Jaafar Abd',
            'email' => 'jaafar@gmail.com',
            'password' => Hash::make('password'),
            'type' => 'admin',
            'state' => 'active'
        ]);
        User::create([
            'name' => 'Ahmad Ali',
            'email' => 'ahmad@gmail.com',
            'password' => Hash::make('password'),
            'type' => 'student',
            'state' => 'inactive'
        ]);
        Subject::create([
            'name' => 'Math',
            'mark' => '50',
        ]);
        Grade::create([
            'subject_id' => '1',
            'user_id' => '2',
            'mark_obtained' => '90',
        ]);
    }
}
