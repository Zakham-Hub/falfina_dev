<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AdminTableSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('admins')->delete();
        $admin = Admin::create([
            'name' => 'Mostafa',
            'email' => 'admin@app.com',
            'password' => '123123',
            'type' => 'admin',
            'status' => 'active',
            'remember_token' => Str::random(10),
        ]);
        $admin = Admin::create([
            'name' => 'Hesham',
            'email' => 'mm@app.com',
            'password' => '123123',
            'status' => 'inactive',
            'type' => 'supervisor',
            'remember_token' => Str::random(10),
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
