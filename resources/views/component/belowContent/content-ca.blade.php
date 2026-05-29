<section class="fd-section fd-container">
    <div class="fd-panel">
        <div class="fd-section-head">
            <div>
                <p class="fd-eyebrow">Thức uống đặc sản</p>
                <h2 class="fd-title">Giải khát ngon mỗi ngày</h2>
            </div>
            <div class="fd-chip-row">
                <a href="{{ route('allproduct') }}" class="fd-chip active">Xem tất cả</a>
                <a href="#" class="fd-chip">Trà đặc sản</a>
                <a href="#" class="fd-chip">Cà phê</a>
                <a href="#" class="fd-chip">Trái cây</a>
            </div>
        </div>

        <div class="fd-product-row" id="productsContainer">
            @foreach ($products as $product)
                @php $oldPrice = round($product->product_price / 0.8); @endphp
                <article class="fd-card">
                    <a href="{{ route('show_cart', ['product_id' => $product->product_id]) }}">
                        <img class="fd-card-img" src="{{ asset('component/image-product/' . $product->product_image) }}"
                            alt="{{ $product->product_name }}">
                    </a>
                    <div class="fd-card-body">
                        <span class="fd-sale">-20%</span>
                        <a class="fd-card-title" href="{{ route('show_cart', ['product_id' => $product->product_id]) }}">
                            {{ $product->product_name }}
                        </a>
                        <div class="fd-price-line">
                            <div>
                                <div class="fd-price">{{ number_format($product->product_price) }}đ</div>
                                <div class="fd-old-price">{{ number_format($oldPrice) }}đ</div>
                            </div>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                <input type="hidden" name="quantity_sp" value="1">
                                <input type="hidden" name="product_price" value="{{ $product->product_price }}">
                                <input type="hidden" name="product_image" value="{{ $product->product_image }}">
                                <button type="submit" class="fd-add" aria-label="Thêm vào giỏ hàng">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
