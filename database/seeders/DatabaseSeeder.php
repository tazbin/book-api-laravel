<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\category;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(5)->create();
        // Contact::factory(5)->create();

        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Category::factory()->create([
            'name' => 'Horroe'
        ]);

        Category::factory()->create([
            'name' => 'Comedy'
        ]);

        Category::factory()->create([
            'name' => 'Thriller'
        ]);
    }
}
