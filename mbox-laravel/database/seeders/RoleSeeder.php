<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'value'=>'user',
        ]);
        Role::create([
            'value'=>'support',
        ]);
        Role::create([
            'value'=>'author',
        ]);
        Role::create([
            'value'=>'anonymous',
        ]);
    }
}
