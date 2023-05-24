@extends('layouts.app', [
  'pageTitle' => 'Dashboard',
  'header' => [
    'icon' => 'fa-tachiometer-alt',
    'text' => 'Dashboard'
  ]
])

@section('content')
<div class="container-fluid">
  <ul id="tickets-per-status" class="list-group list-group-horizontal-sm">
    <li class="list-group-item">Cras justo odio</li>
    <li class="list-group-item">Dapibus ac facilisis in</li>
    <li class="list-group-item">Morbi leo risus</li>
  </ul>
</div>


