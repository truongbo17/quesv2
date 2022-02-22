<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminAddQuestion extends FormRequest
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
            'title' => ['required', 'min:10', 'max:250'],
            'status' => ['required'],
            'user_id' => ['required'],
            'category_id' => ['required'],
            'imageQuestion' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Please fill to title',
            'title.min' => 'The title must be at least 10 characters !',
            'title.max' => 'The title must be at least 250 characters !',
            'status.required' => 'Please fill to status',
            'user_id.required' => 'Please fill to auth',
            'category_id.required' => 'Please fill to category',
            'imageQuestion.required' => 'Please fill to image',
        ];
    }
}
