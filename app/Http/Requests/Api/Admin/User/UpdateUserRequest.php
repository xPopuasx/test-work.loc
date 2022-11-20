<?php

namespace App\Http\Requests\Api\Admin\User;

use App\Http\Requests\Api\FormRequest;
use App\Models\Car\Car;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string',
            'password' => 'nullable|string',
            'email' => ['nullable', 'string', 'email', Rule::unique('users')->ignore(Car::find(1)->id)],
            'car_id' => ['nullable', 'integer', 'exists:cars,id',
                Rule::unique('user_cars', 'car_id')->ignore($this->route()->user->id, 'carable_id'),
            ],
        ];
    }
}
