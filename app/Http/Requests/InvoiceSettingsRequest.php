<?php
/**
 * Created by PhpStorm.
 * User: brainfors
 * Date: 4/29/21
 * Time: 2:57 PM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class InvoiceSettingsRequest extends FormRequest
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
            'invoice_company_name' => 'required|string',
            'invoice_country_id' => 'required|int',
            'invoice_zip_code' => 'required|string',
            'invoice_city' => 'required|string',
            'invoice_state' => 'required|string',
            'invoice_address' => 'required|string',
            'invoice_bank_number' => 'required|string',
            'invoice_bank_name' => 'required|string',
            'invoice_swift_code' => 'required|string',

        ];
    }
    /**
     * Return errors
     * @param array $errors
     * @return JsonResponse
     */
    public function response(array $errors) {
        return new JsonResponse(['request_errors' => $errors], 422);
    }
}
