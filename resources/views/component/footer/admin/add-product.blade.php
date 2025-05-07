<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">

<div style="border: 2px solid #eeee" class="container ">
    <div>
        <a class="btn btn-primary" href="{{ route('admin.view.product') }}">quay lại</a>
    </div>

    <h3 class="mb-4">Thêm Sản Phẩm</h3>
    <form id="sendForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-7">
                <label for="product-name">Tên sản phẩm</label>
                <input type="text" class="form-control" name="product-name" id="product-name" required>
            </div>

            <div class="form-group col-md-2">
                <label for="price">Giá bán</label>
                <input name="product-price" type="number" class="form-control" id="price" required>
            </div>

            <div class="form-group col-md-1">
                <label for="qmount">Số lượng</label>
                <input name="product-amount" type="number" class="form-control" id="amount" required>
            </div>
        </div>

        <div class="form-group">
            <label for="category">Loại sản phẩm</label>
            <select name="categories_name" class="form-control" id="category" required>
                <option value="0"> --Chọn loại -- </option>
                @foreach ($cates as $cate)
                    <option value="{{ $cate->categories_id }}">{{ $cate->categories_name }}</option>
                @endforeach
            </select>
        </div>


        <div class="form-group">
            <label>Ảnh đại diện</label><br>
            <label for="image-product"> <img id="showImg" width="300" height="300"
                    class="object-fit-cover rounded border" src="{{ asset('component/image-product/imagDefault.png') }}"
                    alt=""></label>
            <input onchange="LoadImage()" name="product-image" id="image-product" type="file"
                class="form-control-file d-none" multiple>
        </div>

        <div class="form-group">
            <label for="description">Mô tả sản phẩm</label><br>
            <textarea name="product-description" style="width: 1000px; height: 200px;" id="description"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
    </form>


</div>
<script>
    function LoadImage() {
        const img = document.getElementById('image-product').files;

        const file = img[0];
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!allowedTypes.includes(file.type)) {
            alert('Chỉ chấp nhận ảnh JPEG, PNG hoặc WEBP!');
            return;
        }

        if (img.length > 0) {
            const readImg = new FileReader()
            readImg.onload = function(e) {
                const src = e.target.result;
                document.getElementById('showImg').src = src
            }
            readImg.readAsDataURL(img[0]);
        }
    }

    document.getElementById("sendForm").addEventListener("submit", (e) => {
        e.preventDefault();
        const form = e.target;
        const img = document.getElementById('image-product').files;
        const category = document.getElementById('category').value;

        let amount = document.getElementById('amount').value.trim();
        const price = document.getElementById('price').value.trim();

        if (parseInt(amount) < 0) {
            alert('Vui lòng nhập số lượng hợp lệ');
        } else if (parseInt(price < 0)) {
            alert('Vui lòng nhập giá tiền hợp lệ');
        } else if (category == "0") {
            alert('Vui lòng chọn danh mục');
        } else if (img.length === 0) {
            alert('Vui lòng chọn hình ảnh');
        } else {
            form.action = "{{ route('admin.add.product') }}";
            form.submit();
        }

    });

    // 
</script>
