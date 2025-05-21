<?php

use App\Exports\CustomersExport;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartManyGController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\EmployessController;
use App\Http\Controllers\ExcelClientController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HeartGController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTuyenController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\PTTTController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\SDTController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ThanhToanNhieuItemController;
use App\Http\Controllers\ZaloPayController;
use App\Http\Middleware\checkLogin;
use App\Models\login;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LastActivity;
use App\Http\Middleware\RoleAdmin;
use App\Http\Middleware\SessionEmail;
use App\Models\district;
use App\Models\Product;
use App\Models\ward;
use Database\Seeders\CategorieSeeders;
use Database\Seeders\ProductsSeeder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\View\View as ViewView;

/**
 * tên domain default website
 */
Route::get('/food_ds.com', [LoginController::class, 'showIndex'])->name('website-main');
Route::get('/sale-item', [LoginController::class, 'OrderBestSale'])->name('sale.item.index');




/** 
 * đường đi cua các form login
 */
Route::get('/role/{page}', [LoginController::class, 'index'])
    ->where('page', 'login|register|forgot|')
    ->name('wayLogin');

/**
 * check login
 */
/** git */
Route::prefix('/login')
    ->group(function () {
        Route::post('/check', [LoginController::class, 'login'])->name('check');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::post('/register', [LoginController::class, 'register'])->name('register');
        Route::post('/forgot', [LoginController::class, 'forgot'])->name('forgot');
        Route::get('/forgot_form', [LoginController::class, 'forgot_form'])->name('forgot_form');
        Route::post('/update_pw', [LoginController::class, 'update_pw'])->name('update_pw');
    });

Route::get('/login/check', function () {
    return redirect()->route('wayLogin', ['page' => 'login']);
});
Route::get('/login/logout', function () {
    return redirect()->route('wayLogin', ['page' => 'login']);
});
Route::get('/login/register', function () {
    return redirect()->route('wayLogin', ['page' => 'login']);
});

/**
 * show data role access form admin and employees and client 
 * /role/admin/check
 */
Route::prefix('/role/admin')
    ->middleware(RoleAdmin::class)
    ->group(function () {
        Route::get('/client', [AdminController::class, 'listClient'])->name('manager');
        Route::get('/search_client', [AdminController::class, 'search_client'])->name('search_client'); // search_client
        Route::get('/employees', [AdminController::class, 'showEmployees'])->name('employees');
        Route::get('/search_employees', [AdminController::class, 'search_staff'])->name('staff.search_employees'); // route staff.search_employees
        Route::get('/search_employees/edit/view/{employees_id}', [AdminController::class, 'edit_view_staff'])->name('staff.view.edit');
        Route::put('/search_employees/edit/{staff}', [AdminController::class, 'edit_staff'])->name('staff.edit');
        Route::get('/search_employees/remove/{employees_id}', [AdminController::class, 'remove_staff'])->name('staff.remove');
        Route::get('/search_employees/add', [AdminController::class, 'add_view_staff'])->name('staff.add.view');
        Route::get('/search_employees/add/{employees_id}', [AdminController::class, 'add_staff'])->name('staff.add');
    })->middleware(checkLogin::class);

Route::prefix("/check")
    ->middleware(RoleAdmin::class)
    ->group(function () {
        Route::get('/ui/view', [ProductTuyenController::class, 'view_admin_product'])->name('admin.view.product');
        Route::get('/ui/product/add/view', [ProductTuyenController::class, 'add_view_product'])->name('admin.view.product-add');
        Route::get('/ui/product/search', [ProductTuyenController::class, 'search_client_product'])->name('search.client.product');
        Route::get('/ui/product/quantityStore', [ProductTuyenController::class, 'quantityStore'])->name('search.client.quantityStore');
        Route::get('/ui/product/quantityStoreDesc', [ProductTuyenController::class, 'quantityStoreDesc'])->name('search.client.quantityStoreDesc');
        Route::get('/ui/product/viewUpdate', [ProductTuyenController::class, 'ViewProductUpdate'])->name('admin.view.product.new');
        Route::post('/ui/product/add', [ProductTuyenController::class, 'add_product'])->name('admin.add.product');
        Route::get('/ui/product/edit/view', [ProductTuyenController::class, 'edit_view_product'])->name('admin.edit.view.product');
        Route::post('/ui/product/edit', [ProductTuyenController::class, 'edit_product'])->name('admin.edit.product');
        Route::get('/ui/product/remove', [ProductTuyenController::class, 'remove_product'])->name('admin.remove.product');
    });


