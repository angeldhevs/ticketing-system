@php
$is_admin = Auth::user()->hasRole('admin');
@endphp

@extends('layouts.app', [
  'pageTitle' => 'Tickets',
  'header' => [
    'icon' => 'fa-ticket-alt',
    'text' => 'All Tickets'
  ]
])

@section('content')
<div class="container-fluid">
  <div class="dt-wrapper">
    <div class="dt-top-bar row">
      <div class="col col-sm-12 col-md-4 order-xs-last">
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <i class="fa fa-search"></i>
            </div>
          </div>
          <input type="search" name="searh" class="form-control form-control-sm col-10" aria-controls="tickets" placeholder="Search here" />
        </div>
      </div>
      <div class="col col-sm-12 col-md-8 order-xs-first text-right">
        <div class="button-group" role="group">
        @if($is_admin || true)
          <span data-toggle="tooltip" data-placement="right" title="Create Ticket">
            <button type="button" class="btn btn-light border" data-toggle="modal" data-target="#ticket-modal" data-mode="create">
              <i class="fa fa-plus"></i>
            </button>
          </span>
          @endif
        </div>
      </div>
    </div>
    <table class="table table-striped table-hover" style="width:100%" data-source="{{ route('api.tickets.index') }}">
      <thead>
        <tr>
          <th>Ticket #</th>
          <th>Title</th>
          <th>Assigned To</th>
          <th>Status</th>
          <th>Last Update</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('js/modules/ticket.js') }}" ></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/modules/ticket.css') }}" rel="stylesheet">
@endpush
