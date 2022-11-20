<?php

namespace App\Http\Requests\Api;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    const DEFAULT_LIST_RULES = [
        'filters' => 'nullable',
        'sort_by' => 'nullable',
        'sort_direction' => 'nullable',
        'per_page' => 'nullable|integer',
    ];

    public function failedValidation($validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors(),
        ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY));
    }
}
