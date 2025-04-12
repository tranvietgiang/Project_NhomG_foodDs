<link rel="stylesheet" href="{{ asset('component/css/bootstrap.min.css') }}">
<!-- Google Fonts -->
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;600&display=swap">

<h1>Product Details</h1>
@foreach ($cart as $item)
    <div class="frame-image">
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
        <span class="new-price"><b> {{ $item->product_price }}</b><sub>đ</sub></span>
        <div class="d-flex  gap-5">
            <div class="d-flex">
                <span class="old-price">1500.0<sub>đ</sub></span>
                <span class="discount">-35%</span>
            </div>
            <span class="btn btn-outline-success "><a class="text-danger" href="">Cart</a></span>
        </div>
    </div>
@endforeach

<!-- form review của giang -->
@include('component.header.admin.keThua.review-form')
