<?php

namespace App\Http\Controllers;

use App\Models\bill;
use App\Models\bill_product;
use App\Models\Cart;
use App\Models\Cart_buyed;
use App\Models\method_payments;
use App\Mail\OrderConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function momo_payment(Request $request)
    {
        $amount = (int) ($request->input('totalAmount') ?: $request->input('total_price_payment'));

        if ($amount < 1000) {
            return redirect()->back()->with('payment-error', 'Số tiền thanh toán MoMo không hợp lệ.');
        }

        $endpoint = config('services.momo.endpoint');
        $partnerCode = config('services.momo.partner_code');
        $accessKey = config('services.momo.access_key');
        $secretKey = config('services.momo.secret_key');
        $requestType = config('services.momo.request_type', 'payWithMethod');

        if (!$endpoint || !$partnerCode || !$accessKey || !$secretKey) {
            return redirect()->back()->with('payment-error', 'Chưa cấu hình thông tin thanh toán MoMo.');
        }

        $orderId = 'FD' . now()->format('YmdHis') . random_int(100, 999);
        $requestId = $orderId;
        $orderInfo = 'Thanh toán đơn hàng FoodDS ' . $orderId;
        $redirectUrl = route('momo.return');
        $ipnUrl = route('momo.ipn');
        if ($request->filled('arrShow')) {
            session()->put('momo_arr_show', $request->input('arrShow'));
        } elseif ($request->filled('cart_id_payment') && $request->filled('product_id')) {
            session()->put('momo_single_order', [
                'cart_id' => $request->input('cart_id_payment'),
                'product_id' => $request->input('product_id'),
            ]);
        }

        $extraData = base64_encode(json_encode([
            'user_id' => Auth::id() ?: $request->input('user_id_payment'),
            'cart_id' => $request->input('cart_id_payment'),
            'product_id' => $request->input('product_id'),
        ]));

        $rawHash = 'accessKey=' . $accessKey .
            '&amount=' . $amount .
            '&extraData=' . $extraData .
            '&ipnUrl=' . $ipnUrl .
            '&orderId=' . $orderId .
            '&orderInfo=' . $orderInfo .
            '&partnerCode=' . $partnerCode .
            '&redirectUrl=' . $redirectUrl .
            '&requestId=' . $requestId .
            '&requestType=' . $requestType;

        $payload = [
            'partnerCode' => $partnerCode,
            'partnerName' => 'FoodDS',
            'storeId' => 'FoodDSStore',
            'requestId' => $requestId,
            'amount' => (string) $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => hash_hmac('sha256', $rawHash, $secretKey),
        ];

        try {
            $response = Http::timeout(15)
                ->acceptJson()
                ->asJson()
                ->post($endpoint, $payload);
        } catch (\Throwable $exception) {
            Log::error('MoMo create payment failed', [
                'message' => $exception->getMessage(),
                'payload' => $payload,
            ]);

            return redirect()->back()->with('payment-error', 'Không kết nối được MoMo, vui lòng thử lại.');
        }

        $jsonResult = $response->json();

        if (!$response->successful() || empty($jsonResult['payUrl'])) {
            Log::warning('MoMo create payment rejected', [
                'status' => $response->status(),
                'response' => $jsonResult,
                'payload' => $payload,
            ]);

            return redirect()->back()->with(
                'payment-error',
                $jsonResult['message'] ?? 'MoMo chưa tạo được liên kết thanh toán.'
            );
        }

        return redirect()->away($jsonResult['payUrl']);
    }

    public function momo_return(Request $request)
    {
        $resultCode = (string) $request->query('resultCode', '');

        if ($resultCode === '0') {
            $this->completeManyItemMomoOrder();
            $this->completeSingleItemMomoOrder();

            return redirect()->route('website-main')
                ->with('payment-success', 'Thanh toán MoMo thành công.');
        }

        return redirect()->route('website-main')
            ->with('payment-error', $request->query('message', 'Thanh toán MoMo chưa thành công.'));
    }

    public function momo_ipn(Request $request)
    {
        Log::info('MoMo IPN received', $request->all());

        return response()->json([
            'resultCode' => 0,
            'message' => 'Received',
        ]);
    }

    private function completeManyItemMomoOrder(): void
    {
        $json = session()->pull('momo_arr_show');

        if (!$json || !Auth::check()) {
            return;
        }

        $items = json_decode($json);

        if (!is_array($items)) {
            return;
        }

        $method = method_payments::firstOrCreate(
            ['method_payment_type' => 'MoMo'],
            ['method_payment_name' => 'MoMo']
        );

        foreach ($items as $item) {
            if (empty($item->cart_id) || empty($item->product_id)) {
                continue;
            }

            $exists = Cart_buyed::where('cart_id', $item->cart_id)
                ->where('product_id', $item->product_id)
                ->where('user_id', Auth::id())
                ->exists();

            if ($exists) {
                continue;
            }

            Cart_buyed::create([
                'cart_id' => $item->cart_id,
                'product_id' => $item->product_id,
                'user_id' => Auth::id(),
                'quantity_sp' => $item->quantity_sp ?? 1,
                'total_price' => $item->total_price ?? 0,
                'image' => $item->image ?? null,
            ]);

            $bill = bill::create([
                'user_id' => Auth::id(),
                'cart_id' => $item->cart_id,
                'method_payment_id' => $method->method_payment_id,
            ]);

            bill_product::create([
                'bill_id' => $bill->bill_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity_sp ?? 1,
            ]);

            Cart::where('user_id', Auth::id())
                ->where('cart_id', $item->cart_id)
                ->delete();
        }

        try {
            Mail::to(Auth::user()->email)->send(new OrderConfirmationMail(collect($items)));
        } catch (\Throwable $exception) {
            Log::warning('Order confirmation mail failed after MoMo payment', [
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
            ]);
        }
    }

    private function completeSingleItemMomoOrder(): void
    {
        $data = session()->pull('momo_single_order');

        if (!$data || !Auth::check()) {
            return;
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('cart_id', $data['cart_id'])
            ->where('product_id', $data['product_id'])
            ->first();

        if (!$cart) {
            return;
        }

        $method = method_payments::firstOrCreate(
            ['method_payment_type' => 'MoMo'],
            ['method_payment_name' => 'MoMo']
        );

        $exists = Cart_buyed::where('cart_id', $cart->cart_id)
            ->where('product_id', $cart->product_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (!$exists) {
            Cart_buyed::create([
                'cart_id' => $cart->cart_id,
                'product_id' => $cart->product_id,
                'user_id' => Auth::id(),
                'quantity_sp' => $cart->quantity_sp,
                'total_price' => $cart->total_price,
                'image' => $cart->image,
            ]);

            $bill = bill::create([
                'user_id' => Auth::id(),
                'cart_id' => $cart->cart_id,
                'method_payment_id' => $method->method_payment_id,
            ]);

            bill_product::create([
                'bill_id' => $bill->bill_id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity_sp,
            ]);
        }

        $mailCart = Cart::with('products')->whereKey($cart->cart_id)->get();
        $cart->delete();

        try {
            Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($mailCart));
        } catch (\Throwable $exception) {
            Log::warning('Order confirmation mail failed after single MoMo payment', [
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
            ]);
        }
    }
}
