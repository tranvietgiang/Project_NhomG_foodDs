<?php

namespace App\Http\Controllers;

use App\Models\listHeart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class HeartGController extends Controller
{
    public function updateAmount(Request $request)
    {
        $heartId = $request->input('idHeart');
        $amount = $request->input('change_amount');

        $heartExists = listHeart::where('heart_id', $heartId)->first();

        if ($heartExists) {
            $heartExists->update(['heart_amount' => $amount]);

            $price_new = $heartExists->heart_price * $amount;
            return response()->json([
                'price_new' => number_format($price_new)
            ]);
        }
    }

    public function delete_heart(Request $req)
    {
        listHeart::where('heart_id', $req->input('idHeartDelete'))->delete();
        return redirect()->back();
    }
}