/**email form register */
Route::get('/form-otp', [LoginController::class, 'showOtpForm'])->name('otp.form') /*->middleware(checkLogin::class)*/;
Route::post('/send-otp', [LoginController::class, 'sendOtp'])->name('send.otp')/*->middleware(checkLogin::class)*/;
Route::post('/verify-otp', [LoginController::class, 'verifyOtp'])->name('verify.otp')/*->middleware(checkLogin::class)*/;


/** forgot-email-otp*/
Route::get('otpForgot', [LoginController::class, 'formOtpForgot'])->name('form.otp');
// form confirm otp email
Route::post('/verify-otp-forgot', [LoginController::class, 'verifyOtpForgot'])->name('verifyOTP.otpForgot')/*->middleware(checkLogin::class)*/;





/** các phương thức thanh toán đơn hàng */
/** show form */
Route::get('/showVnPay', [AdminController::class, 'showVnPayCheckout'])->name('showVnPayCheckout') /*->middleware(checkLogin::class)*/;

/** checkout toán vnpay1 */
Route::post('/vnpay_payment', [PTTTController::class, 'vnpay_payment'])->name('vnpay.payment')/*->middleware(checkLogin::class)*/;

/* result success or failed1 */
Route::get('/vnpay_return', [PTTTController::class, 'vnpay_return'])->name('vnpay.return')/*->middleware(checkLogin::class)*/;

/** kiểm tra xem client chọn pttt nào1 */
Route::post('/pttt/payment/checkout', [PTTTController::class, 'select_payment_client'])->name('checkout.pptt.payment');

/** thanh toán khi nhận hàng */
Route::post('/pttt/payment/ttknh', [PTTTController::class, 'payment_cod'])->name('pptt.payment.cod');
/** show form bill */
Route::get('show/bill/products/{cart_id}', [ViewController::class, 'show_bill_product'])->name('bill.show_bill_product');
/**====================================================================================================== */


/** show ra địa chỉ vn */
Route::post('/get-districts', [LoginController::class, 'getDistricts']);
Route::post('/get-wards', [LoginController::class, 'getWards']);


/** show form information client */
Route::get('/information-client', [LoginController::class, 'show_information'])->middleware(checkLogin::class);
Route::post('/update-client', [AdminController::class, 'update_client'])->middleware(checkLogin::class)->name('update_client'); // router
Route::post('/client-avatar-image-update', [AdminController::class, 'client_avatar_update'])->middleware(checkLogin::class);

/** login vs google */
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

/** login vs github */
Route::get('login/github', [GithubController::class, 'redirectToProvider']);
Route::get('login/github/callback', [GithubController::class, 'handleProviderCallback']);


/* cart đặt hàng  */
Route::get('/cart/show_checkout/{product_id}', [ViewController::class, 'show_cart_mua_ngay'])->middleware(checkLogin::class); // 
// Route::get('/cart/dathang/{product_id}', [ProductController::class, 'cart_mua_ngay'])->name('cart.show_cart_mua_ngay');

/** cart and review  giang*/
Route::get('/cart/{product_id}', [ViewController::class, 'show_cart'])->name('show_cart'); // hiển thị thông tin chi tiết sản phẩm
Route::post('/client/review/cart/bought', [ProductController::class, 'review'])->middleware(checkLogin::class); // router thêm comment
Route::get('/delete/client_comment/{review_id}', [ProductController::class, 'delete_review'])->name('client.comment.delete')->middleware(checkLogin::class); // router delete comment
Route::get('/update/review/{review_id}', [ProductController::class, 'update_review'])->name('client.comment.update')->middleware(checkLogin::class); // router edit comment
Route::get('/getAvatar/hi', [ProductController::class, 'getAvatar']); // get avatar



/** zaloPay */
Route::post('/zaloPay/payment', [ZaloPayController::class, 'zalopay'])->name('zalo.payment');
Route::get('/zaloPay/callback', [ZaloPayController::class, 'callback_zalopay'])->name('zalo.callback');

/** zaloPay thanh toán nhiều đơn hàng */
Route::post('/zaloPay/payment/Many', [ThanhToanNhieuItemController::class, 'zalopay'])->name('zalo.many.payment'); // router zalo mua nhiều
Route::get('/zaloPay/callback/many', [ThanhToanNhieuItemController::class, 'callback_many_zalopay'])->name('zalo.many.callback'); // router callback zalo mua nhiều


/** xem thông tin chi tiết */
Route::get('/client/info/{user_id}', [AdminController::class, 'client_detail_manager'])->name('client.detail.manager');

// thanh toán momo ca
Route::post('/momo_payment', [CheckoutController::class, 'momo_payment'])->name('momo_payment');

// hiện thị tất cả sản phẩm ca
Route::get('/allproduct', [ProductController::class, 'showallproduct'])->name('allproduct');

/** cart cả */
Route::get('/cart', [ProductController::class, 'show_cartCa'])->name('cart');
Route::post('/cart/add', [ProductController::class, 'addtocart'])->name('cart.add')->middleware(checkLogin::class);;
Route::get('/viewcart', [ProductController::class, 'viewcart'])->name('viewcart');
Route::delete('/cart/removeCart/{id}', [ProductController::class, 'removeCart'])->name('cart.removeCart');
Route::put('/cart/update/{id}', [ProductController::class, 'updateSL'])->name('cart.update');


/** thanh toán nhiều đơn hàng */
Route::get('/cart/update/{id}', [ProductController::class, 'updateSL'])->name('cart.update');
Route::get('/shows_goods/cart', [ThanhToanNhieuItemController::class, 'cart_shows_goods'])->name('cart.shows_goods'); // route giỏ hàng
Route::post('/shows_goods/handle_amount', [ThanhToanNhieuItemController::class, 'handle_amount'])->name('cartMany.amount.item'); // route tăng giảm số lượng
Route::get('/handle_amount/remove', [ThanhToanNhieuItemController::class, 'handle_remove_giang'])->name('remove.cartMany.giang'); // route xóa cart mua nhiều
Route::get('/handle_amount/removeAll', [ThanhToanNhieuItemController::class, 'handle_remove_all_giang'])->name('goods.cartManyAll');

/** thêm cart nhiều */
Route::post('/add/cartMany/{product_id}/{price_goods}', [CartManyGController::class, 'add_cartMany'])->name('add.cartMany.giang');
Route::get('/list/heart', [CartManyGController::class, 'show_heart'])->name('goods.heart.giang'); // qua ds heart

Route::post('/list/heart/add', [CartManyGController::class, 'addHeartClient'])->name('heart.list.client'); // router thêm heart

Route::post('/amount/heart', [HeartGController::class, 'updateAmount'])->name('heart.amount.list');

Route::get('/amount/heart/delete', [HeartGController::class, 'delete_heart'])->name('delete.heart.giang'); // router delete sản phẩm yêu thích

// hiện thị  sản phẩm yêu thích
Route::get('/sanphamyeuthich', [ProductController::class, 'sanphamyeuthich'])->name('sanphamyeuthich');


/** thanh toán nhiều đơn hàng tùy ý khách hàng */
Route::get('/show/cartMany/bill', [ThanhToanNhieuItemController::class, 'show_billCartMany'])->name('show.bill.cartMany');
Route::post('/show/url/cartMany', [ThanhToanNhieuItemController::class, 'routeBill']);

Route::post('/get/money/select', [ThanhToanNhieuItemController::class, 'priceSelect'])->name('priceSelect.money');


Route::post('/show/cartMany/bill/check', [ThanhToanNhieuItemController::class, 'priceSelect'])->name('show.bill.cartMany.bill');

//==============================================================================================================
/** thanh toán khi nhận hàng cod git */
Route::post('/ttknh/cod', [ThanhToanNhieuItemController::class, 'cod'])->name('cod.ttknh.cartMany');


// tìm kiếm sản phẩm 
Route::get('/seach', [ProductController::class, 'search'])->name('seach');

// xóa giỏ hàng khi thanh toán thành công  
Route::post('payment/success', [CheckoutController::class, 'handlePaymentSuccess'])->name('thanhtoanthanhcong');

// sắp xếp sản phẩm theo giá cao xuống thấp 
Route::get('/caoxuongthap', [ProductController::class, 'sapxepgiacaoxuongthap'])->name('caoxuongthap');

// sắp xếp sản phẩm theo giá thấp đến cao 
Route::get('/thaplencao', [ProductController::class, 'sapxepgiathapdencao'])->name('thaplencao');

//thêm sản phẩm yêu  thích 
Route::post('/addspyeuthich', [FavoriteController::class, 'addFavorite'])->name('addspyeuthich')->middleware(checkLogin::class);

// form view thanh toán success or failed git
Route::get('/payment/view/success', [ThanhToanNhieuItemController::class, 'payment_success'])->name('payment.many.payment.success');
Route::get('/payment/view/failed', [ThanhToanNhieuItemController::class, 'payment_failed'])->name('payment.many.payment.failed');


/** order */
Route::get('/payment/view/many', [ThanhToanNhieuItemController::class, 'MyOrder'])->name('MyOrder.information');


/** thanh toán nhiều đơn hàng vnpay*/
Route::post('/showVnPay/many', [ThanhToanNhieuItemController::class, 'vnpay'])->name('vnpay.payment.many') /*->middleware(checkLogin::class)*/;
Route::get('/vnpay_payment/many', [ThanhToanNhieuItemController::class, 'call_vnpay_back'])->name('vnpay.payment.many.callback')/*->middleware(checkLogin::class)*/;

Route::get('header/show/render', [ProductController::class, 'header_show_render'])->name('header.show.render'); // route tìm kiếm gợi ý

/** excel laravel */
Route::get('/export-users', [EmployessController::class, 'export']);
Route::get('/export-customers', [ExcelClientController::class, 'export'])->name('export.customers');

/** thống kê giang*/
Route::get('/thong/ke', [StatisticsController::class, 'view'])->name('statistics.view');
Route::get('/thong/ke/quantity_store', [StatisticsController::class, 'quantitysp_store'])->name('statistics.quantity_store');
Route::get('/thong/ke/saleProduct', [StatisticsController::class, 'sale'])->name('statistics.saleProduct');
Route::get('/thong/ke/logincount', [StatisticsController::class, 'potential_customers'])->name('statistics.potential_customers');
Route::get('/thong/ke/reviewGoods', [StatisticsController::class, 'reviewGoods'])->name('statistics.reviewGoods');
Route::get('/thong/ke/top/clients', [StatisticsController::class, 'top_client'])->name('statistics.top_clients');
Route::post('/thong/ke/qty', [StatisticsController::class, 'qty'])->name('statistics.qty');
Route::get('/admin/statistics/sale_not_buy', [StatisticsController::class, 'sale_not_buy'])->name('statistics.sale_not_buy');

/** duy hưng */
Route::resource('promotions', PromotionController::class)->except(['show']);
Route::get('/promotions/search', [PromotionController::class, 'search'])->name('promotions.search');

/** categories hung crud */
Route::resource('categories', CategoryController::class)->except(['show']);;
/** search duy hung */
Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');