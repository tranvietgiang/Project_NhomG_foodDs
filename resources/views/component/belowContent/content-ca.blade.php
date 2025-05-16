<style>
    :root {
        --primary-color: #2ecc71;
        --primary-dark: #27ae60;
        --secondary-color: #f39c12;
        --text-color: #333333;
        --light-gray: #f5f5f5;
        --border-radius: 8px;
        --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }


    .product-section {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 25px;
        margin-top: 20px;
    }

    .section-header {
        margin-bottom: 25px;
    }

    .categories {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 25px;
    }

    .category-btn {
        padding: 10px 16px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        text-align: center;
    }

    .category-main {
        background-color: var(--primary-color);
        color: white;
        font-size: 16px;
    }

    .category-sub {
        background-color: white;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }

    .category-sub:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .products-wrapper {
        position: relative;
        padding: 10px 0;
    }

    .products-container {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        scroll-behavior: smooth;
        scrollbar-width: none;
        -ms-overflow-style: none;
        padding: 10px 5px 20px 5px;
    }

    .products-container::-webkit-scrollbar {
        display: none;
    }

    .product-card {
        flex: 0 0 260px;
        border-radius: var(--border-radius);
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: var(--transition);
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .product-image {
        height: 220px;
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--secondary-color);
        color: white;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 50px;
        font-size: 14px;
    }

    .product-details {
        padding: 16px;
    }

    .product-name {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        line-height: 1.3;
        white-space: normal;
    }

    .product-name a {
        color: var(--text-color);
        text-decoration: none;
        transition: var(--transition);
    }

    .product-name a:hover {
        color: var(--primary-color);
    }

    .price-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
    }

    .price-info {
        display: flex;
        flex-direction: column;
    }

    .current-price {
        font-size: 18px;
        font-weight: bold;
        color: #000;
    }

    .original-price {
        font-size: 14px;
        color: #95a5a6;
        text-decoration: line-through;
        margin-top: 3px;
    }

    .add-cart-btn {
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        font-size: 16px;
    }

    .add-cart-btn:hover {
        background-color: var(--primary-dark);
        transform: scale(1.1);
    }

    .scroll-buttons {
        position: absolute;
        width: 100%;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        display: flex;
        justify-content: space-between;
        padding: 0 10px;
        pointer-events: none;
    }

    .product_name {
        -webkit-line-clamp: 1;
        /* Giới hạn tối đa 2 dòng */
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-size: 19px;
        /* Ẩn nội dung dư thừa */
        max-width: 200px;
        color: #000;
    }

    .scroll-btn {
        background-color: white;
        color: var(--primary-color);
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
        pointer-events: auto;
    }

    .scroll-btn:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .section-title {
        position: relative;
        font-size: 24px;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 25px;
        padding-bottom: 15px;
        display: inline-block;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60%;
        height: 4px;
        background-color: var(--primary-color);
        border-radius: 2px;
    }

    @media (max-width: 768px) {
        .category-main {
            width: 100%;
        }

        .products-container {
            gap: 15px;
        }

        .product-card {
            flex: 0 0 calc(50% - 10px);
        }
    }

    @media (max-width: 480px) {
        .product-card {
            flex: 0 0 calc(100% - 10px);
        }

        .categories {
            flex-direction: column;
        }
    }
</style>
</head>

<body>
    <div class="container">
        <div class="product-section">
            <div class="section-header">
                <h2 class="section-title">THỨC UỐNG ĐẶC SẢN</h2>
                <div class="categories">
                    <a href="#" class="category-btn category-main">THỨC UỐNG ĐẶC SẢN</a>
                    <a href="#" class="category-btn category-sub">Đặc Sản Trà</a>
                    <a href="#" class="category-btn category-sub">Cà Phê UFO</a>
                    <a href="#" class="category-btn category-sub">Đồ uống có cồn</a>
                </div>
            </div>

            <div class="products-wrapper">
                <div class="products-container" id="productsContainer">
                    @foreach ($products as $product)
                        <div class="product-card">
                            <div class="product-image">
                                <a href="{{ route('show_cart', ['product_id' => $product->product_id]) }}">
                                    <img style="width: 250px;"
                                        src="{{ asset('component/image-product/' . $product->product_image) }}"
                                        alt="">
                                </a>
                                <div class="discount-badge">-20%</div>
                            </div>
                            <div class="product-details">
                                <h3 class="product_name">
                                    {{ $product->product_name }}
                                </h3>
                                <div class="price-container">
                                    <div class="price-info">
                                        <span class="current-price">{{ number_format($product->product_price) }}
                                            đ</span>
                                        <span class="original-price">50,000 đ</span>
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                        <input type="hidden" name="quantity_sp" value="1">
                                        <input type="hidden" name="product_price"
                                            value="{{ $product->product_price }}">
                                        <input type="hidden" name="product_image"
                                            value="{{ $product->product_image }}">
                                        <button type="submit" class="add-cart-btn">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach


                    <div class="scroll-buttons">
                        <button class="scroll-btn" id="scrollLeft">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="scroll-btn" id="scrollRight">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const productsContainer = document.getElementById('productsContainer');
            const scrollLeftBtn = document.getElementById('scrollLeft');
            const scrollRightBtn = document.getElementById('scrollRight');

            // Calculate scroll amount based on product card width + gap
            const scrollAmount = 280;

            scrollLeftBtn.addEventListener('click', () => {
                productsContainer.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            });

            scrollRightBtn.addEventListener('click', () => {
                productsContainer.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });
        </script>
</body>

</html>
