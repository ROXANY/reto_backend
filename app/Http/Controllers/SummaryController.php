<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SummaryController extends Controller
{
    public function getTotalAccumulatedAmounts() 
    {
        $vouchers = Voucher::select(
                'document_currency_code as currency', 
                DB::raw('SUM(total_amount) AS total')
            )
            ->groupBy('document_currency_code')
            ->get();

        return new JsonResponse(['status' => 'success','message' => 'Ok','data' => $vouchers], 200);
    }
}
