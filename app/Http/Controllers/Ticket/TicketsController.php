<?php

namespace App\Http\Controllers;

use App\Models\Ticket\TicketActivity;
use App\Models\Ticket\TicketStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket\Ticket;
use App\Models\Manage\User;
use App\Models\Manage\Role;
use App\Models\Ticket\TicketSource;
use App\Models\Ticket\TicketSeverity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Tickets\CreateTicketRequest;
use App\Http\Requests\Tickets\AssignTicketRequest;

class TicketsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = $this->user();
        $data = [
          'title' => 'All Tickets',
          'source_id' => TicketSource::where('name', 'Created')->first()->id,
          'reporter_id' => $user->id,
          'reporter_name' => $user->name
        ];

        // if($user->hasRole('admin', 'team_leader')) {
        //     $data['title'] = 'All Tickets';
        // } else {
        //     $data['title'] = 'My Tickets';
        // }

        return view('tickets.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $data = [
            'reporter_id' => Auth::user()->id,
            'source_id' => TicketSource::where('name', 'Team Leader')->first()->id,
            'severities' => TicketSeverity::all()->toArray(),
            'agents' => Role::with('users')->where('name', 'Agent')->get()->toArray()
        ];

        return view("tickets.create")->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Tickets\CreateTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTicketRequest $request) {
        $ticket = Ticket::create($request->all());
        return redirect()->route('tickets.show', [ 'id' => $ticket->id ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agents = Role::with('users')->where('name', 'Agent')->get()->toArray();
        $data = [
            'ticket' => Ticket::find($id),
            'ticket_status' =>  TicketStatus::all(),
            'agents' => $agents[0]['users'],
            'severities' => TicketSeverity::all()
        ];

        return view('tickets.view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'ticket' => Ticket::find($id),
            'ticket_status' =>  TicketStatus::all(),
            'severities' => TicketSeverity::all()->toArray(),
            'agents' => Role::with('users')->where('name', 'Agent')->get()->toArray()
        ];

        return view('tickets.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        TicketActivity::create([
            'ticket_id'         => $request['ticket_id'],
            'status_id'         => $request['status_id'],
            'assignee_id'        => $request['assignee_id'],
            'reporter_id'       => $request['reported_id'],
            'remarks'           => $request['remarks'],
        ]);

        return 0;
    }

    /**
     * Assigns the specified ticket to an agent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assign(AssignTicketRequest $request, $id) {
        DB::transaction(function() use ($request, $id) {
            $ticket = Ticket::find($id);

            TicketActivity::create([
                'ticket_id' => $ticket->id,
                'status_id' => TicketStatus::where('name', 'Open')->first()->id,
                'assignee_id' => $request['agent_id'],
                'reporter_id' => Auth::user()->id,
                'remarks' => $request['ticket_details']
            ]);

            return redirect()->route('tickets.show', [ 'id' => $ticket->id ]);
        });

        TicketActivity::create([
            'ticket_id' => $request['ticket_id'],
            'status_id' => $request['status_id'],
            'assignee_id' => $request['assignee_id'],
            'reporter_id' => $request['reported_id'],
            'remarks' => $request['remarks'],
        ]);
        return redirect()->route('tickets.show', [ 'id' => $id ]);
    }

    public function assigned(Request $request)
    {
        TicketActivity::create([
            'ticket_id' => $request['ticket_id'],
            'status_id' => $request['status_id'],
            'assignee_id' => $request['assignee_id'],
            'reporter_id' => Auth::user()->getAuthIdentifier(),
        ]);
        Ticket::find($request['ticket_id'])->update([
            'severity_id' => $request['severity_id']
        ]);

        return 0;
    }

    public function inboundEmail(Request $request)
    {
        TicketActivity::create([
            'ticket_id' => 1,
            'status_id' => 1,
            'assignee_id' => 2,
            'reporter_id' => 2,
            'remarks' => 'qwqwqwqwqw',
        ]);
    }
}
