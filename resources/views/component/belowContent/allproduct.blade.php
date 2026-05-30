<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất cả sản phẩm - FoodDS</title>
    <link rel="stylesheet" href="{{ asset('component/css/foodds.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <header class="fd-header">
        <div class="fd-container">
            <div class="fd-topbar">
                <a href="{{ route('website-main') }}" class="fd-brand">
                    <img src="{{ asset('logo-website/login.png') }}" alt="FoodDS">
                    <div>
                        <strong>FoodDS</strong>
                        <span>Cửa hàng đồ ăn</span>
                    </div>
                </a>

                <div class="fd-search">
                    <form action="{{ route('seach') }}" method="GET">
                        <input type="text" name="query" value="{{ request('query') }}" maxlength="100"
                            placeholder="Tìm kiếm sản phẩm..." required>
                        <button class="fd-btn" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>Tìm</span>
                        </button>
                    </form>
                </div>

                <a href="{{ route('website-main') }}" class="fd-btn fd-btn-outline">Trang chủ</a>
            </div>
        </div>
    </header>

    <main class="fd-container fd-section">
        <div class="fd-section-head">
            <div>
                <p class="fd-eyebrow">Cửa hàng FoodDS</p>
                <h1 class="fd-title">Tất cả sản phẩm</h1>
            </div>
            <div class="fd-chip-row">
                <a href="{{ route('allproduct') }}" class="fd-chip active">Tất cả</a>
                <a href="{{ route('thaplencao') }}" class="fd-chip">Giá thấp đến cao</a>
                <a href="{{ route('caoxuongthap') }}" class="fd-chip">Giá cao đến thấp</a>
                <a href="{{ route('sanphamyeuthich') }}" class="fd-chip">Yêu thích</a>
            </div>
        </div>

        <div class="fd-product-grid">
            @forelse ($products as $product)
                <article class="fd-card" style="{{ $product->quantity_store > 0 ? '' : 'opacity:.55' }}">
                    <a href="{{ route('show_cart', ['product_id' => $product->product_id]) }}">
                        <img src="{{ asset('component/image-product/' . $product->product_image) }}"
                            alt="{{ $product->product_name }}" class="fd-card-img">
                    </a>
                    <div class="fd-card-body">
                        <a class="fd-card-title" href="{{ route('show_cart', ['product_id' => $product->product_id]) }}">
                            {{ $product->product_name }}
                        </a>

                        <div class="fd-price-line">
                            <div>
                                <div class="fd-price">{{ number_format($product->product_price) }}đ</div>
                                <span class="fd-old-price">50,000đ</span>
                                <span class="fd-sale">-20%</span>
                            </div>
                            <form action="{{ route('addspyeuthich') }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                <button type="submit" class="fd-add" style="background:#fff;color:#dc2626;border:1px solid #fecaca"
                                    aria-label="Thêm vào yêu thích">
                                    <i class="fa-heart {{ $product->isFavorited ? 'fa-solid' : 'fa-regular' }}"></i>
                                </button>
                            </form>
                        </div>

                        @if ($product->quantity_store > 0)
                            <form action="{{ route('cart.add') }}" method="POST" style="margin-top:12px">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                <input type="hidden" name="product_price" value="{{ $product->product_price }}">
                                <input type="hidden" name="product_image" value="{{ $product->product_image }}">
                                <input type="hidden" name="quantity_sp" value="1">
                                <button type="submit" class="fd-btn" style="width:100%">
                                    <i class="fa-solid fa-cart-plus"></i>
                                    Thêm vào giỏ
                                </button>
                            </form>
                        @else
                            <div class="fd-btn" style="width:100%;margin-top:12px;background:#0f172a">Hết hàng</div>
                        @endif
                    </div>
                </article>
            @empty
                <div class="fd-panel">Không tìm thấy sản phẩm phù hợp.</div>
            @endforelse
        </div>

        <div style="margin-top:24px">
            {{ $products->links() }}
        </div>
    </main>
</body>

</html>
