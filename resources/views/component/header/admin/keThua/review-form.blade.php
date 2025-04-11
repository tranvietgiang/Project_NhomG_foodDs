<style>
    .review-container {
        background-color: white;
        padding: 15px;
        /* Giảm padding */
        border-radius: 6px;
        /* Giảm border-radius */
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px;
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
        margin-bottom: 15px;
        /* Giảm margin */
    }

    .average-rating {
        text-align: center;
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
        <div class="rating-details">
            <div class="rating-bar"><span>5 ★</span>
                <div class="bar">
                    <div class="filled" style="width: 100%;"></div>
                </div><span>0 đánh giá</span>
            </div>
            <div class="rating-bar"><span>4 ★</span>
                <div class="bar">
                    <div class="filled" style="width: 0%;"></div>
                </div><span>0 đánh giá</span>
            </div>
            <div class="rating-bar"><span>3 ★</span>
                <div class="bar">
                    <div class="filled" style="width: 0%;"></div>
                </div><span>0 đánh giá</span>
            </div>
            <div class="rating-bar"><span>2 ★</span>
                <div class="bar">
                    <div class="filled" style="width: 0%;"></div>
                </div><span>0 đánh giá</span>
            </div>
            <div class="rating-bar"><span>1 ★</span>
                <div class="bar">
                    <div class="filled" style="width: 0%;"></div>
                </div><span>0 đánh giá</span>
            </div>
        </div>
    </div>
    <form id="review-form" action="{{ url('/review/cart') }}" method="get">
        <input type="text" name="product_id" value="{{ $product_id = $cart->first()->product_id }}">

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
            <button class="submit-btn">GỬI ĐÁNH GIÁ</button>
            <span class="text-danger fw-bold" id="errorMessage"></span>
        </div>
        <div>
            <input id="image-review" hidden type="file">
            <label for="image-review">Đính kèm hình ảnh</label>
        </div>
    </form>
    <style>
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
    </style>
    <!-- show comment -->
    <span class="">Những đánh giá</span>
    <div id="show_comment_client" class="comment-box">
        <div id="show_comment_client" class="comment-box">
            @foreach ($list_review as $comment)
                <span>{{ $comment->format_date() }}</span>
                <p><strong>{{ $comment->users->name }}:</strong> {{ $comment->review_comment }}
                    <br>
                    <span class="d-flex gap-3">
                        <a class="btn-sm btn btn-outline-warning" href="#">Sửa</a>
                        <a class="btn-sm btn btn-outline-danger"
                            href="{{ route('client.comment.delete', $comment->review_id) }}">Xóa</a>
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
            errorMessages.push('ký tự phải lớn hơn 10! \n');
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
</script>
