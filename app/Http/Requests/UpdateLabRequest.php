<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLabRequest extends FormRequest
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
            'satuan' => 'required',
            'parameter'=>'required|string',
            'hasil'=>'required|string',
            'kesimpulan'=>'required|string',
            'grid'=>'required|string',
        ];
    }
}
