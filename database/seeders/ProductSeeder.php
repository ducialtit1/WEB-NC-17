<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Http\Controllers\CartController;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $foodImages = ['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg'];
        $drinkImages = ['6.jpg','9.jpg'];

        Product::factory(50)->create()->each(function ($product) use ($foodImages, $drinkImages) {
            $images = $product->type === 'food' ? $foodImages : $drinkImages;
            $randomImage = $images[array_rand($images)];

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $randomImage,
                'is_main' => true,
            ]);
        });
    }
}