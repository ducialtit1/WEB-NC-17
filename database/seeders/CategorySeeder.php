<?php
// filepath: database/seeders/CategorySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create([
            'name' => 'Pizza',
            'slug' => 'pizza',
        ]);

        Category::create([
            'name' => 'Đồ uống',
            'slug' => 'do-uong',
        ]);
    }
}