<?php

declare(strict_types=1);

namespace App\Http\Requests\Lead;

use Illuminate\Foundation\Http\FormRequest;

final class StoreTradeInLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],

            'make' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1900', 'max:' . ((int)date('Y') + 1)],
            'mileage' => ['required', 'integer', 'min:0'],
            'condition' => ['nullable', 'string', 'max:255'],
            'vin' => ['nullable', 'string', 'max:32'],

            'message' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
