<!-- code review cart->bills->bill_products ở controller PTTTController -->
<!-- Link fontawesome  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    .review-container {
        background-color: white;
        padding: 15px;
        /* Giảm padding */
        border-radius: 6px;
        /* Giảm border-radius */
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 650px;
        /* Giảm chiều rộng tối đa */
    }

    h2 {
        font-size: 16px;
        /* Giảm font-size */
        margin-bottom: 15px;
        /* Giảm margin */
    }

    .rating-section {
        display: flex;
        justify-content: space-between;
        gap: 30%;
        margin-bottom: 15px;
        /* Giảm margin */
    }

    .average-rating {
        text-align: center;
        white-space: nowrap;
    }

    .rating-score {
        font-size: 24px;
        /* Giảm font-size */
        color: #ff6200;
        font-weight: bold;
    }

    .stars {
        color: #ff6200;
        font-size: 16px;
        /* Giảm font-size */
    }

    .rating-details {
        flex-grow: 1;
        margin-left: 15px;
        /* Giảm margin */
    }

    .rating-bar {
        display: flex;
        align-items: center;
        /* margin-bottom: 3px; */
        width: 300px;
        /* Giảm margin */
    }

    .rating-bar span {
        width: fit-content;
        /* Giảm chiều rộng */
        font-size: 12px;
        /* Giảm font-size */
    }

    .bar {
        flex-grow: 1;
        height: 6px;
        /* Giảm chiều cao */
        background-color: #e0e0e0;
        border-radius: 3px;
        /* Giảm border-radius */
        margin: 0 8px;
        /* Giảm margin */
    }

    .filled {
        height: 100%;
        background-color: #ff6200;
        border-radius: 3px;
        /* Giảm border-radius */
    }

    .user-review {
        display: flex;
        gap: 55%;
        justify-content: space-around;
    }


    .star-rating {
        display: flex;
        direction: rtl;
        margin-bottom: 15px;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        font-size: 18px;
        color: #e0e0e0;
        cursor: pointer;
    }

    .star-rating input:checked~label,
    .star-rating label:hover,
    .star-rating label:hover~label {
        color: gold;
    }

    textarea {
        width: 100%;
        height: 80px;
        /* Giảm chiều cao */
        padding: 8px;
        /* Giảm padding */
        border: 1px solid #e0e0e0;
        border-radius: 3px;
        /* Giảm border-radius */
        resize: none;
        margin-bottom: 15px;
        /* Giảm margin */
        font-size: 12px;
        /* Giảm font-size */
    }

    .submit-btn {
        width: 100%;
        padding: 8px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 3px;
        font-size: 14px;
        cursor: pointer;
    }

    .submit-btn:hover {
        background-color: #218838;
    }

    .view-images {
        display: block;
        text-align: center;
        color: #007bff;
        text-decoration: none;
        font-size: 12px;
    }

    .view-images:hover {
        text-decoration: underline;
    }

    .comment-box {
        border: 1px solid #ccc;
        padding: 10px;
        width: 100%;
        max-height: 300px;
        overflow-y: auto;
        background-color: #f9f9f9;
        border-radius: 5px;
    }

    .comment-box p {
        margin-bottom: 10px;
        font-size: 14px;
    }

    .star-color {
        color: gold;
    }



    /* Overlay nền mờ */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 1000;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
    }

    /* Ảnh phóng to */
    .lightbox img {
        max-width: 90%;
        max-height: 90%;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
    }

    /* Nút đóng */
    .lightbox::after {
        content: "✖";
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 32px;
        cursor: pointer;
    }
</style>
<div class="review-container">
    @if (session('client-not-buy'))
        <div class="alert alert-warning text-center">{{ session('client-not-buy') }}</div>
    @endif
    <h2>Đánh giá sản phẩm</h2>
    <div class="rating-section">
        <div class="average-rating">
            <span class="rating-score">5.0</span>
            <span class="stars">★★★★★</span>
        </div>

        <!-- hiện lượt đánh giá -->
        <div class="rating-details">

            <div class="rating-bar"><span>5 ★</span>
                <div class="bar">
                    <div class="filled" style="width: 100%;"></div>
                </div><span>
                    <!-- vì sao lại để index là 5 mà laravel vẫn hiểu raring == 5
                    là gì tôi đã dùng cái pluck(): để tại một mảng chứa [key => valued]
                    nếu tôi bình luận  5 thì tôi sẽ có index(key) là 5 và tôi chỉ cần index(50
                     thi là sẽ hiện ra value của index(5) -->
                    {{ $client_review_category[5] ?? '0' }}
                    đánh giá
                </span>
            </div>

            <div class="rating-bar"><span>4 ★</span>
                <div class="bar">
                    <div class="filled" style="width: 80%;"></div>
                </div><span>{{ $client_review_category[4] ?? '0' }} đánh giá</span>
            </div>
            <div class="rating-bar"><span>3 ★</span>
                <div class="bar">
                    <div class="filled" style="width: 60%;"></div>
                </div><span> {{ $client_review_category[3] ?? '0' }} đánh giá</span>
            </div>
            <div class="rating-bar"><span>2 ★</span>
                <div class="bar">
                    <div class="filled" style="width: 40%;"></div>
                </div><span> {{ $client_review_category[2] ?? '0' }} đánh giá</span>
            </div>
            <div class="rating-bar"><span>1 ★</span>
                <div class="bar">
                    <div class="filled" style="width: 20%;"></div>
                </div><span> {{ $client_review_category[1] ?? '0' }} đánh giá</span>
            </div>
        </div>
    </div>

    <!-- form create review git add commit -->
    <form id="review-form" action="{{ url('/client/review/cart/bought') }}" method="post"
        enctype="multipart/form-data">
        <input type="text" name="product_id" value="{{ $product_id = $cart->first()->product_id }}">

        @csrf
        <div class="user-review">
            <label>Chọn đánh giá của bạn</label>
            <div class="star-rating">
                <input type="radio" name="client_rating" id="star5" value="5"><label for="star5">★</label>
                <input type="radio" name="client_rating" id="star4" value="4"><label for="star4">★</label>
                <input type="radio" name="client_rating" id="star3" value="3"><label for="star3">★</label>
                <input type="radio" name="client_rating" id="star2" value="2"><label for="star2">★</label>
                <input type="radio" name="client_rating" id="star1" value="1"><label for="star1">★</label>
            </div>
        </div>
        <div>
            <textarea name="review_content" id="client-comment" class="form-control" rows="4"
                placeholder="Nhập đánh giá về sản phẩm (tối thiểu 10 ký tự)"></textarea>
            <button type="submit" class="submit-btn">GỬI ĐÁNH GIÁ</button>
            <span class="text-danger fw-bold" id="errorMessage"></span>
        </div>
        <div>
            <input onchange="show_imageAttached()" class="d-none" name="image_attached" id="image-review"
                type="file">
            <label for="image-review">Đích kèm <i class="fa-solid fa-image"></i></label>
            <div id="show_image_attached"></div>
            <!-- phần click vào to ảnh -->
            <div class="lightbox" id="lightbox" onclick="hideLightbox()">
                <img class="lightbox-img" />
            </div>
        </div>
    </form>

    <!-- show comment -->
    <span class="">Đánh giá của khách hàng ({{ $review_count_rating }})</span><br>
    <span><b>{{ $final_rating_tbc }}</b>/5 <span class="star-color">★★★★★</span></span>
    <div id="show_comment_client" class="comment-box">
        <div id="show_comment_client" class="comment-box">
            @foreach ($list_review as $comment)
                <p style="padding: 0; margin: 0;">
                    <span>{{ $comment->format_date() }}</span>
                    <span class="star-color" style="font-size: 17px" class="review_rating">
                        @switch($comment->review_rating)
                            @case(5)
                                ★★★★★
                            @break

                            @case(4)
                                ★★★★
                            @break

                            @case(3)
                                ★★★
                            @break

                            @case(2)
                                ★★
                            @break

                            @case(1)
                                ★
                            @break

                            @default
                        @endswitch
                    </span>
                </p>
                <!-- mỗi comment -->
                <p>
                    <strong>{{ $comment->users->name }}:</strong> {{ $comment->review_comment }}

                    <!-- click để sửa comment -->
                    @if ($comment->user_id == Auth::id())
                        <span id="" style="cursor: pointer" class="btn-sm fw-bold edit_span"><i
                                class="fa-solid fa-pencil icon_hidden"></i></span>
                    @endif

                <div style="margin: 0; padding: 0;"><img width="70px" height="70px" class=" object-fit-cover"
                        src="{{ asset('image-store/' . $client_Avatar ?? 'avatar_default.png') }}" alt="ảnh comment">
                </div>


                <br>
                <span class="">
                    <!-- để lấy để cho mỗi lần mình click mỗi comment để chỉnh sửa thì nó sẽ có những cái id khác,
                         để cái hiện lỗi sẽ không bị trùng id nhau tại vì trùng id sẽ gây ra lỗi và form sẽ không hoạt động
                         "form_edit_review" -->
                    <!-- là cú pháp Blade Template của Laravel dùng để viết một đoạn PHP thuần bên trong file -->
                    @php
                        $inputId = 'icon_submit_' . $comment->review_id;
                    @endphp

                    <label for="">ảnh đính kèm</label>
                    <!-- cần handle click image to ra -->
                    <p>
                        <img style="border: 1px solid red;" class="object-fit-cover checkSrc  lightbox-img"
                            src="{{ asset('image-store/' . $comment->review_image ?? 'notImage') }}" alt="">
                    </p>
                    <!-- kiểm tra chỉ người nào mua hàng mới thấy nút sửa or xóa -->
                    @if ($comment->user_id == Auth::id())
                        <!-- form chỉnh sửa comment -->
                        <form class="form_edit_review"
                            action="{{ route('client.comment.update', $comment->review_id) }}" method="GET">
                            @csrf

                            <!-- input edit -->
                            <p style="margin: 0; padding: 0;">
                                <input class="form-control mb-3 input_review-comment" style="display: none"
                                    name="edit_comment_input" placeholder="Nhập chỉnh sủa comment của bạn... "
                                    type="text">
                            </p>

                            <!-- CHUYỂN THẺ SPAN này VÀO TRONG FORM -->
                            <span class="text-danger fw-bold errorMessage-edit"></span>


                            <!-- button edit -->
                            <div>
                                <input class="d-none" id="{{ $inputId }}" type="submit">
                                <label class="btn-sm btn btn-outline-warning icon_hidden_label"
                                    for="{{ $inputId }}">
                                    <i class="fa-solid fa-pencil icon_hidden"></i></label>
                            </div>

                        </form>
                        <!-- delete -->
                        <a class="btn-sm btn btn-outline-danger"
                            href="{{ route('client.comment.delete', $comment->review_id) }}"><i
                                class="fa-solid fa-eraser"></i></a>
                    @endif
                </span>
                </p>
            @endforeach
        </div>
    </div>
</div>
<script>
    document.querySelector('#review-form').addEventListener("submit", (e) => {
        const count_word = document.querySelector("#client-comment");
        const selectedRating = document.querySelector('input[name="client_rating"]:checked');
        let errorMessage = document.querySelector("#errorMessage");
        let errorMessages = [];
        const inputValue = count_word.value.trim();


        if (inputValue.length < 11) {
            errorMessages.push('ký tự phải lớn hơn 10!, ');
        }

        if (!selectedRating) {
            errorMessages.push('Bạn chưa chọn sao!');
        }


        if (errorMessages.length > 0) {
            e.preventDefault();
            errorMessage.textContent = errorMessages.join("");
        } else {
            errorMessage.textContent = "";
            errorMessage.textContent = "";
        }


    });

    // phần code chỉnh sửa comment của client

    const editSpans = document.querySelectorAll('.edit_span');
    const inputReviews = document.querySelectorAll('.input_review-comment');
    const iconHiddenLabels = document.querySelectorAll('.icon_hidden_label');
    const icon_hidden = document.querySelectorAll('.icon_hidden');

    /*nếu bạn không dùng e.stopPropagation(); khi bạn click vào nút sửa comment thì
      thằng cha của thẻ bạn click sẽ bị ảnh sử click của bạn luôn */
    editSpans.forEach(span => {
        span.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    });

    // ẩn đi cái input edit comment nếu như client không click đúng chữ chỉnh 'sửa comment'
    document.addEventListener('click', (e) => {
        inputReviews.forEach((input, index) => {
            const span = editSpans[index];
            if (
                !input.contains(e.target) &&
                !span.contains(e.target)
            ) {
                input.style.display = "none";
            }
        });
    });

    // Hiển thị input khi click vào edit_span
    editSpans.forEach((span, index) => {
        span.addEventListener('click', () => {
            const input = inputReviews[index]; // Đảm bảo input tương ứng với span
            input.style.display = "block";
            input.focus();
        });
    });

    // kiểm tra xem client chỉnh sủa commnet có đủ 10 ký tự không.
    const forms_edit_review = document.querySelectorAll('.form_edit_review');

    forms_edit_review.forEach(form => {
        const input_review = form.querySelector('.input_review-comment');
        const errorMessage_edit = form.querySelector('.errorMessage-edit');

        form.addEventListener('submit', (e) => {
            let length_edit_review = input_review.value.trim().length;
            if (length_edit_review < 11) {
                e.preventDefault();
                errorMessage_edit.textContent = "Ký tự phải lớn hơn 10!";
            } else {
                errorMessage_edit.textContent = "";
            }
        });
    });

    // ảnh đính kèm review
    function show_imageAttached() {

        const image_review = document.getElementById('image-review').files;

        if (image_review.length > 0) {
            const readImage = new FileReader()

            readImage.onload = (e) => {
                const src = e.target.result;
                document.getElementById('show_image_attached').innerHTML =
                    `<img src="${src}" with='200' height='200' onclick="showLightbox(this.src)" class='object-fit-cover' alt="">`;

                sendImageToServer(src);
            };
            readImage.readAsDataURL(image_review[0])
        }
    }

    // bấm vào ảnh xem cho rõ
    function showLightbox(src) {
        document.querySelector('.lightbox-img').src = src;
        document.querySelector('.lightbox').style.display = "flex";
    }

    function hideLightbox() {
        document.querySelector('.lightbox').style.display = "none";
    }




    document.querySelectorAll(".checkSrc").forEach(img => {
        img.onload = function() {
            // Nếu ảnh load được, thì set css
            Object.assign(img.style, {
                width: '150px',
                height: '150px',
                objectFit: 'cover',
                display: 'block'
            });
        };

        img.onerror = function() {
            img.style.display = 'none';
        };
    });
</script>
