<?php

namespace App\Http\Requests\Tickets;

use App\Http\Requests\ApiRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTicketRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return $this->user()->hasRole('admin', 'team_leader');
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ticket_title' => [
                'required',
                'max:255'
            ],
            'client_name' => [
                'required'
            ],
            'client_email' => [
                'required'
            ],
            'severity_id' => [
                'required'
            ],
            'assignee_id' => [
                'required'
            ],
        ];
    }

    public function messages()
    {
        return [
            'ticket_title.requred' => 'Title is required',
            'client_name.required' => 'Client name is required',
            'client_email.required' => 'Client email is required',
            'severity_id.required' => 'Severity is required',
            'assignee_id.required' => 'Asignee is required'
        ];
    }
}
