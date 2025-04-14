<link rel="stylesheet" href="{{ asset('component/css/bootstrap.min.css') }}">
<!-- Google Fonts -->
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;600&display=swap">

<style>
    /* chỉnh quality */
    .quantity-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
    }

    input.input-qty[type="number"]::-webkit-inner-spin-button,
    input.input-qty[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .input-qty {
        width: 60px;
        text-align: center;
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 5px;
        background-color: #fff;
    }

    .btn.minus,
    .btn.plus {
        width: 35px;
        height: 35px;
        font-size: 18px;
        line-height: 1;
        padding: 0;
    }
</style>
<div>
    <a href="{{ url()->previous() }}">Quay lại</a>
</div>
<h1>Product Details</h1>
@foreach ($cart as $item)
    <div class="frame-image">
        <span>{{ $item->product_id }}</span>
        <div>
            <img width="200" height="200" class=""
                src="{{ asset('component/image-product/' . $item->product_image) }}" alt="">
        </div>
        <h5 class="product_name"><b>
                {{ $item->product_name }}
            </b></h5>
        <span class="text-warning product_star">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <span style="display: inline; color: #000">(0)</span>
        </span>

        <span style="font-size:14px " class="text-success">đã bán 103</span>
        <span class="new-price"><b> {{ $item->product_price }}</b><sub>đ</sub></span><br>



        <div class="d-flex  gap-5">

            <span class="">
                <!-- khi mà client bấm mua ngay thì sản phẩm sẽ được add vào giỏ hàng của ng đó -->
                <form action="{{ url('/cart/show_checkout', ['product_id' => $item->product_id]) }}" method="get">
                    @csrf
                    <!-- chỉnh quality -->
                    <div class="mb-3">
                        <label class="form-label">Số lượng:</label>
                        <div class="quantity-container ">
                            <div class="btn btn-outline-danger minus d-flex align-items-center justify-content-center">−
                            </div>
                            <input name="cart_quantity" type="number" value="1" min="1" class="input-qty">
                            <div class="btn btn-outline-success plus d-flex align-items-center justify-content-center">+
                            </div>
                        </div><br>
                        <p>
                            <button class="btn btn-outline-success btn-sm" type="submit">Mua ngay</button>
                        </p>
                    </div>
                </form>

                <!-- cart -->
                <a class="btn btn-outline-success" href="#">Cart</a>
                <!-- thêm vào danh sách yêu thích -->
                <a class="btn btn-outline-danger" href="#">Heart</a>
            </span>
        </div>
    </div>
@endforeach


<script>
    const minus = document.querySelector(".minus");
    const plus = document.querySelector(".plus");
    const input_qty = document.querySelector(".input-qty");

    minus.addEventListener("click", () => {
        let quality = parseInt(input_qty.value);
        if (quality > 1) {
            input_qty.value = quality - 1;
        }
    });

    plus.addEventListener("click", () => {
        let quality = parseInt(input_qty.value);
        input_qty.value = quality + 1;

    });
</script>
<!-- form review của giang -->
@include('component.header.admin.keThua.review-form')
