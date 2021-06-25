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
        $rules = [
            'title' => 'required|max:255',
            'body' => 'required',
            'slug' => 'unique:posts|regex:/^[A-Za-z0-9- ]+$/i',
            'metaTitle' => 'max:255',
            'metaDescription' => 'max:255'
        ];

        if ($this->method() === 'PUT') {
            // this ensures that an existing post still requires a slug, but that
            // it doesn't validate against itself and trigger an error!
            $rules['slug'] = 'unique:posts,title,' . $this->get('slug') . '|regex:/^[A-Za-z0-9\- ]+$/i';
        }

        return $rules;
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