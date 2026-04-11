<?php

namespace App\Http\Requests;

use App\Data\VendorData;
use App\Models\Vendor;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VendorFormRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'name' => ['required', 'string', 'max:100'],
            'mobile' => 'sometimes|nullable|max:13',
            'address' => 'sometimes|nullable|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique(Vendor::class)->ignore($this->route('vendor')),
            ],
        ];
    }

    public function toData(): VendorData
    {
        return VendorData::from($this->validated());
    }
}
