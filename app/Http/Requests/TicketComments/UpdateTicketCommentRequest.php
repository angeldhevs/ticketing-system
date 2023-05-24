<?php

namespace App\Http\Requests\TicketComments;

use App\Http\Requests\ApiRequest;

class UpdateTicketCommentRequest extends ApiRequest
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
            'comment_id' => 'required',
            'comment' => 'required'
        ];
    }

    public function messages() {
        return [
            'comment_id' => 'Comment id is required',
            'comment.required' => 'Comment is required',
        ];
    }
}
