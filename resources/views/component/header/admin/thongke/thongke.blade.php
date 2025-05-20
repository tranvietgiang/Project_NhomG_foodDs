<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">

<div class="container mt-4">

    {{-- Thống kê tổng quan --}}
    <div class="row text-white g-3 mb-4">
        <div class="col-md-2 col-sm-6">
            <div class="card bg-info text-center shadow">
                <div class="card-body">
                    <h2>{{ $count ?? 0 }}</h2>
                    <p>Sắp hết trong kho</p>
                    <a href="{{ route('statistics.quantity_store') }}" class="btn btn-light btn-sm">Chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-sm-6">
            <div class="card bg-success text-center shadow">
                <div class="card-body">
                    <h2>46</h2>
                    <p>SP bán chạy nhất</p>
                    <a href="#" class="btn btn-light btn-sm">Chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-sm-6">
            <div class="card bg-warning text-center shadow">
                <div class="card-body">
                    <h2>1</h2>
                    <p>Top SP đánh giá </p>
                    <a href="#" class="btn btn-light btn-sm">Chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-sm-6">
            <div class="card bg-danger text-center shadow">
                <div class="card-body">
                    <h2>36</h2>
                    <p>Duyệt yêu cầu nhập</p>
                    <a href="#" class="btn btn-light btn-sm">Chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-sm-6">
            <div class="card bg-primary text-center shadow">
                <div class="card-body">
                    <h2>34</h2>
                    <p>CT nhập chưa duyệt</p>
                    <a href="#" class="btn btn-light btn-sm">Chi tiết</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Biểu đồ doanh số --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>THỐNG KÊ DOANH SỐ</strong>
            <span>Thời gian: 04/05/2020 - 11/05/2020</span>
        </div>
        <div class="card-body">
            <canvas id="salesChart" height="100"></canvas>
        </div>
    </div>

    {{-- Bộ lọc danh mục --}}
    <div class="card mb-4">
        <div class="card-body">
            <label class="form-label"><strong>Lọc theo danh mục sản phẩm:</strong></label>
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-2">
                    <select>
                        <option value="">aaa</option>
                        <option value="">aaa</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 mb-2">
                    <select>
                        <option value="">aaa</option>
                        <option value="">aaa</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 mb-2">
                    <select>
                        <option value="">aaa</option>
                        <option value="">aaa</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 mb-2">
                    <select>
                        <option value="">aaa</option>
                        <option value="">aaa</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 mb-2">
                    <select>
                        <option value="">aaa</option>
                        <option value="">aaa</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 mb-2">
                    <select>
                        <option value="">aaa</option>
                        <option value="">aaa</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 mb-2">
                    <select>
                        <option value="">aaa</option>
                        <option value="">aaa</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['04/05', '05/05', '06/05', '07/05', '08/05', '09/05', '10/05', '11/05'],
            datasets: [{
                label: 'Tổng tiền (VNĐ)',
                data: [1000000, 500000, 0, 8000000, 0, 0, 0, 0],
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderRadius: 5,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + ' đ';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
</script>
