<?php
// filepath: app/Http/Controllers/ProductController.php
namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // Phân trang riêng cho đồ ăn và đồ uống
        $foods = Product::where('type', 'food')->paginate(9, ['*'], 'foods_page')->withQueryString();
        $drinks = Product::where('type', 'drink')->paginate(9, ['*'], 'drinks_page')->withQueryString();

        return view('products.index', compact('foods', 'drinks'));
    }
    public function show($slug)
    {
        $product = \App\Models\Product::with(['images', 'mainImage'])->where('slug', $slug)->firstOrFail();
        $comments = $product->approvedComments()->with('user')->get();
        if ($comments->isEmpty()) {
            $randomComments = $this->generateRandomComments();
            return view('products.show', compact('product', 'randomComments'));
        }
        return view('products.show', compact('product', 'comments'));
    }
    public function foodsAjax()
    {
        $foods = Product::where('type', 'food')->paginate(9);
        return view('products.partials._foods', compact('foods'))->render();
    }

    public function drinksAjax()
    {
        $drinks = Product::where('type', 'drink')->paginate(9);
        return view('products.partials._drinks', compact('drinks'))->render();
    }
    private function generateRandomComments()
    {
        $names = [
            'Nguyễn Văn A', 'Trần Thị B', 'Lê Văn C', 'Phạm Thị D', 
            'Hoàng Văn E', 'Võ Thị F', 'Đặng Văn G', 'Bùi Thị H',
            'Phan Văn I', 'Trịnh Thị J', 'Lý Văn K', 'Hồ Thị L',
            'Dương Văn M', 'Cao Thị N', 'Tạ Văn O', 'Lâm Thị P',
            'Vũ Văn Q', 'Đỗ Thị R', 'Ngô Văn S', 'Trương Thị T',
        ];
        
        $comments = [
            'Món ăn này rất ngon, tôi rất thích!', 
            'Chất lượng tuyệt vời, đóng gói cẩn thận.',
            'Giao hàng nhanh, sản phẩm đúng như mô tả.',
            'Mình đã thử nhiều lần và vẫn rất hài lòng.',
            'Giá cả hợp lý, sẽ mua lại lần sau.',
            'Hương vị đặc biệt, không thể tìm thấy ở nơi khác.',
            'Đáng tiền, tôi khuyên mọi người nên thử.',
            'Sản phẩm chất lượng, nhưng giao hàng hơi chậm.',
            'Tôi đã mua nhiều lần và không bao giờ thất vọng.',
            'Phục vụ tốt, sẽ giới thiệu cho bạn bè.',
        ];
        
        $randomComments = [];
        $commentCount = rand(4, 8); // Số lượng bình luận ngẫu nhiên
        
        for ($i = 0; $i < $commentCount; $i++) {
            $date = now()->subDays(rand(1, 60))->format('d/m/Y');
            
            $randomComments[] = [
                'id' => $i + 1,
                'name' => $names[array_rand($names)],
                'rating' => rand(4, 5),
                'date' => $date,
                'content' => $comments[array_rand($comments)],
            ];
        }
        
        // Sắp xếp bình luận theo ngày giảm dần (mới nhất lên đầu)
        usort($randomComments, function ($a, $b) {
            return strtotime(str_replace('/', '-', $b['date'])) - 
                  strtotime(str_replace('/', '-', $a['date']));
        });
        
        return $randomComments;
    }
    
    // ...other methods
}