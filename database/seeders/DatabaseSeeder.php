<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use App\Models\BlogCategory;
use App\Models\Category;
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
        $this->call([
            CategorySeeder::class
        ]);
        
        User::factory(5)->create();
        Blog::factory(15)->create();
        BlogCategory::factory(20)->create();
    }
}
