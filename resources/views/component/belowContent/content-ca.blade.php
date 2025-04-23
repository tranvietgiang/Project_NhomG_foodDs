<style>
    .noidung1 {
        background: #ffffff;
        margin-top: 10px;
        padding: 10px;
    }


    .product {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        scroll-behavior: smooth;
        white-space: nowrap;
        position: relative;
        padding-bottom: 10px;
    }

    .owl-item {
        flex: 0 0 18%;
        border: 1px solid #9e9e9e;
        padding-bottom: 15px;
        box-sizing: border-box;
        text-align: center;
        margin: 0px 8px;
    }

    .owl-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .name-product {
        margin: 10px 0;
        font-size: 18px;
    }

    .name-product a {
        color: #333;
        text-decoration: none;
    }

    .price {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 10px;
    }

    .giatien strong {
        color: #e00;
        font-size: 18px;
    }

    .giatien p {
        margin: 5px 0 0 0;
        padding: 0;
        font-size: 12px;
        color: #9e9e9e;
    }

    .add-to-cart a {
        text-decoration: none;
        padding: 8px 15px;
        background-color: green;
        color: white;
        border-radius: 5px;
        font-size: 14px;
    }

    .add-to-cart a:hover {
        background-color: #0056b3;
    }

    .phandau {
        margin: 10px;
    }



    .product {
        position: relative;
    }

    .below-nut {
        position: absolute;
        display: flex;
        align-content: center;
        align-items: center;
        gap: 1240px;
        margin-top: -200px;
    }



    .btn_right,
    .btn_left {
        display: flex;
        align-content: center;
        align-items: center;
        background: #9e9e9e;
        width: 30px;
        height: 30px;
        color: #333;
    }
</style>
</head>

<div class="container">
    <div class="noidung1">
        <div class="content">

            <!-- các loại -->
            <div class="phandau">
                <div style="display: flex; gap:20px;" class="entry">
                    <a class="btn btn-success display-6" href="#">THỨC UỐNG ĐẶC SẢN</a>
                    <a class="btn btn-outline-success btn-mini" href="#"> Đặc Sản Trà</a>
                    <a class="btn btn-outline-success btn-mini" href="#">Cà Phê UFO</a>
                    <a class="btn btn-outline-success btn-mini" href="#">Đồ uống có cồn</a>
                </div>
            </div>



            <!-- hiển thị sản phẩm-->
            <div class="product" id="productContainer">
                <!-- Sản phẩm -->
                @foreach($products as $product)
                    <div class="owl-item">
                        <div class="item">
                            <a href="#"><img src="{{ asset('images/'. $product->product_image) }}"
                                    alt="Sản phẩm 2"></a>
                            <div class="divtext">
                                <h3 class="name-product"><a href="#">{{$product->product_name}}</a></h3>
                                <div class="price">
                                    <div class="giatien">
                                        <strong>{{$product->product_price}} đ</strong>
                                        <p><span style="text-decoration: line-through;">50,000 ₫</span><span
                                                style="color: #e00;">-20%</span></p>
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    <input type="hidden" name="quantity_sp" value="1"> <!-- Thêm trường quantity_sp nếu cần -->
                    <button type="submit" class="btn btn-outline-success btn-sm" style="display: inline;">Add</button>
                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- nut di chuyen -->
            <div class="below-nut">
                <div class="btn_left" onclick="scrollLeftFunc()">a</div>
                <div class="btn_right" onclick="scrollRightFunc()">b</div>
            </div>

        </div>
    </div>
</div>

<script>
    const container = document.getElementById('productContainer');
    const itemWidth = 220; // Chiều rộng mỗi sản phẩm (bao gồm khoảng cách)

    function scrollLeftFunc() {
        container.scrollBy({
            top: 0,
            left: -itemWidth,
            behavior: 'smooth'
        });
    }

    function scrollRightFunc() {
        container.scrollBy({
            top: 0,
            left: itemWidth,
            behavior: 'smooth'
        });
    }
</script>
