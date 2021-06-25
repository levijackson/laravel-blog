<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        if ($this->user()->canManagePosts()) {
            return true;
        }
        return false;
    }

    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'body' => 'required',
            'slug' => 'unique:posts|regex:/^[A-Za-z0-9 ]+$/i'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Please add a title',
            'body.required' => 'Please add some content to the post',
            'slug.unique' => 'The URL slug has already been used'
        ];
    }
}