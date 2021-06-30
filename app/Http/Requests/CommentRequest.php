<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize()
    {
        if ($this->user() && $this->user()->id > 0) {
            return true;
        }
        return false;
    }

    public function rules()
    {
        return [
            'comment' => 'required|string',
            'post_id' => 'required|integer'
        ];
    }
}