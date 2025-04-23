<!-- show_bill_product -->
<section>
    <div>
        @foreach ($show_bill as $item)
            <div>
                <p><img src="{{ asset('component/image-product/' . $item->product_image) }}" width="200"
                        class="object-fit-cover" height="200"></p>
                <p>name: {{ $item->product_name }}</p>
                <p>Gia: {{ $item->product_price }}</p>
                <p>Số lượng: {{ $item->quantity_sp }}</p>
            </div>
            @php
                $total_price = $item->TOTAL_PRICE;
            @endphp
        @endforeach
        <div>
            <p>Tổng tiền: {{ $total_price }}</p>
            <p><strong>cảm ơn bạn đã tin tưởng mua hàng của chúng tôi!</strong></p>
            <a href="{{ route('website-main') }}">Home</a>
        </div>
    </div>
</section>
<section>
    @if (session('order-success'))
        <div class="alert alert-success text-center">
            {{ session('order-success') }}
        </div>
    @endif
</section>
