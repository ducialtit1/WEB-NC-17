# Dự án Laravel Food Store
## Tính năng

- Trang chủ hiện đại với phần hero, sản phẩm nổi bật, giới thiệu, liên hệ
- Thiết kế responsive, ưu tiên di động, hiệu ứng mượt mà
- CSS nâng cao với các mẫu thiết kế hiện đại
- Quản lý đơn hàng cho admin: cập nhật trạng thái, giao hàng, hoàn thành
- Phân quyền quản trị cho các chức năng admin
- Quản lý sản phẩm, người dùng, bình luận
- Đã tích hợp Laravel Breeze cho xác thực và quản lý người dùng

## Hướng dẫn cài đặt

1. Clone dự án về máy
2. Cài đặt các package:
   ```
   composer install
   npm install
   ```
3. Sao chép file `.env.example` thành `.env` và cập nhật thông tin database
4. Tạo key ứng dụng:
   ```
   php artisan key:generate
   ```
5. Cài đặt Laravel Breeze:
   ```
   composer require laravel/breeze --dev
   php artisan breeze:install
   npm install && npm run dev
   php artisan migrate
   ```
6. (Tùy chọn) Seed dữ liệu mẫu:
   ```
   php artisan db:seed
   ```
7. Khởi động server phát triển:
   ```
   php artisan serve
   ```

## Quy trình trạng thái đơn hàng

- Đơn hàng có thể chuyển qua các trạng thái: `pending`, `processing`, `shipping`, `completed`, `cancelled`
- Admin có thể chuyển đơn sang trạng thái giao hàng hoặc hoàn thành từ dashboard

## Cấu trúc thư mục

- `app/Models/` - Model Eloquent
- `app/Http/Controllers/` - Controller cho web và admin
- `resources/views/` - Giao diện Blade cho frontend và admin
- `public/css/` - File CSS
- `database/migrations/` - File migration cho database
- `routes/` - Định nghĩa route

## Lưu ý

- Đảm bảo sử dụng đúng tên route, ví dụ: `admin.orders.index`
- Tùy chỉnh giao diện tại các file Blade và CSS trong `resources/views` và `public/css`
- Laravel Breeze đã được cài đặt để hỗ trợ xác thực và quản lý người dùng
