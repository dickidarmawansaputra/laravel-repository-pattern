<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class InvoiceStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'int|required',
            'amount' => 'int|required|max:16',
            'note' => 'string|max:255',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json([
            'code' => Response::HTTP_BAD_REQUEST,
            'status' => Response::$statusTexts[Response::HTTP_BAD_REQUEST],
            'message' => $validator->errors(),
            'data' => []
        ])));
    }
}
