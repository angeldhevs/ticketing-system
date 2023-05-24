@php
@endphp

@extends('layouts.app', [
'pageTitle' => 'View Role',
'header' => [
'text' => 'Role Details',
'icon' => 'fa-scroll',
'buttons' => [
'edit' => [
'icon' => 'fa-edit',
'href' => route('manage.roles.edit', [ 'id' => $role->id ])
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
          'val' => $role->name,
          'class' => 'col col-sm-12 col-md-8'
          ]
          ])
        </div>
      </div>
      <!-- Display -->
      <div class="row p-1 mb-md-2">
        <div class="col col-sm-12">
          @include('components.display-field', [
          'label' => [
          'element' => 'span',
          'name' => 'Display',
          'class' => 'text-md-right col col-sm-12 col-md-4',
          ],
          'value' => [
          'val' => $role->display_name,
          'class' => 'col col-sm-12 col-md-8'
          ]
          ])
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
