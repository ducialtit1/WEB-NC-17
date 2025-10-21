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
        $foodImageMap = [
            'Pizza' => ['pizza_1.jpg', 'pizza_2.jpg', 'pizza_3.jpg', 'pizza_4.jpg'],
            'Mì Ý' => ['miy_1.jpg', 'miy_2.jpg', 'miy_3.jpg', 'miy_4.jpg'],
            'Hamburger' => ['ham_1.jpg', 'ham_2.jpg', 'ham_3.jpg', 'ham_4.jpg'],
            'Salad' => ['salad_1.jpg', 'salad_2.jpg', 'salad_3.jpg', 'salad_4.jpg'],
            'Sushi' => ['sushi_1.jpg', 'sushi_2.jpg', 'sushi_3.jpg', 'sushi_4.jpg'],
        ];
        $drinkImageMap = [
            'Coca Cola' => ['coca.jpg'],
            'Pepsi' => ['pepsi.jpg'],
            'Trà Đào' => ['tradao.jpg'],
            'Nước Cam' => ['nuoccam.jpg'],
        ];

        Product::factory(50)->create()->each(function ($product) use ($foodImageMap, $drinkImageMap) {
            if ($product->type === 'food') {
                $images = $foodImageMap[$product->name] ?? ['default.jpg'];
            } else {
                $images = $drinkImageMap[$product->name] ?? ['default.jpg'];
            }
            $randomImage = $images[array_rand($images)];

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $randomImage,
                'is_main' => true,
            ]);
        });
    }
}