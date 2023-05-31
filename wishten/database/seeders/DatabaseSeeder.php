<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin',
            'password' => Hash::make('admin'),
            'role'  =>  'admin',
            'created_at'  =>  \Carbon\Carbon::now(),
            'updated_at'  =>  \Carbon\Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@user.user',
            'password' => Hash::make('user'),
            'created_at'  =>  \Carbon\Carbon::now(),
            'updated_at'  =>  \Carbon\Carbon::now()
        ]);

        DB::table('subjects')->insert([
            'name'  =>  'Uncategorized'
        ]);
    }
}
