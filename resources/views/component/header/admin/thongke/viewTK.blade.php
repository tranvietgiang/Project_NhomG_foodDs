<h2 class="text-center mt-4 mb-3">Thông tin sản phẩm</h2>
<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">

<section class="container">
    <a href="{{ route('statistics.view') }}" class="btn btn-secondary mb-3">← Quay về</a>

    <div class="table-responsive">
        @if ($mode == 'OutOfStore')
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Quantity Store</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($OutOfStore as $product)
                        <tr>
                            <td>{{ $loop->iteration + $OutOfStore->firstItem() - 1 }}</td>
                            <td><img width="100" height="100"
                                    src="{{ asset('component/image-product/' . $product->product_image) }}"
                                    alt="product" class="img-thumbnail"></td>
                            <td>{{ $product->product_id }}</td>
                            <td>{{ $product->product_name }}
                            </td>
                            <td data-qty-td="{{ $product->product_id }}" class="qty-change">
                                {{ $product->quantity_store }}</td>
                            <td><button data-qty-id="{{ $product->product_id }}"
                                    data-qty-sl="{{ $product->quantity_store }}"
                                    class="btn btn-sm btn-success Qty">+</button></td>
                        </tr>
                    @endforeach
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                    <script>
                        $(function() {
                            $('.Qty').on('click', function() {
                                // 👇 lấy số hiện tại từ <td>
                                let id = $(this).data('qty-id');
                                let qty = parseInt($(`.qty-change[data-qty-td="${id}"]`).text());
                                // console.log(qty)
                                $.ajax({
                                    url: "{{ route('statistics.qty') }}",
                                    type: "post",
                                    data: {
                                        qty_id: id,
                                        qty_sl: qty,
                                        _token: "{{ csrf_token() }}"
                                    },
                                    success: function(response) {
                                        let qty_data = response.data;
                                        $(`.qty-change[data-qty-td="${id}"]`).text(qty_data);
                                        console.log('Cập nhật:', qty_data);
                                    },
                                    error: function() {

                                    }
                                })
                            })
                        })
                    </script>
                </tbody>
            </table>
        @elseif ($mode == 'sale_products')
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Quantity Store</th>
                        <th>Price</th>
                        <th>Product Sale</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale_products as $product)
                        <tr>
                            <td>{{ $loop->iteration + $sale_products->firstItem() - 1 }}</td>
                            <td><img width="100" height="100"
                                    src="{{ asset('component/image-product/' . $product->product_image) }}"
                                    alt="product" class="img-thumbnail"></td>
                            <td>{{ $product->product_id }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->quantity_store }}</td>
                            <td>{{ number_format($product->product_price) }}₫</td>
                            <td>{{ number_format($product->total_sale) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif ($mode == 'potential_customers')
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                        <th>Login Count</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($potential_customers as $client)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $client->client_id }}</td>
                            <td><img width="100" height="100"
                                    src="{{ asset('image-store/' . $client->client_avatar) }}" alt="client"
                                    class="img-thumbnail"></td>
                            <td>{{ $client->client_name }}</td>
                            <td>{{ $client->client_phone }}</td>
                            <td>{{ $client->client_address }}</td>
                            <td>{{ $client->client_gender }}</td>
                            <td>{{ $client->dat_of_birth }}</td>
                            <td>{{ $client->login_count }}</td>
                            <td>{{ $client->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif ($mode == 'reviewGoods')
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reviewGoods as $client)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $client->product_id }}</td>
                            <td><img width="100" height="100"
                                    src="{{ asset('component/image-product/' . $client->product_image) }}"
                                    alt="product" class="img-thumbnail"></td>
                            <td>{{ $client->product_name }}</td>
                            <td>{{ round($client->average_rating) }} ⭐</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif ($mode == 'top_clients')
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($top_clients as $client)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $client->id }}</td>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ number_format($client->total_spent) }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif ($mode == 'sale_not_buy')
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale_not_buy as $client)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img width="100" height="100"
                                    src="{{ asset('component/image-product/' . $client->product_image) }}"
                                    alt="product" class="img-thumbnail"></td>
                            <td>{{ $client->product_id }}</td>
                            <td>{{ $client->product_name }}</td>
                            <td>{{ $client->product_price }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>
