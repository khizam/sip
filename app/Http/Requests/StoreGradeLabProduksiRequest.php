<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGradeLabProduksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_produksi' => 'required|exists:produksi_barang,id_produksi',
            'id_grade' => 'required|exists:grade,id_grade',
            'jumlah_produk' => 'required|integer|not_in:0',
        ];
    }
}
