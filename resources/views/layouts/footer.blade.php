<footer class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-section">
                    <h5 class="footer-title mb-3">
                        <i class="bi bi-shop me-2"></i>Food Store
                    </h5>
                    <p class="footer-text">
                        Điểm đến tin cậy cho những ai yêu thích ẩm thực chất lượng.
                        Chúng tôi mang đến những sản phẩm tươi ngon nhất với dịch vụ tốt nhất.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link me-3"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link me-3"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-link me-3"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="footer-section">
                    <h6 class="footer-subtitle mb-3">Danh mục</h6>
                    <ul class="footer-links">
                        <li><a href="{{ url('/#foods-list') }}">Đồ ăn</a></li>
                        <li><a href="{{ url('/#drinks-list') }}">Đồ uống</a></li>
                        <li><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
                        @auth
                        <li><a href="{{ route('my.orders') }}">Đơn hàng</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-section">
                    <h6 class="footer-subtitle mb-3">Liên hệ</h6>
                    <ul class="footer-contact">
                        <li>
                            <i class="bi bi-geo-alt me-2"></i>
                            123 Đường ABC, Quận 1, TP.HCM
                        </li>
                        <li>
                            <i class="bi bi-telephone me-2"></i>
                            0123 456 789
                        </li>
                        <li>
                            <i class="bi bi-envelope me-2"></i>
                            info@foodstore.com
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-section">
                    <h6 class="footer-subtitle mb-3">Giờ làm việc</h6>
                    <ul class="footer-schedule">
                        <li>
                            <span>Thứ 2 - Thứ 6:</span>
                            <span>8:00 - 22:00</span>
                        </li>
                        <li>
                            <span>Thứ 7 - Chủ nhật:</span>
                            <span>9:00 - 23:00</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="footer-divider my-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="footer-copyright mb-0">
                    &copy; {{ date('Y') }} Food Store. Tất cả quyền được bảo lưu.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="footer-links-inline">
                    <a href="#" class="me-3">Chính sách bảo mật</a>
                    <a href="#" class="me-3">Điều khoản dịch vụ</a>
                    <a href="#">Hỗ trợ</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.footer-section h5.footer-title {
    color: #fff;
    font-weight: 700;
    font-size: 1.5rem;
}

.footer-section h6.footer-subtitle {
    color: #fff;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.9rem;
}

.footer-text {
    color: #adb5bd;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.social-links .social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.1);
    color: #fff;
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-links .social-link:hover {
    background: #007bff;
    transform: translateY(-2px);
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 0.5rem;
}

.footer-links a {
    color: #adb5bd;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-links a:hover {
    color: #fff;
}

.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-contact li {
    color: #adb5bd;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: flex-start;
}

.footer-contact i {
    color: #007bff;
    margin-top: 2px;
    flex-shrink: 0;
}

.footer-schedule {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-schedule li {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    color: #adb5bd;
}

.footer-schedule li span:first-child {
    font-weight: 500;
}

.footer-divider {
    border-color: rgba(255,255,255,0.1);
}

.footer-copyright {
    color: #adb5bd;
    font-size: 0.9rem;
}

.footer-links-inline a {
    color: #adb5bd;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.footer-links-inline a:hover {
    color: #fff;
}

@media (max-width: 768px) {
    .footer-links-inline {
        margin-top: 1rem;
        text-align: center !important;
    }
}
</style>