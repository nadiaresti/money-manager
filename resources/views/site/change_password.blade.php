<?php
$title = '';
?>

@extends('layouts.main')
@section('content')
<div class="card w-25 m-auto">
    <div class="card-body login-card-body">
      <div class="login-logo">
        <b>Change Password</b>
      </div>
      @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @elseif (session()->has('success-password'))
        <div class="alert alert-success" role="alert">
          <strong>Success!</strong> {!! session()->get('success-password') !!}
        </div>
      @endif

      <form action="{{ route('password.update') }}" method="post" onsubmit="return confirm('Are you sure?')">
        @csrf
        <div class="form-group mb-3">
          <input type="password" class="form-control" placeholder="Current Password" name="current_password" required>
        </div>
        <div class="form-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="new_password" required>
        </div>
        <div class="form-group mb-3">
          <input type="password" class="form-control" placeholder="Confirm Password" name="new_password_confirmation" required>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Change password</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection