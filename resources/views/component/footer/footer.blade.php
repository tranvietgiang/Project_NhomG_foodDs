<style>
    .footer {
        background-color: #f8f9fa;
        padding: 40px 0;
        border-top: 4px solid #28a745;
        margin-top: 50px;
        font-family: 'Arial', sans-serif;
    }

    .footer h5 {
        color: #28a745;
        margin-bottom: 20px;
        font-weight: 700;
        font-size: 1.25rem;
        text-transform: uppercase;
    }

    .footer p {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 8px;
        line-height: 1.6;
    }

    .footer .social-icons a {
        color: #28a745;
        font-size: 1.5rem;
        margin-right: 15px;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .footer .social-icons a:hover {
        color: #218838;
        transform: translateY(-3px);
    }

    .footer .copyright {
        color: #6c757d;
        font-size: 0.85rem;
        margin-top: 20px;
    }

    .footer-section {
        margin-top: 40px;
        background: #fff;
        padding: 30px 0;
        font-family: 'Arial', sans-serif;
    }

    .footer-section h5 {
        font-size: 1.2rem;
        margin-bottom: 20px;
        font-weight: 700;
        color: #28a745;
        text-align: center;
    }

    .footer-section .btn-success {
        width: 100%;
        padding: 10px;
        font-size: 1.1rem;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .footer-section .btn-success:hover {
        background-color: #218838;
    }

    .footer-section ul.list-unstyled {
        padding: 0;
    }

    .footer-section ul.list-unstyled li {
        font-size: 0.9rem;
        color: #333;
        margin-bottom: 10px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .footer-section ul.list-unstyled li:hover {
        color: #28a745;
    }

    .footer-section p {
        font-size: 0.9rem;
        margin-bottom: 12px;
        color: #333;
        line-height: 1.6;
    }

    .footer-section span {
        font-size: 0.85rem;
        color: #555;
        text-align: center;
        display: block;
        margin-top: 8px;
    }

    .image-product-content-1,
    .image-product-content-4 {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .image-product-content-1:hover,
    .image-product-content-4:hover {
        transform: scale(1.05);
    }

    .image-product-content-3 {
        width: 100%;
        height: 180px;
        object-fit: cover;
        margin-bottom: 15px;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .image-product-content-3:hover {
        transform: scale(1.03);
    }

    .footer-section .col-md-4,
    .footer-section .col-md-3,
    .footer-section .col-md-2 {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .footer-section .col-md-4 img,
    .footer-section .col-md-3 img,
    .footer-section .col-md-2 img {
        margin-bottom: 15px;
    }

    .footer-section .d-flex {
        flex-direction: column;
        align-items: center;
        margin-bottom: 20px;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .footer {
            padding: 30px 15px;
        }

        .footer h5 {
            font-size: 1.1rem;
        }

        .footer p {
            font-size: 0.85rem;
        }

        .footer .social-icons a {
            font-size: 1.3rem;
            margin-right: 10px;
        }

        .footer-section {
            padding: 20px 15px;
        }

        .footer-section h5 {
            font-size: 1.1rem;
        }

        .footer-section p,
        .footer-section span {
            font-size: 0.85rem;
        }

        .image-product-content-3 {
            height: 150px;
        }

        .image-product-content-1,
        .image-product-content-4 {
            width: 80px;
            height: 80px;
        }
    }

    @media (max-width: 576px) {
        .footer-section .col-12 {
            margin-bottom: 20px;
        }

        .footer-section .btn-success {
            font-size: 1rem;
        }

        .footer-section ul.list-unstyled li {
            font-size: 0.85rem;
        }
    }
</style>


<section class="footer-section container">
    <div class="row">
        <!-- Cột 1: Danh sách liên kết -->
        <div class="col-12 col-md-3 mb-4">
            <h5 class="btn btn-success">AGRISHOW</h5>
            <ul class="list-unstyled">
                <li>Nông Nghiệp 360</li>
                <li>Câu Chuyện Và Nhân Vật</li>
                <li>Podcast - Agrishow</li>
                <li>Trải Nghiệm Nông Nghiệp</li>
                <li>Agritech</li>
                <li>Nông Nghiệp Bền Vững</li>
                <li>Xuất Nhập Khẩu</li>
                <li>Trồng Cây Nuôi Con</li>
            </ul>
        </div>

        <!-- Cột 2: Ảnh nhỏ + mô tả -->
        <div class="col-12 col-md-4 mb-4">
            <img class="image-product-content-1 img-fluid"
                src="https://news.foodmap.vn/wp-content/uploads/2025/03/Tao-co-vitamin-C-khong.jpg"
                alt="Táo Fuji Nam Phi">
            <p>Táo Fuji Nam Phi – Lợi ích và những đặc điểm nổi bật mà bạn cần biết!</p>
            <p>Một quả cam sành bao nhiêu calo? Giải đáp chi tiết từ Foodmap</p>
        </div>

        <!-- Cột 3: Hai ảnh lớn -->
        <div class="col-12 col-md-3 mb-4">
            <img class="image-product-content-3 img-fluid mb-2"
                src="https://news.foodmap.vn/wp-content/uploads/2025/03/Tao-co-vitamin-C-khong.jpg" alt="Cam Sành">
            <p>Táo có vitamin C không? Khám phá tác dụng của táo với sức khỏe</p>

            <img class="image-product-content-3 img-fluid"
                src="https://news.foodmap.vn/wp-content/uploads/2025/03/Tao-co-vitamin-C-khong.jpg" alt="Mít Thái">
            <p>Táo Fuji Nam Phi có giòn không? Mọi điều bạn cần biết về loại táo này!</p>
        </div>

        <!-- Cột 4: Ảnh nhỏ dọc -->
        <div class="col-12 col-md-2">
            <div class="text-center d-flex justify-content-center align-items-center gap-2 ">
                <img class="image-product-content-4 img-fluid mb-2"
                    src="https://news.foodmap.vn/wp-content/uploads/2025/03/Tao-co-vitamin-C-khong.jpg" alt="Nước mắm">
                <span>Lorem ipsum dolor sit amet.</span>
            </div>
            <div class="text-center d-flex justify-content-center align-items-center gap-2 mt-3">
                <img class="image-product-content-4 img-fluid mb-2"
                    src="https://news.foodmap.vn/wp-content/uploads/2025/03/Tao-co-vitamin-C-khong.jpg"
                    alt="Nước mắm me">
                <span>Lorem, ipsum dolor sit amet consectetur adipisicing.</span>
            </div>
            <div class="text-center d-flex justify-content-center align-items-center gap-2 mt-3">
                <img class="image-product-content-4 img-fluid mb-2"
                    src="https://news.foodmap.vn/wp-content/uploads/2025/03/Tao-co-vitamin-C-khong.jpg"
                    alt="Gỏi nước mắm">
                <span>Lorem ipsum dolor sit amet consectetur.</span>
            </div>
            <div class="text-center d-flex justify-content-center align-items-center gap-2 mt-3">
                <img class="image-product-content-4 img-fluid mb-2"
                    src="https://news.foodmap.vn/wp-content/uploads/2025/03/Tao-co-vitamin-C-khong.jpg"
                    alt="1 lít nước mắm">
                <span>Lorem ipsum dolor sit amet.</span>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer container">
    <div class="row">
        <div class="col-md-4 mb-3">
            <h5>Về chúng tôi</h5>
            <p>Foodmap là nền tảng kết nối nông dân, nhà sản xuất thực phẩm với người tiêu dùng thông qua các sản phẩm
                chất lượng và an toàn.</p>
        </div>
        <div class="col-md-4 mb-3">
            <h5>Liên hệ</h5>
            <p>Email: contact@foodmap.vn</p>
            <p>Điện thoại: 0123 456 789</p>
            <p>Địa chỉ: 123 Đường ABC, TP.HCM</p>
        </div>
        <div class="col-md-4 mb-3">
            <h5>Theo dõi chúng tôi</h5>
            <div class="social-icons">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center mt-3">
            <p class="copyright">&copy; 2025 Foodmap. All rights reserved.</p>
        </div>
    </div>
</footer>
