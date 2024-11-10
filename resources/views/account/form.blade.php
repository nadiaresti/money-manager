<?php
use App\Models\AccountGroup;

$title = isset($account) ? "Update: $account->account_name" : 'Create Account';
$breadcrumbs = [
	['label' => 'Home', 'url' => url('/')],
	['label' => 'Account', 'url' => route('account.index')],
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
      <form method="POST" action="{{ !isset($account) ? route('account.store') : route('account.update', $account->account_id) }}" class="form-horizontal">
        @csrf
        @if(isset($account))
          @method('PUT')
        @endif
        <div class="form-group row">
          <label class="col-sm-2">Group</label>
          <div class="col-sm-4">

            <select class="form-control" name="group_id">
              <option value="">Choose Group</option>
              @foreach (AccountGroup::getList() as $key => $item)
                <option value="{{ $key }}" {{ ($account->group_id ?? old('group_id')) == $key ? 'selected' : '' }}>{{ $item }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2">Name</label>
          <div class="col-sm-4">
            <input type="text" name="account_name" class="form-control" value="{{ $account->account_name ?? old('account_name') }}" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2">Description</label>
          <div class="col-sm-4">
            <input type="text" name="account_description" class="form-control" value="{{ $account->account_description ?? old('account_description') }}">
          </div>
        </div>
        <div class="form-account row">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection