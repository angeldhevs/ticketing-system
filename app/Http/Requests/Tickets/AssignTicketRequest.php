<?php

namespace App\Http\Requests\Tickets;

use App\Http\Requests\ApiRequest;
use Illuminate\Support\Facades\Auth;

class AssignTicketRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
        // return $this->user()->hasRole('admin', 'team_leader');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'assignee_id' => [
                'required'
            ],
            'reporter_id' => [
                'required'
            ]
        ];
    }
}
