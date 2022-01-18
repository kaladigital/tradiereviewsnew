<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as Request;
use Illuminate\Http\JsonResponse;

class AdminFAQRequest extends Request
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
            'title' => 'required',
            'description' => 'required',
            'order_num' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Please specify title',
            'description.required' => 'Please specify description',
            'order_num' => 'Please specify order'
        ];
    }
}
