     <!-- link md bootstrap(thư viên của bootstrap) -->
     <link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
     <div class=""><a href="{{ url()->previous() }}">Quay lại</a></div>
     <section>
         <div>thêm địa chỉ nhận hàng(chưa có) <a href="{{ url('/information-client') }}">tại đây</a></div>


         <!-- thông tin đơn hàng -->
         <!-- Thông tin đơn hàng -->
         <div class="">
             <h3>Thông tin đơn hàng</h3>

             @foreach ($cart as $item)
                 <div class="card mb-3 p-3 d-flex flex-row align-items-center" style="gap: 20px;">
                     <div>
                         <strong>
                             <img src="{{ asset('component/image-product/' . $item->product_image) }}" alt="Sản phẩm"
                                 class="img-thumbnail" width="150" height="150">
                         </strong>
                     </div><br>
                     <div>
                         <h6 class="mb-1">Tên: {{ $item->product_name }}</h6>
                         <p>
                             Số lượng: {{ $item->quantity_sp }}
                         </p>
                         <p class="mb-1">Tiền: <strong>{{ $item->total_price }}</strong></p>
                     </div>
                 </div>

                 @php
                     $total_price_final = $item->total_price * $item->quantity_sp;
                 @endphp
             @endforeach

             <div class="mb-3">
                 <label for="cart_discount" class="form-label">Phiếu giảm giá</label>
                 <input name="cart_discount" id="cart_discount" type="text" class="form-control"
                     placeholder="Nhập mã giảm giá">
             </div>

             <!-- handle total price -->
             <div class="fs-5">
                 Tổng tiền: <strong>{{ $total_price_final }}</strong>
             </div>
         </div>



         <form action="#" method="post">
             <input type="hidden" value="2000000" name="cart_name">
             <input type="hidden" value="123213" name="cart_price">
             <input type="hidden" value="123213" name="cart_quality">
             <input type="hidden" value="2000000" name="cart_total_price">

             <div><button class="btn btn-outline-success">Đặt hàng</button></div>
         </form>
     </section>
