<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7f6;
        display: flex;
        height: 100vh;
        align-items: center;
        justify-content: center;
        margin: 0;
    }

    section {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 30px 40px;
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    h1 {
        color: #28a745;
        margin-bottom: 15px;
    }

    p {
        margin: 8px 0;
        color: #333;
        font-size: 16px;
    }

    p:first-of-type {
        font-weight: bold;
    }

    p:last-of-type {
        margin-bottom: 20px;
    }

    div a {
        display: inline-block;
        text-decoration: none;
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border-radius: 8px;
        transition: background-color 0.3s;
    }

    div a:hover {
        background-color: #0056b3;
    }
</style>
@if ($status == 'success')
    <section>
        <h1>Thanh toán thành công!</h1>
        <p>Mã giao dịch: {{ $txnRef ?? 'Không có mã giao dịch' }}</p>
        <p>Sản phẩm: {{ $name ?? 'Không có thông tin sản phẩm' }}</p>
        <p>Số tiền: {{ number_format($price ?? 0, 0, ',', '.') }} VND</p>
        <div><a href="{{ route('website-main') }}">Quay lại</a></div>
    </section>
@else
    <section>
        <h1>Thanh toán thất bại!</h1>
        <p>Mã giao dịch: {{ $txnRef ?? 'Không có mã giao dịch' }}</p>
        <div><a href="{{ url()->previous() }}">Quay lại</a></div>
    </section>
@endif
