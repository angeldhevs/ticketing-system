<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket\TicketStatus;
use App\Models\Ticket\TicketSeverity;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [
            'statuses' => TicketStatus::all(),
            'severities' => TicketSeverity::all()
        ];

        return view('dashboard.index')->with($data);
    }
}
