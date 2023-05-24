@extends('layouts.app', [
  'pageTitle' => 'Reports',
  'header' => [
    'icon' => 'fa-chart-area',
    'text' => 'Reports'
  ]
])

@section('content')
<div class="container-fluid mt-3">
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
        </div>
        <table class="table table-striped table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Assignee</th>
                    <th>
                        <span class="badge badge-success">Closed</span>
                    </th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach($agents as $agent)
                <tr>
                    <td>{{$agent->name}}</td>
                    <td>{{$agent->count_tickets()}}</td>
                    <td>{{$agent->count_tickets()}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('js/reports-module.js') }}" ></script>
@endpush
