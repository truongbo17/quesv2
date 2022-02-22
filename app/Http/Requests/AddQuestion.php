<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddQuestion extends FormRequest
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

    public function rules()
    {
        return [
            'title' => ['required', 'min:10'],
            'category_id' => ['required'],
            'imageQuestion' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Please fill to title',
            'title.min' => 'The title must be at least 10 characters !',
            'category_id.required' => 'Please fill to category',
            'imageQuestion.required' => 'Please fill to image',
        ];
    }
}
