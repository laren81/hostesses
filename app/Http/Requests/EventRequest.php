<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
    public function rules()
    {
        $rules = [    
            'client_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'region_id' => 'required_if:internal_location,1',
            'city_id' => 'required_if:internal_location,1',
            'internal_location' => 'required',
            'external_city' => 'required_if:internal_location,2',
            'location' => 'required|string|max:255',
            'date_from' => 'required|date_format:d.m.Y|before_or_equal:date_to',
            'date_to' => 'required|date_format:d.m.Y',
            'time_from' => 'required',
            'time_till' => 'required',
            'positions.1.staff_type' => 'required|integer',
            'positions.1.staff_number' => 'required|integer',
            'positions.1.staff_gender' => 'required|integer',
            'positions.1.height_from' => 'nullable|integer',
            'positions.1.height_to' => 'nullable|integer',
            'positions.1.size_from' => 'nullable|integer',
            'positions.1.size_to' => 'nullable|integer',
            'positions.1.language_1' => 'nullable|string',
            'positions.1.language_1_lvl' => 'nullable|required_if:positions.1.language_1,!=,""|integer',
            'positions.1.language_2' => 'nullable|string',
            'positions.1.language_2_lvl' => 'nullable|required_if:positions.1.language_2,!=,""|integer',
            'positions.1.language_3' => 'nullable|string',
            'positions.1.language_3_lvl' => 'nullable|required_if:positions.1.language_3,!=,""|integer',
            'positions.1.job_description' => 'required|string|max:255',
            'positions.1.outfit' => 'nullable|string|max:255',
            'positions.1.other_comments' => 'nullable|string|max:255',
        ];
        
        return $rules;
    }

}
