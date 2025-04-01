<style>
    .footer {
        background-color: #f8f9fa;
        padding: 30px 0;
        border-top: 3px solid #28a745;
        margin-top: 20px;
    }

    .footer h5 {
        color: #28a745;
        margin-bottom: 15px;
        font-weight: bold;
    }

    .footer p {
        color: #6c757d;
        font-size: 14px;
    }

    .footer .social-icons a {
        color: #28a745;
        font-size: 24px;
        margin-right: 10px;
        transition: color 0.3s;
    }

    .footer .social-icons a:hover {
        color: #218838;
    }

    .footer .copyright {
        color: #6c757d;
        font-size: 13px;
    }
</style>

<section style="margin-top: 30px; background: #ffffff" class="container ">
    <div class="row">
        <!-- Cột 1: Phần tiêu đề và danh sách liên kết -->
        <div class="col-3 col-md-3">
            <h5 class="btn btn-success">AGRISHOW</h5>
            <ul class="list-unstyled mb-3">
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

        <!-- Cột 2: Ảnh lớn với nội dung nổi bật -->
        <div class="col-3 col-md-3">
            <figure class="mb-3">
                <img class="image-product-content-1 img-fluid"
                    src="{{ asset('component/imgage-product/mi-tron-cay.png') }}" alt="Táo Fuji Nam Phi">
                <figcaption>Táo Fuji Nam Phi có giòn không? Mọi điều bạn cần biết về loại táo này!</figcaption>
            </figure>
        </div>

        <!-- Cột 3: Ảnh với các chủ đề liên quan -->
        <div class="col-3 col-md-3">
            <figure class="mb-3">
                <img class="image-product-content-1 img-fluid"
                    src="{{ asset('component/imgage-product/mi-tron-cay.png') }}" alt="Cam Sành">
                <figcaption>Một quả cam sành bao nhiêu calo?</figcaption>
            </figure>

            <figure class="mb-3">
                <img class="image-product-content-1 img-fluid"
                    src="{{ asset('component/imgage-product/mi-tron-cay.png') }}" alt="Mít Thái">
                <figcaption>Một quả mít Thái bao nhiêu kg?</figcaption>
            </figure>
        </div>

        <!-- Cột 4: Danh sách ảnh nhỏ các chủ đề khác -->
        <div class="col-3 col-md-3">
            <div class="d-flex flex-wrap">
                <img class="image-product-content-1 img-fluid w-50"
                    src="{{ asset('component/imgage-product/mi-tron-cay.png') }}" alt="Nước mắm"><br>
                <img class="image-product-content-1 img-fluid w-50"
                    src="{{ asset('component/imgage-product/mi-tron-cay.png') }}" alt="Nước mắm me"><br>
                <img class="image-product-content-1 img-fluid w-50"
                    src="{{ asset('component/imgage-product/mi-tron-cay.png') }}" alt="Gỏi nước mắm"><br>
                <img class="image-product-content-1 img-fluid w-50"
                    src="{{ asset('component/imgage-product/mi-tron-cay.png') }}" alt="1 lít nước mắm">
            </div>
        </div>
    </div>
</section>


<!--  -->
<footer class="footer container">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Về chúng tôi</h5>
                <p>Foodmap là nền tảng kết nối nông dân, nhà sản xuất thực phẩm với người tiêu dùng thông qua các sản
                    phẩm chất lượng và an toàn.</p>
            </div>

            <div class="col-md-4">
                <h5>Liên hệ</h5>
                <p>Email: contact@foodmap.vn</p>
                <p>Điện thoại: 0123 456 789</p>
                <p>Địa chỉ: 123 Đường ABC, TP.HCM</p>
            </div>

            <div class="col-md-4">
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
    </div>
</footer>
