<section class="fd-header">
    <div class="fd-container">
        <div class="fd-topbar">
            <a href="{{ route('website-main') }}" class="fd-brand">
                <img src="{{ asset('logo-website/login.png') }}" alt="FoodDS">
                <div>
                    <strong>FoodDS</strong>
                    <span>Đồ ăn & thức uống</span>
                </div>
            </a>

            <div class="fd-search">
                <form id="form-search" action="{{ route('seach') }}" method="get">
                    <input type="text" id="key-word" name="query" required maxlength="100"
                        placeholder="Tìm món ngon, thức uống, đặc sản...">
                    <button class="fd-btn" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Tìm kiếm</span>
                    </button>
                </form>
                <div id="search-suggestions" class="fd-suggestions" style="display:none"></div>
            </div>

            <div class="fd-actions">
                <a href="{{ url('/information-client') }}" class="fd-btn fd-btn-outline">
                    <i class="fa-regular fa-user"></i>
                    @if (!Auth::check())
                        Đăng nhập
                    @else
                        {{ Auth::user()->name }}
                    @endif
                </a>

                @if (!Auth::check())
                    <a href="{{ route('wayLogin', ['page' => 'register']) }}" class="fd-btn fd-btn-outline">
                        Đăng ký
                    </a>
                @endif

                <a class="fd-icon-btn" href="{{ route('cart.shows_goods') }}" aria-label="Giỏ hàng">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span id="cartCount" class="fd-badge">{{ $amount_cart_header ?? 0 }}</span>
                </a>
            </div>
        </div>

        <nav class="fd-nav">
            <a class="active" href="{{ route('website-main') }}">Trang chủ</a>
            <a href="{{ route('allproduct') }}">Tất cả sản phẩm</a>
            <a href="#">Đồ ăn nhanh</a>
            <a href="#">Trà sữa</a>
            <a href="#">Trái cây</a>
            <a href="#">Đặc sản Việt</a>
        </nav>

        <div class="fd-hero-grid">
            <div class="fd-hero">
                <img src="{{ asset('component/header/img/img-animation-1.jpg') }}" alt="Ưu đãi FoodDS">
                <div class="fd-hero-content">
                    <div class="fd-eyebrow">Giao nhanh trong ngày</div>
                    <h1>Món ngon mỗi ngày, chọn là có ngay</h1>
                    <p>Từ trà sữa, cà phê, mì trộn đến đặc sản Việt, FoodDS gom mọi lựa chọn vào một trải nghiệm mua sắm gọn và dễ dùng.</p>
                    <div>
                        <a href="{{ route('allproduct') }}" class="fd-btn">Mua ngay</a>
                        <a href="#home" class="fd-btn fd-btn-outline">Sản phẩm mới</a>
                    </div>
                </div>
            </div>

            <div class="fd-side-promos">
                <a href="{{ route('allproduct') }}" class="fd-mini-promo">
                    <img src="{{ asset('component/header/img/img-animation-2.jpg') }}" alt="Đồ uống nổi bật">
                    <div>
                        <strong>Đồ uống mát lành</strong>
                        <p class="fd-muted">Trà, cà phê, trái cây</p>
                    </div>
                </a>
                <a href="{{ route('allproduct') }}" class="fd-mini-promo">
                    <img src="{{ asset('component/header/img/img-animation-6.jpg') }}" alt="Đặc sản Việt">
                    <div>
                        <strong>Đặc sản Việt</strong>
                        <p class="fd-muted">Quà ngon cho mọi nhà</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div style="position: fixed; right: 20px; bottom: 20px; z-index: 40;">
        <a href="https://zalo.me/0336833827" target="_blank"
            style="width:56px;height:56px;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;box-shadow:var(--fd-shadow)">
            <img style="width:36px;height:36px;object-fit:contain" src="{{ asset('image-store/zalo.png') }}" alt="Zalo">
        </a>
    </div>
</section>

@include('component.header.chatbox.message')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $("#key-word").on("input", function() {
        let search = $(this).val().trim().toLowerCase();

        if (search.length === 0) {
            $("#search-suggestions").hide();
            return;
        }

        $.ajax({
            url: "{{ route('header.show.render') }}",
            type: "GET",
            data: {
                valueSearch: search,
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                const products = response.data || [];

                if (products.length === 0) {
                    $("#search-suggestions").html('<div style="padding:14px;color:#64748b">Không tìm thấy sản phẩm phù hợp.</div>').show();
                    return;
                }

                const showCartBaseUrl = "{{ route('show_cart', ['product_id' => '__ID__']) }}";
                let html = '<div style="padding:10px"><strong>Gợi ý sản phẩm</strong>';

                products.forEach((item) => {
                    const url = showCartBaseUrl.replace('__ID__', item.product_id);
                    let price = Number(item.product_price).toLocaleString('vi-VN') + ' đ';
                    html += `
                        <a href="${url}" class="fd-suggestion-item">
                            <img src="/component/image-product/${item.product_image}" alt="${item.product_name}">
                            <div>
                                <strong>${item.product_name}</strong>
                                <div style="color:#dc2626;font-weight:800">${price}</div>
                            </div>
                        </a>`;
                });

                html += '</div>';
                $("#search-suggestions").html(html).show();
            }
        });
    });
</script>
