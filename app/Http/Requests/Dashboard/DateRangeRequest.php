<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\ApiRequest;

class DateRangeRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from' => 'required|date|before_or_equal:to',
            'to' => 'required|date|after_or_equal:from'
        ];
    }
}
