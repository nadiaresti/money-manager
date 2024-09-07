<?php
$title = isset($accountGroup) ? "Update: $accountGroup->group_name" : 'Create Account Group';
$breadcrumbs = [
	['label' => 'Home', 'url' => url('/')],
	['label' => 'Account Group', 'url' => route('account-group.index')],
  ['label' => $title, 'url' => '#'],
];
?>

@extends('layouts.main')
@section('content')
<div class="container-fluid">
  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">{{ $title }}</h3>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ !isset($accountGroup) ? route('account-group.store') : route('account-group.edit', $accountGroup) }}" class="form-horizontal">
        @csrf
        @if(isset($accountGroup))
          @method('PUT')
        @endif
        <div class="form-group row">
          <label class="col-sm-2">Code</label>
          <div class="col-sm-4">
            <input type="text" name="group_code" class="form-control" value="{{ $accountGroup->group_code ?? old('group_code') }}" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2">Name</label>
          <div class="col-sm-4">
            <input type="text" name="group_name" class="form-control" value="{{ $accountGroup->group_name ?? old('group_name') }}" required>
          </div>
        </div>
        <div class="form-group row">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection