@extends('layouts.app', [
  'pageTitle' => 'Manage Roles',
  'header' => [
    'icon' => 'fa-scroll',
    'text' => 'Roles'
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
          <span data-toggle="tooltip" data-placement="right" title="New Ticket">
            <a href="{{ route('manage.roles.create') }}" class="btn btn-light border">
              <i class="fa fa-plus"></i>
            </a>
          </span>
        </div>
      </div>
    </div>
    <table class="table table-striped table-hover" style="width:100%">
      <thead>
        <tr>
          <th>Role</th>
          <th>Display Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach($roles as $role)
        <tr>
          <td>
            <a href="{{ route('manage.roles.show', [ 'id' => $role->id ])}}">
              {{$role->name}}
            </a>
          </td>
          <td>
                {{$role->display_name}}
          </td>
          <td class="row-actions">
            <a href="{{ route('manage.roles.show', [ 'id' => $role->id ])}}" class="btn btn-sm" data-toggle="tooltip" data-placement="right" title="View role Details">
              <i class="fa fa-eye"></i>
            </a>
            <a href="{{ route('manage.roles.edit', [ 'id' => $role->id ])}}" class="btn btn-sm" data-toggle="tooltip" data-placement="right" title="Edit role Details">
              <i class="fa fa-edit"></i>
            </a>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('js/modules/manage/roles.js') }}" ></script>
@endpush
