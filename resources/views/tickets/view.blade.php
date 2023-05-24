@php
$status_context = ['secondary', 'primary', 'info', 'danger', 'warning', 'success'];
$severity_context = ['secondary', 'info', 'primary', 'warning', 'danger'];
$severity_color = $severity_context[$ticket->severity->id - 1];
$status_color = $status_context[$ticket->status->id - 1];
@endphp

@extends('layouts.app', [
  'pageTitle' => 'Ticket '.$ticket->ticket_number,
  'header' => [
    'text' => 'Ticket Details',
    'icon' => ' fa-ticket-alt'
  ],
  'buttons' => [
    'edit' => [
      'toggle' => 'modal',
      'target' => '#modalUpdateTicket',
      'icon' => 'fa-edit',
      'includeIf' => Auth::user()->hasRole('agent') && $ticket->status->name <> "Closed"
    ]
  ],
  'wrapperClass' => 'ticket-view'
])

@section('content')
<div class="container-fluid mt-2">
  <div class="row ticket-title">
    <div class="col col-sm-12">
      <h5>
        <strong class="badge badge-{{ $severity_color }}">
          {{ $ticket->ticket_number }}
        </strong>
        {{ $ticket->ticket_title }}
      </h5>
    </div>
    <hr />
  </div>
  <div class="row p-1">
    <div class="col col-sm-12 col-md-6">
      @include('components.display-field', [
        'wrapper' => [ 'class' => 'text-muted' ],
        'label' => [ 'name' => 'Source' ],
        'value' => [ 'val' => $ticket->source->name ]
      ])
    </div>
    <div class="col col-sm-12 col-md-6">
      @include('components.display-field', [
        'wrapper' => [ 'class' => 'text-muted' ],
        'label' => [ 'name' => 'Created' ],
        'value' => [ 'val' => $ticket->created_at->diffForHumans() ]
      ])
    </div>
  </div>
  <div class="row p-1">
    <div class="col col-sm-12 col-md-6">
      @include('components.display-field', [
        'wrapper' => [ 'class' => 'text-muted' ],
        'label' => [ 'name' => 'Assignee' ],
        'value' => [ 'val' => $ticket->assignee !== null ? $ticket->assignee->name  : '- Not assigned -' ]
      ])
    </div>
    <div class="col col-sm-12 col-md-6">
      @include('components.display-field', [
        'wrapper' => [ 'class' => 'text-muted' ],
        'label' => [ 'name' => 'Assigned by' ],
        'value' => [ 'val' => $ticket->reporter !== null ? $ticket->reporter->name : '- Not assigned -' ]
      ])
    </div>
  </div>
  <div class="row p-1">
    <div class="col col-sm-12 col-md-6">
      @include('components.display-field', [
        'wrapper' => [ 'class' => 'text-muted' ],
        'label' => [ 'name' => 'Severity' ],
        'value' => [
          'val' => '
            <span class="p-2 badge badge-'.$severity_color.'">'
              .$ticket->severity->name.
            '</span>',
          'is_html' => true
        ]
      ])
    </div>
    <div class="col col-sm-12 col-md-6">
      @include('components.display-field', [
        'wrapper' => [ 'class' => 'text-muted' ],
        'label' => [ 'name' => 'Status' ],
        'value' => [
          'val' => '
            <span class="p-2 badge badge-'.$status_color.'">'
              .$ticket->status->name.
            '</span>',
          'is_html' => true
        ]
      ])
    </div>
  </div>
  <div class="row p-1">
    <div class="form-group col-sm-12 text-muted">
      <strong>Details:</strong>
      <textarea id="ticket_details" class="form-control-plaintext readonly" readonly name="ticket_details" rows="5">{{$ticket->ticket_details}}</textarea>
    </div>
  </div>
  <div class="row">
    <div class="col col-sm-12 col-md-8">
    @include('tickets.comments.comment-section', [ 
      'ticket_id' => $ticket->id,
      'ticket_comments' => $ticket->comments 
    ])
    </div>
    <div class="col col-sm-12 col-md-4">
    @include('tickets.activity', [ 
      'ticket_activities' => $ticket->activities 
    ])
    </div>
  </div>
</div>

@include('tickets.edit', [ 'ticket_status' => $ticket_status ])
@if(Auth::user()->hasRole('admin') && $ticket->current() == null)
@include('tickets.assign', [ 'agents' => $agents ])
@endif
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('js/modules/tickets.js') }}" ></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ticket-module.css') }}" rel="stylesheet">
@endpush