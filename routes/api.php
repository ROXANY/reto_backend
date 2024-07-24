<?php

use App\Http\Controllers\SummaryController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

include_once 'v1/no-auth.php';

Route::group(['middleware' => ['jwt.verify']], function () {
    include_once 'v1/auth.php';

    Route::get('/voucher/getVouchersByFiltros'                  , [VoucherController::class, 'getVouchersByFiltros']);
    Route::post('/voucher'                                      , [VoucherController::class, 'create']);
    Route::post('/voucher/createVouchersAndUploadFromServer'    , [VoucherController::class, 'createVouchersAndUploadFromServer']);
    Route::put('/voucher/updateVouchersWithNewFields'           , [VoucherController::class, 'updateVouchersWithNewFields']);
    Route::delete('/voucher/delete/{id}'                        , [VoucherController::class, 'delete']);

    Route::get('/summary'                                       , [SummaryController::class, 'getTotalAccumulatedAmounts']);
});
