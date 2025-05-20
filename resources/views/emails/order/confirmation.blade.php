@component('mail::message')
    # Xác nhận đơn hàng

    Cảm ơn bạn đã đặt hàng! Dưới đây là thông tin đơn hàng:

    @foreach ($cart as $item)
        - **Sản phẩm:** {{ $item->product_name }}
        - **Số lượng:** {{ $item->quantity_sp }}
        - **Giá:** {{ number_format($item->total_price) }} VND
    @endforeach

    @component('mail::button', ['url' => url('/payment/view/many')])
        Xem chi tiết
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
