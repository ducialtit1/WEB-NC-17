<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {
        // Danh sách từ khóa cho tên sản phẩm
        $foodKeywords = ['Pizza', 'Mì Ý', 'Hamburger', 'Salad', 'Sushi'];
        $drinkKeywords = ['Coca Cola', 'Pepsi', 'Trà Đào', 'Nước Cam', ];

        $foodImages = ['1.jpg', '2.jpg',  '4.jpg', '5.jpg'];
        $drinkImages = ['6.jpg','3.jpg' , '9.jpg'];

        $sizes = ['S', 'M', 'L', 'XL'];

        // Danh sách mô tả cho đồ ăn
        $foodDescriptions = [
            'Một món ăn ngon miệng, phù hợp cho mọi bữa ăn.',
            'Món ăn được chế biến từ nguyên liệu tươi ngon.',
            'Hương vị đậm đà, khó quên.',
            'Thích hợp cho bữa trưa hoặc bữa tối.',
            'Món ăn được yêu thích bởi nhiều khách hàng.',
        ];

        // Danh sách mô tả cho đồ uống
        $drinkDescriptions = [
            'Thức uống giải khát tuyệt vời cho ngày hè.',
            'Hương vị tươi mát, phù hợp với mọi bữa ăn.',
            'Một lựa chọn hoàn hảo để giải khát.',
            'Đồ uống được yêu thích bởi mọi lứa tuổi.',
            'Thức uống mang lại cảm giác sảng khoái.',
        ];

        // Random loại sản phẩm
        $type = $this->faker->randomElement(['food', 'drink']);

        $image = $type === 'food'
            ? $this->faker->randomElement($foodImages)
            : $this->faker->randomElement($drinkImages);

        // Random tên sản phẩm và mô tả dựa trên loại
        if ($type === 'food') {
            $name = $this->faker->randomElement($foodKeywords);
            $description = $this->faker->randomElement($foodDescriptions);
        } else {
            $name = $this->faker->randomElement($drinkKeywords);
            $description = $this->faker->randomElement($drinkDescriptions);
        }

        // Random giá dựa trên loại sản phẩm
        $price = $type === 'food'
            ? $this->faker->randomFloat(2, 50000, 500000) // Giá đồ ăn từ 50,000 đến 500,000
            : $this->faker->randomFloat(2, 10000, 50000); // Giá đồ uống từ 10,000 đến 50,000

        // Tạo slug duy nhất từ tên sản phẩm + timestamp để tránh trùng lặp
        $slug = \Illuminate\Support\Str::slug($name) . '-' . time() . '-' . rand(1000, 9999);

        return [
            'category_id' => $type === 'food' ? 1 : 2, // Giả sử 1 = Đồ ăn, 2 = Đồ uống
            'name' => $name,
            'slug' => $slug,
            'description' => $description, // Mô tả phù hợp với loại sản phẩm
            'price' => $price,
            'type' => $type,
            'size' => $this->faker->randomElement($sizes),
        ];
    }
}