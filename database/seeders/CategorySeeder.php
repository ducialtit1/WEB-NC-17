<?php
// filepath: database/seeders/CategorySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Check if categories already exist to avoid duplicates
        if (!Category::where('slug', 'pizza')->exists()) {
            Category::create([
                'name' => 'Pizza',
                'slug' => 'pizza',
            ]);
        }

        if (!Category::where('slug', 'do-uong')->exists()) {
            Category::create([
                'name' => 'Đồ uống',
                'slug' => 'do-uong',
            ]);
        }
    }
}