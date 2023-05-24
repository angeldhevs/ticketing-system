<?php

namespace App\Http\Requests\Tickets;

use App\Http\Requests\ApiRequest;
use Illuminate\Support\Facades\Auth;

class CreateTicketRequest extends ApiRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    // $user = $this->user() ?? $this->guard('api')->user();
    // return $user->hasRole('admin', 'team_leader');
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
      ]
    ];
  }

  public function messages()
  {
    return [
      'ticket_title.requred' => 'Title is required',
      'client_name.required' => 'Client name is required',
      'client_email.required' => 'Client email is required'
    ];
  }
}
