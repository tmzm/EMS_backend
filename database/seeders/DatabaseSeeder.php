<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'new category'
        ]);
        Category::create([
            'name' => 'new category'
        ]);
        Category::create([
            'name' => 'new category'
        ]);
        Category::create([
            'name' => 'new category'
        ]);
        Category::create([
            'name' => 'new category'
        ]);
    }
}
