<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
                'name' => 'required|string|max:255|unique:roles'
            ];
        }
        else{
            return [
                'name' => 'required|string|max:255|unique:roles,name,'.$this->id
            ];
        }
    }
    
    public function messages(){
        return [
            'name.required' => 'Полето "Име" е задължително.',
            'name.unique' => 'Вече съществува роля с такова име'
        ];
    }
}
