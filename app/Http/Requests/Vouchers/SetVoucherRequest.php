<?php

namespace App\Http\Requests\Vouchers;

use Illuminate\Foundation\Http\FormRequest;

class SetVoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'issuer_name'               => ['required', 'string', 'max:255'],
            'issuer_document_type'      => ['required', 'string', 'max:255'],
            'issuer_document_number'    => ['required', 'string', 'max:255'],
            'receiver_name'             => ['required', 'string', 'max:255'],
            'receiver_document_type'    => ['required', 'string', 'max:255'],
            'receiver_document_number'  => ['required', 'string', 'max:255'],
            'total_amount'              => ['required'],
            'document_currency_code'    => ['required', 'string', 'max:20'],
            'invoice_type_code'         => ['required', 'string', 'max:20'],
            'voucher_series'            => ['required', 'string', 'max:4'],
            'voucher_number'            => ['required', 'string', 'max:8'],
            //'xml_content'               => ['required', 'text']
            // 'voucher_lines'             => ['array', 'required'],
            // 'voucher_lines.*.name'      => ['required', 'integer', 'exists:pos_book,book_id'],
            // 'voucher_lines.*.quantity'  => ['required', 'integer'],
            // 'voucher_lines.*.unit_price'=> ['required', 'integer']
        ];
    }
}
