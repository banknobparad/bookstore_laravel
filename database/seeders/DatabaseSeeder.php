<?php

namespace Database\Seeders;
use App\Models\book;
use App\Models\bookcategory;



// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        
        bookcategory::insert([
            ['num_book' => '100','name_book' => 'ปรัชญา', 'book' => '1'],
            ['num_book' => '200','name_book' => 'ศาสนา', 'book' => '2'],
            ['num_book' => '300','name_book' => 'สังคมศาสตร์', 'book' => '3'],
            ['num_book' => '400','name_book' => 'ภาษาศาสตร์', 'book' => '4'],
            ['num_book' => '500','name_book' => 'วิทยาศาสตร์', 'book' => '5'],

        ]);

    }
}
