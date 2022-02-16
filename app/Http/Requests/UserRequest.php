<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if(!$this->id){
            return [
                'first_name' => 'required|string|max:255', 
                'last_name' => 'required|string|max:255', 
                'email' => 'required|email|string|max:255|unique:users,email,NULL,id,deleted_at,NULL',
                'role_id' => 'required'
            ];
        }
        else{
            return [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'role_id' => 'required'
            ];
        }
    }
    
    public function messages(){
        return [
            'email.unique' => 'Този И-мейл вече е зает',
            'password.regex' => 'Паролата трябва да съдържа малка буква, голяма буква и цифра',
        ];
    }
}
