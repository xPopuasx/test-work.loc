<?php

namespace App\Http\Requests\Api\Admin\Car;

use App\Http\Requests\Api\FormRequest;
use Illuminate\Validation\Rule;

class StoreCarRequest extends FormRequest
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
            /*
            |понятно что в машине есть одинаковые номера (по хорошему внедрять свойства, модель, регион, год выпуска)
            |но в рамках данной задачи нужно предусмотреть хоть какоуюто проверку уникальности
            |так как сущность не описана в задаче, валидирую на уникальность только номер
            */
            'number' => ['required', 'string', Rule::unique('cars', 'number')->whereNull('deleted_at')],
        ];
    }
}
