<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'title' => 'required|integer',
            'company_name' => 'required|string',
            'street' => 'required|string',
            'house_number' => 'required|string',
            'city_id' => 'required|integer',
            'region_id' => 'required|integer',
            'website' => 'nullable|string'
        ];
        
        if(!auth()->check() || (auth()->user()->role_id==3 && auth()->user()->profile_completed==0)){
            $rules['terms_agreed'] = 'required|integer';
        }
        
        if(!auth()->check() || auth()->user()->role_id==1 || (auth()->user()->role_id==3 && auth()->user()->profile_completed==1)){ 
            $rules['first_name'] = 'required|string|max:255';
            $rules['last_name'] = 'required|string|max:255';
            $rules['phone'] = 'required|string|max:255';
        }
        
        if(!$this->user_id && !auth()->check()){
            $rules['email'] = 'required|email|string|max:255|unique:users,email,NULL,id,deleted_at,NULL';
        }
        else if($this->user_id){
            $rules['email'] = 'required|email|max:255|unique:users,email,'.$this->user_id.',id,deleted_at,NULL';
        }
        
        if(!auth()->check()){
            $rules['name'] = 'required|string|max:255';
            $rules['event_region_id'] = 'required|integer';
            $rules['event_city_id'] = 'required|integer';
            $rules['location'] = 'required|string|max:255';
            $rules['date_from'] = 'required|date_format:d.m.Y|before:date_to';
            $rules['date_to'] = 'required|date_format:d.m.Y';
            $rules['time_from'] = 'required';
            $rules['time_till'] = 'required';
            $rules['positions.1.staff_type'] = 'required|integer';
            $rules['positions.1.staff_number'] = 'required|integer';
            $rules['positions.1.staff_gender'] = 'required|integer';
            $rules['positions.1.height_from'] = 'nullable|integer';
            $rules['positions.1.height_to'] = 'nullable|integer';
            $rules['positions.1.size_from'] = 'nullable|integer';
            $rules['positions.1.size_to'] = 'nullable|integer';
            $rules['positions.1.language_1'] = 'nullable|string';
            $rules['positions.1.language_1_lvl'] = 'nullable|integer';
            $rules['positions.1.language_2'] = 'nullable|string';
            $rules['positions.1.language_2_lvl'] = 'nullable|integer';
            $rules['positions.1.language_3'] = 'nullable|string';
            $rules['positions.1.language_3_lvl'] = 'nullable|integer';
            $rules['positions.1.job_description'] = 'required|string|max:255';
            $rules['positions.1.outfit'] = 'nullable|string|max:255';
            $rules['positions.1.other_comments'] = 'nullable|string|max:255';            
        }
        
        return $rules;
    }
    
    public function messages(){
        return [
            'email.unique' => 'Този И-мейл вече е зает',
            'password.regex' => 'Паролата трябва да съдържа малка буква, голяма буква и цифра',
        ];
    }
}
