<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostKeyRequest extends FormRequest
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
        return [
            'key'=>'required'
        ];
    }
    public function messages()
    {
        return[
          'key.required'=>'test'
        ];
    }
    public function BackJson($Error,$Content)
    {
        json_encode([
            'Error'=>$Error ,
            'Content'=>$Content
        ],JSON_UNESCAPED_UNICODE);
    }
}
