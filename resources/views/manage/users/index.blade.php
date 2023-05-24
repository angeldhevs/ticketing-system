@extends('layouts.app', [
  'pageTitle' => 'Manage Users',
  'header' => [
    'icon' => 'fa-users',
    'text' => 'Users'
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
            <a href="{{ route('manage.users.create') }}" class="btn btn-light border">
              <i class="fa fa-plus"></i>
            </a>
          </span>
        </div>
      </div>
    </div>
    <table class="table table-striped table-hover" style="width:100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>Role</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach($users as $user)
        <tr>
          <td>
            <a href="{{ route('manage.users.show', [ 'id' => $user->id ])}}">
              {{$user->name}}
            </a>
            <br />
            <small class="text-muted">
              {{$user->email}}
            </small>
          </td>
          <td>
              {{ implode($user->roles->pluck('display_name')->toArray()) }}
          </td>
          <td class="row-actions">
            <a href="{{ route('manage.users.show', [ 'id' => $user->id ])}}" class="btn btn-sm" data-toggle="tooltip" data-placement="right" title="View User Details">
              <i class="fa fa-eye"></i>
            </a>
            <a href="{{ route('manage.users.edit', [ 'id' => $user->id ])}}" class="btn btn-sm" data-toggle="tooltip" data-placement="right" title="Edit User Details">
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
<script type="text/javascript" src="{{ asset('js/modules/manage/users.js') }}" ></script>
@endpush
