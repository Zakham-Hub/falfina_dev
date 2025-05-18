<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        User::create([
            'name' => 'User',
            'email' => 'User@app.com',
            'password' => bcrypt('123123'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        UserFactory::new()->count(5)->create();
        Schema::enableForeignKeyConstraints();
    }
}
