<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HostessRequest extends FormRequest
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
            'preferred_occupation' => 'required|array',   
            'sex' => 'required|integer',
            'address' => 'required|string',
            'city_id' => 'required|integer',
            'region_id' => 'required|integer',
            'country' => 'required|string',
            'nationality' => 'required|string',
            'birth_date' => 'required|date',
            'type' => 'required|integer',
            'height' => 'required|integer',
            'cloth_size' => 'required|integer',
            'chest' => 'required|integer',
            'waist' => 'required|integer',
            'hips' => 'required|integer',
            'hair_color' => 'required|integer',
            'eye_color' => 'required|integer',
            'shoe_size' => 'required|integer',
            'tattoo' => 'required|integer',
            'piercing' => 'required|integer',
            'occupation' => 'required|string',
            'profession' => 'required|string',
            'education' => 'required|string',
            'driver_licence' => 'required|integer',
            'own_car' => 'required|integer',
            'trade_licence' => 'required|integer',
            'health_certificate' => 'required|integer',
            'de' => 'required|integer',
            'en' => 'required|integer',
            'sp' => 'required|integer',
            'fr' => 'required|integer',
            'other_language_1' => 'nullable|integer',
            'other_language_1_lvl' => 'nullable|integer',
            'other_language_2' => 'nullable|integer',
            'other_language_2_lvl' => 'nullable|integer',
            'other_language_3' => 'nullable|integer',
            'other_language_3_lvl' => 'nullable|integer',
            'accommodation_places' => 'required|array',
            'other_cities' => 'nullable|string',
            'modeling' => 'required|string',
            'presentation' => 'required|string',
            'gastronomy' => 'required|string',
            'team_leader' => 'required|string',
            'experience_abroad' => 'required|string',
            'musical_instrument' => 'required|string',
            'past_experience' => 'required|string',            
            'public_consent' => 'required|integer',
            'password' => 'nullable|same:password_confirmation|min:6',
        ];
        
        if(!auth()->check() || (auth()->user()->role_id==2 && auth()->user()->profile_completed==0)){
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
        
        return $rules;
    }
    
    public function messages(){
        return [
            'email.unique' => 'Този И-мейл вече е зает',
            'password.regex' => 'Паролата трябва да съдържа малка буква, голяма буква и цифра',
        ];
    }
}
