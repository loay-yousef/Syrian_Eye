<?php

namespace App\Http\Requests;

use App\Rules\MaxVideoDuration;
use Illuminate\Foundation\Http\FormRequest;

class StoreTunnelReportRequest extends FormRequest
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
            'location_type' => 'required|in:tunnel,bunker,headquarters,warehouse',
            'evidence_file' => ['nullable', 'file', 'mimes:jpeg,png,mp4,webm', 'max:51200', new MaxVideoDuration()],
            'length' => 'nullable|numeric|min:0|max:1000',
            'width' => 'nullable|numeric|min:0|max:100',
            'depth' => 'nullable|numeric|min:0|max:100',
            'entrances' => 'nullable|integer|min:0|max:10',
            'construction_type' => 'nullable|in:natural,simple,reinforced,advanced,unknown',
            'purpose' => 'required|in:storage,living,command,production,unknown',
            'security_level' => 'nullable|in:none,light,medium,heavy,fortified',
            'discovery_date' => 'nullable|date',
            'duration' => 'required|in:recent,medium,long,unknown',
        ];
    }

    public function messages()
    {
        return [
            'governorate.required' => 'المحافظة مطلوبة.',
            'exact_location.required' => 'وصف الموقع مطلوب.',
            'location_type.required' => 'نوع الموقع مطلوب.',
        ];
    }
}