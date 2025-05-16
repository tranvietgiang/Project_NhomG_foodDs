<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin chi tiết khách hàng</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome để thêm icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .client-card {
            max-width: 600px;
            margin: 2rem auto;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .client-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .info-item i {
            color: #007bff;
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }

        .info-label {
            font-weight: bold;
            color: #333;
            min-width: 120px;
        }

        .info-value {
            color: #555;
        }

        .back-btn {
            display: inline-block;
            margin-top: 1rem;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }

        @media (max-width: 576px) {
            .client-card {
                margin: 1rem;
                padding: 1rem;
            }

            .client-avatar {
                width: 120px;
                height: 120px;
            }
        }
    </style>
</head>

<body>
    <section class="client-card">
        <!-- Avatar -->
        <div class="text-center mb-4">
            <img class="client-avatar" src="{{ asset('image-store/' . $user_detail->client_avatar) }}" alt="Avatar">
        </div>

        <!-- Thông tin chi tiết -->
        <div class="info-item">
            <i class="fas fa-user"></i>
            <span class="info-label">Tên:</span>
            <div class="info-value">{{ $user_detail->client_name }}</div>
        </div>

        <div class="info-item">
            <i class="fas fa-birthday-cake"></i>
            <span class="info-label">Ngày sinh:</span>
            <div class="info-value">{{ $user_detail->dat_of_birth }}</div>
        </div>

        <div class="info-item">
            <i class="fas fa-map-marker-alt"></i>
            <span class="info-label">Địa chỉ:</span>
            <div class="info-value">
                @php
                    // $address = ['123 Đường Láng', 'Quận Đống Đa', 'Hà Nội'];
                    // $address_string = implode(', ', $address);
                    $address = explode(',', $user_detail->client_address);
                @endphp
                @foreach ($address as $addr)
                    <div>{{ $addr }}</div>
                @endforeach
            </div>
        </div>

        <div class="info-item">
            <i class="fas fa-phone"></i>
            <span class="info-label">Số điện thoại:</span>
            <div class="info-value">{{ $user_detail->client_phone }}</div>
        </div>

        <!-- Nút quay lại -->
        <a href="{{ url('/role/admin/client') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </section>

    <!-- Bootstrap JS và Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
