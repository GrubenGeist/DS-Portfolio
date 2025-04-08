<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Administrator', 'slug' => 'administrator']);
        Role::create(['name' => 'Editor', 'slug' => 'editor']);
        Role::create(['name' => 'User', 'slug' => 'user']);
    }
}