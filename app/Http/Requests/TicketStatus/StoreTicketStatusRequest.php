<?php

namespace App\Http\Requests\TicketStatus;

use App\Http\Requests\ApiRequest;
use Illuminate\Database\Eloquent\Model;

class StoreTicketStatusRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'max:255'
            ],
            'description' => [
                'max:255'
            ],
        ];
    }
}
