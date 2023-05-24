<?php

namespace App\Http\Requests\TicketComments;

use App\Http\Requests\ApiRequest;

class StoreTicketCommentRequest extends ApiRequest
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
            'comment' => 'required',
            'parent_comment_id', 'int'
        ];
    }

    public function messages() {
        return [
            'comment.required' => 'Comment is required',
        ];
    }
}
