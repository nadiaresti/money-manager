<?php
use App\models\Category;

$title = isset($category) ? "Update: $category->category_name" : 'Create Category';
$breadcrumbs = [
	['label' => 'Home', 'url' => url('/')],
	['label' => 'Category', 'url' => route('category.index')],
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
      <form method="POST" action="{{ !isset($category) ? route('category.store') : route('category.update', $category->category_id) }}" class="form-horizontal">
        @csrf
        @if(isset($category))
          @method('PUT')
        @endif
        <div class="form-group row">
          <label class="col-sm-2">Name</label>
          <div class="col-sm-4">
            <input type="text" name="category_name" class="form-control" value="{{ $category->category_name ?? old('category_name') }}" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2">Type</label>
          <div class="col-sm-4">
            <select class="form-control" name="category_type">
              <option value="">Choose Type</option>
              @foreach (Category::listType() as $key => $item)
                <option value="{{ $key }}" {{ ($category->category_type ?? old('category_type')) == $key ? 'selected' : '' }}>{{ $item }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2">Parent</label>
          <div class="col-sm-4">
            <select class="form-control" name="parent_id">
              <option value="0">Choose Parent</option>
              @foreach($categories as $item)
                <option value="{{ $item->category_id }}" {{ (!empty($category->parent_id) && ($category->parent_id == $item->category_id)) ? 'selected' : ''}}>
                    {{ $item->category_name }}
                </option>
            @endforeach
            </select>
          </div>
        </div>
        <div class="form-category row">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection