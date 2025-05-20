<h2>Thông tin sản phẩm</h2>
<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
<section class="container">
    <a href="{{ route('statistics.view') }}">quay ve</a>
    @if ($OutOfStore)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>STT</td>
                    <th>Image</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity_store</th>
                    <th>Tháo tác</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($OutOfStore as $product)
                    <tr>
                        <td>{{ $loop->iteration + $OutOfStore->firstItem() - 1 }}</td>
                        <td>{{ $product->product_id }}</td>
                        <td><img class="object-fit-cover" width="300" height="300"
                                src="{{ asset('component/image-product/' . $product->product_image) }}" alt="">
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->quantity_store }}</td>
                        <td><button>+</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</section>
