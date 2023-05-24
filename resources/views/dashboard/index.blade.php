@php
  $current_role = Auth::user()->roles->first()->name;
  $current_role = trim(str_replace(' ', '_', $current_role));
@endphp

@extends('layouts.app', [
  'pageTitle' => 'Dashboard',
  'header' => [
    'icon' => 'fa-tachometer-alt',
    'text' => 'Dashboard'
  ]
])

@section('content')
<div class="container-fluid">
  <div class="row mt-2">
    <div class="col col-md-12 mt-sm-2">
      @include('dashboard.charts.new-vs-closed-tickets')
    </div>
  </div>
  <div class="row">
    <div class="col col-md-12 col-lg-6 mt-sm-2">
      @include('dashboard.charts.tickets-per-status')
    </div>
    <div class="col col-md-12 col-lg-6 mt-sm-2">
      @include('dashboard.charts.tickets-per-severity')
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('js/modules/dashboard.js') }}" ></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/modules/dashboard.css') }}" rel="stylesheet">
@endpush

