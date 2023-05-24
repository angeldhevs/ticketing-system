<?php

namespace App\Http\Requests\TicketStatus;

use App\Http\Requests\ApiRequest;

class UpdateTicketStatusRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasRole('admin', 'team_leader');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status_id' => [
                'required'
            ],
        ];
    }

    public function messages()
    {
        return [
            'status_id.required' => 'Status is required'
        ];
    }
}
