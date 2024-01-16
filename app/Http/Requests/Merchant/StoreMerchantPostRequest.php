<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreMerchantPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug' => 'required|unique:mag_merchant_posts,slug,'.$this->id,
            'title'=>'required',
            'author' => 'required'
        ];
    }
//    public function failedValidation(Validator $validator)
//    {
//        throw new HttpResponseException(response()->json([
//            'success' => false,
//            'error' => $validator->errors()
//        ]));
//    }
}
