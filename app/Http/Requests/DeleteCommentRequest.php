<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCommentRequest extends FormRequest
{
    public function rules()
    {
        return [];
    }

    public function authorize()
    {
        if ($this->user()->canManagePosts()) {
            return true;
        }
        return false;
    }
}
