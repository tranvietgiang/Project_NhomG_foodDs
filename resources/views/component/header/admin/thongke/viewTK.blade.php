<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Báo cáo sản phẩm</title>
    <style>
        * {
            font-family: 'Roboto', sans-serif;
        }

        body {
            margin: 0 !important;
            padding: 10px !important;
        }

        .table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        .table th,
        .table td {
            border: 1px solid #ddd !important;
            padding: 5px !important;
            text-align: left !important;
        }

        .table th {
            background-color: #343a40 !important;
            color: white !important;
        }

        .text-center {
            text-align: center !important;
        }

        .btn {
            padding: 5px 10px !important;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 3px;
        }

        img {
            max-width: 50px;
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            list-style: none;
        }

        .pagination a {
            text-decoration: none
        }
    </style>
</head>

<body>
    <h2 class="text-center">Thông tin sản phẩm</h2>
    <section class="container">
        @if (!isset($pdf))
            <a href="{{ route('statistics.view') }}" class="btn mb-2">← Quay về</a>
        @endif
        @if (!isset($pdf))
            <form action="{{ route('pdf.statistic') }}" method="POST">
                @csrf
                <input type="hidden" name="mode" value="{{ $mode }}">
                <button class="btn mb-2" type="submit">Xuất báo cáo PDF</button>
            </form>
        @endif
        <div class="table-responsive">
            @if ($mode == 'OutOfStore')

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>ID</th>
                            @if (!isset($pdf) && auth()->user()->role == 'admin')
                                <th>Image</th>
                            @endif
                            <th>Name</th>
                            <th>Quantity Store</th>
                            @if (!isset($pdf) && auth()->user()->role == 'admin')
                                <th>Thao tác</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($OutOfStore as $product)
                            <tr>
                                <td>{{ $loop->iteration + ($OutOfStore instanceof \Illuminate\Pagination\LengthAwarePaginator ? $OutOfStore->firstItem() - 1 : 0) }}
                                </td>
                                <td>{{ $product->product_id }}</td>
                                @if (!isset($pdf) && auth()->user()->role == 'admin')
                                    <td>
                                        @if (!empty($product->product_image))
                                            <img src="{{ asset('component/image-product/' . $product->product_image) }}"
                                                alt="product" class="img-thumbnail">
                                        @endif
                                    </td>
                                @endif
                                <td>{{ $product->product_name }}</td>
                                <td data-qty-td="{{ $product->product_id }}" class="qty-change">
                                    {{ $product->quantity_store }}</td>
                                @if (!isset($pdf) && auth()->user()->role == 'admin')
                                    <td><button data-qty-id="{{ $product->product_id }}"
                                            data-qty-sl="{{ $product->quantity_store }}"
                                            class="btn btn-sm btn-success Qty">+</button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        {{-- <div style="display: flex">
                            {{ $OutOfStore->links('pagination::bootstrap-4') }}
                        </div> --}}

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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>ID</th>
                            @if (!isset($pdf) && auth()->user()->role == 'admin')
                                <th>Image</th>
                            @endif
                            <th>Name</th>
                            <th>Quantity Store</th>
                            <th>Price</th>
                            <th>Product Sale</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sale_products as $product)
                            <tr>
                                <td>{{ $loop->iteration + ($sale_products instanceof \Illuminate\Pagination\LengthAwarePaginator ? $sale_products->firstItem() - 1 : 0) }}
                                </td>
                                <td>{{ $product->product_id }}</td>
                                @if (!isset($pdf) && auth()->user()->role == 'admin')
                                    <td>
                                        @if (!empty($product->product_image))
                                            <img src="{{ asset('component/image-product/' . $product->product_image) }}"
                                                alt="product" class="img-thumbnail">
                                        @endif
                                    </td>
                                @endif
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->quantity_store }}</td>
                                <td>{{ number_format($product->product_price) }} ₫</td>
                                <td>{{ number_format($product->total_sale) }}</td>
                            </tr>
                        @endforeach
                        <div style="display: flex">
                            {{ $sale_products->links('pagination::bootstrap-4') }}
                        </div>
                    </tbody>
                </table>
            @elseif ($mode == 'potential_customers')
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>ID</th>
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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviewGoods as $client)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $client->product_id }}</td>
                                <td>{{ $client->product_name }}</td>
                                <td>{{ round($client->average_rating) }}
                                    @if (!isset($pdf) && auth()->user()->role == 'admin')
                                        ⭐
                                </td>
                        @endif
                        </tr>
            @endforeach
            </tbody>
            </table>
        @elseif ($mode == 'top_clients')
            <table class="table table-bordered">
                <thead>
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
                            <td>{{ number_format($client->total_spent) }} ₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif ($mode == 'sale_not_buy')
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale_not_buy as $client)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $client->product_id }}</td>
                            @if (!isset($pdf) && auth()->user()->role == 'admin')
                                <td>
                                    @if (!empty($client->product_image))
                                        <img src="{{ asset('component/image-product/' . $client->product_image) }}"
                                            alt="product" class="img-thumbnail">
                                    @endif
                                </td>
                            @endif
                            <td>{{ $client->product_name }}</td>
                            <td>{{ number_format($client->product_price) }} ₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </section>
</body>

</html>
