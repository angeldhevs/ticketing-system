@php
@endphp

@extends('layouts.app', [
  'pageTitle' => 'View User',
  'header' => [
    'text' => 'User Details',
    'icon' => 'fa-user',
    'buttons' => [
      'edit' => [
        'icon' => 'fa-edit',
        'href' => route('manage.users.edit', [ 'id' => $user->id ])
      ]
    ]
  ]
])

@section('content')
<div class="container-fluid mt-3">
  <div class="row">
    <div class="col col-sm-12 col-md-6">
      <!-- Name -->
      <div class="row p-1 mb-md-2">
        <div class="col col-sm-12">
          @include('components.display-field', [
            'label' => [
              'element' => 'span',
              'name' => 'Name',
              'class' => 'text-md-right col col-sm-12 col-md-4',
            ],
            'value' => [
              'val' => $user->name,
              'class' => 'col col-sm-12 col-md-8'
            ]
          ])
        </div>
      </div>
      <!-- Email -->
      <div class="row p-1 mb-md-2">
        <div class="col col-sm-12">
          @include('components.display-field', [
            'label' => [
              'element' => 'span',
              'name' => 'Email Address',
              'class' => 'text-md-right col col-sm-12 col-md-4',
            ],
            'value' => [
              'val' => $user->email,
              'class' => 'col col-sm-12 col-md-8'
            ]
          ])
        </div>
      </div>
      <!-- Role -->
      <div class="row p-1 mb-md-2">
        <div class="col col-sm-12">
          @include('components.display-field', [
            'label' => [
              'element' => 'span',
              'name' => 'Role',
              'class' => 'text-md-right col col-sm-12 col-md-4',
            ],
            'value' => [
              'val' => implode($user->roles->pluck('name')->toArray()),
              'class' => 'col col-sm-12 col-md-8'
            ]
          ])
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
