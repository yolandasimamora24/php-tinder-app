<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $genders = ['male', 'female', 'other'];
        $photos = [
            // Men
            'https://randomuser.me/api/portraits/men/1.jpg',
            'https://randomuser.me/api/portraits/men/2.jpg',
            'https://randomuser.me/api/portraits/men/3.jpg',
            'https://randomuser.me/api/portraits/men/4.jpg',
            'https://randomuser.me/api/portraits/men/5.jpg',
            'https://randomuser.me/api/portraits/men/6.jpg',
            'https://randomuser.me/api/portraits/men/7.jpg',
            'https://randomuser.me/api/portraits/men/8.jpg',
            'https://randomuser.me/api/portraits/men/9.jpg',
            'https://randomuser.me/api/portraits/men/10.jpg',
            // Women
            'https://randomuser.me/api/portraits/women/1.jpg',
            'https://randomuser.me/api/portraits/women/2.jpg',
            'https://randomuser.me/api/portraits/women/3.jpg',
            'https://randomuser.me/api/portraits/women/4.jpg',
            'https://randomuser.me/api/portraits/women/5.jpg',
            'https://randomuser.me/api/portraits/women/6.jpg',
            'https://randomuser.me/api/portraits/women/7.jpg',
            'https://randomuser.me/api/portraits/women/8.jpg',
            'https://randomuser.me/api/portraits/women/9.jpg',
            'https://randomuser.me/api/portraits/women/10.jpg',
        ];

        for ($i = 1; $i <= 100; $i++) {
            User::create([
                'name' => 'User ' . $i,
                'email' => 'user'.$i.'@example.com',
                'password' => Hash::make('password'), // default password
                'profile_photo' => $photos[array_rand($photos)],
                'bio' => 'This is a sample bio for user ' . $i,
                'gender' => $genders[array_rand($genders)],
                'age' => rand(18, 45),
            ]);
        }
    }
}
