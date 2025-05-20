<h2>Thông tin sản phẩm</h2>
<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
<section class="container">
    <a href="{{ route('statistics.view') }}">quay ve</a>
    @if ($mode == 'OutOfStore')
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
    @elseif ($mode == 'sale_products')
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>STT</td>
                    <th>Image</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity_store</th>
                    <th>Price</th>
                    <th>Product sale</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale_products as $product)
                    <tr>
                        <td>{{ $loop->iteration + $sale_products->firstItem() - 1 }}</td>
                        <td>{{ $product->product_id }}</td>
                        <td><img class="object-fit-cover" width="300" height="300"
                                src="{{ asset('component/image-product/' . $product->product_image) }}" alt="">
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->quantity_store }}</td>
                        <td> {{ number_format($product->product_price) }}</td>
                        <td>{{ number_format($product->total_sale) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif ($mode == 'potential_customers')
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>STT</td>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>address</th>
                    <th>client_gender</th>
                    <th>dat_of_birth</th>
                    <th>login_count</th>
                    <th>created_at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($potential_customers as $client)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $client->client_id }}</td>
                        <td><img class="object-fit-cover" width="300" height="300"
                                src="{{ asset('image-store/' . $client->client_avatar) }}" alt="">
                        </td>
                        <td>{{ $client->client_name }}</td>
                        <td>{{ $client->client_phone }}</td>
                        <td> {{ $client->client_address }}</td>
                        <td>{{ $client->client_gender }}</td>
                        <td>{{ $client->dat_of_birth }}</td>
                        <td>{{ $client->login_count }}</td>
                        <td>{{ $client->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif ($mode == 'reviewGoods')
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>STT</td>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviewGoods as $client)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $client->product_id }}</td>
                        <td><img width="300" height="300"
                                src="{{ asset('component/image-product/' . $client->product_image) }}" alt="">
                        </td>
                        <td>{{ $client->product_name }}</td>
                        <td>{{ round($client->average_rating) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</section>
