<?php

namespace App\Http\Requests;

use App\Rules\MaxVideoDuration;
use Illuminate\Foundation\Http\FormRequest;

class StoreWeaponReportRequest extends FormRequest
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
    
    public function rules()
    {
        return [
            'governorate' => 'required|string|in:دمشق,ريف دمشق,حلب,حمص,حماة,اللاذقية,طرطوس,درعا,السويداء,إدلب,الحسكة,دير الزور,الرقة,القامشلي',
            'exactLocation' => 'required|string|max:1000',
            'lat' => 'nullable|numeric|min:-90|max:90',
            'lng' => 'nullable|numeric|min:-180|max:180',
            'weaponType' => 'nullable|string|in:light,heavy,explosives,unknown',
            'activity' => 'nullable|string|in:storage,selling,smuggling,manufacturing',
            'description' => 'nullable|string|max:2000',
            'date' => 'nullable|date|before_or_equal:today',
            'time' => 'nullable|date_format:H:i',
            'ongoing' => 'required|in:yes,no',
            'evidenceFile' => ['nullable', 'file', 'mimes:jpeg,png,jpg,mp4,webm', 'max:51200', new MaxVideoDuration()],
            'evidenceDescription' => 'nullable|string|max:500',
        ];
    }
    
    // تحويل 'yes/no' إلى boolean
    public function prepareForValidation()
    {
        if ($this->ongoing === 'yes') {
            $this->merge(['is_ongoing' => true]);
        } elseif ($this->ongoing === 'no') {
            $this->merge(['is_ongoing' => false]);
        }
    }
}
