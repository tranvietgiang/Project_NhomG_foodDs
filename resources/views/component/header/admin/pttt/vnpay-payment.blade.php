<section>
    <div>
        <div>
            <img src="https://pay.vnpay.vn/images/brands/logo-en.svg" alt="">
            <h1>Sản phẩm 1</h1>
        </div>
        <form action="{{ route('vnpay.payment') }}" method="post">
            <input type="text" placeholder="Vui lòng nhập tên sản phẩm" name="name"><br>
            <input type="text" placeholder="Vui lòng nhập giá tiền" name="price">
            @csrf
            <div class="buttons">
                <button type="submit" class="btn btn-outline-primary">Thanh Toán</button><br>
            </div>
        </form>
    </div>
</section>
