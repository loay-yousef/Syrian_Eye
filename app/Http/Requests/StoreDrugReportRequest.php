<?php

namespace App\Http\Requests;

use App\Rules\MaxVideoDuration;
use Illuminate\Foundation\Http\FormRequest;

class StoreDrugReportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'governorate' => 'required|string|max:255',
            'exact_location' => 'required|string',
            'evidence_file' => ['nullable', 'file', 'mimes:jpeg,png,mp4,webm', 'max:51200', new MaxVideoDuration()],
            'drug_type' => 'nullable|in:captagon,heroin,cannabis,chemical,pills,unknown',
            'activity_type' => 'nullable|in:production,storage,distribution,smuggling,transport',
            'scale' => 'nullable|in:individual,group,network,factory',
            'frequency' => 'nullable|in:daily,weekly,monthly,random,continuous',
            'threat_level' => 'required|in:low,medium,high',
            'impact' => 'nullable|in:local,district,city,regional',
        ];
    }

    public function messages()
    {
        return [
            'governorate.required' => 'المحافظة مطلوبة.',
            'exact_location.required' => 'وصف الموقع مطلوب.',
            'threat_level.required' => 'مستوى التهديد مطلوب.',
        ];
    }
}