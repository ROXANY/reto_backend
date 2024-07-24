<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vouchers\GetVouchersByFiltrosRequest;
use App\Http\Requests\Vouchers\SetVoucherRequest;
use App\Http\Resources\Vouchers\VoucherResource;
use App\Models\Voucher;
use App\Services\VoucherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    protected const PER_PAGE = 10;

    public function __construct(private readonly VoucherService $voucherService)
    {
    }

    public function getVouchersByFiltros(GetVouchersByFiltrosRequest $request)
    {
        $validated = $request->validated();

        $vouchers = Voucher::with('user', 'lines');

        if (!empty($validated['voucher_series']))
            $vouchers = $vouchers->where('voucher_series', $validated['voucher_series']);

        if (!empty($validated['voucher_number']))
            $vouchers = $vouchers->where('voucher_number', $validated['voucher_number']);

        if (!empty($validated['star_date']) && !empty($validated['end_date']))
            $vouchers = $vouchers->whereBetween('created_at', [$validated['start_date'], $validated['end_date']]);
    
        return VoucherResource::collection($vouchers->paginate(SELf::PER_PAGE, ['*'], '', $validated['page']));
    }

    public function create(Request $request)
    {
        $xml_content = $request->getContent();
        $voucher = $this->voucherService->storeVoucherFromXmlContent($xml_content, auth()->user());
        return VoucherResource::make($voucher);
    }

    public function createVouchersAndUploadFromServer()
    {
        $vouchersToUpload = Voucher::select('xml_content')->get();
        $vouchers = $vouchersToUpload->map(fn ($item) => $item->xml_content)->toArray();
        $this->voucherService->storeVouchersFromXmlContents($vouchers, auth()->user());

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Los vouchers se han subido correctamente y están siendo procesados en segundo plano.',
            'data' => null
        ], 200);
    }

    public function updateVouchersWithNewFields()
    {
        $vouchers = [];
        $voucherNeedsUpdate = Voucher::select('id', 'xml_content')->where('voucher_need_update', 0)->get();

        foreach ($voucherNeedsUpdate as $value) {
            $vouchers[] = $this->voucherService->updateVoucherFromXmlContent($value->id, $value->xml_content, auth()->user());
        }

        return VoucherResource::collection($vouchers);
    }

    public function delete(string $voucherId)
    {
        Voucher::findOrFail($voucherId)->delete();
        return new JsonResponse(['status' => 'success', 'message' => 'Comprobante eliminado con éxito.', 'data' => null], 200);
    }
}
