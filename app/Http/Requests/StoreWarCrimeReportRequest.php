<?php

namespace App\Http\Requests;

use App\Rules\MaxVideoDuration;
use Illuminate\Foundation\Http\FormRequest;

class StoreWarCrimeReportRequest extends FormRequest
{
    public function authorize()
    {
        return true; // السماح للجميع بإرسال البلاغات
    }

    public function rules()
    {
        return [
            'governorate' => 'required|string|max:255',
            'exact_location' => 'required|string',
            'crime_types' => 'required|json',
            'importance' => 'required|in:critical,important,supportive',
            'evidence_file' => ['nullable', 'file', 'mimes:jpeg,png,mp4,webm', 'max:51200', new MaxVideoDuration()],
            'crime_date' => 'nullable|date',
            'crime_time' => 'nullable|date_format:H:i',
            'target_organizations' => 'required|json',
        ];
    }

    public function messages()
    {
        return [
            'governorate.required' => 'المحافظة مطلوبة.',
            'exact_location.required' => 'وصف الموقع مطلوب.',
            'crime_types.required' => 'يجب اختيار نوع الجريمة على الأقل.',
        ];
    }
}