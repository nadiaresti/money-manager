<?php
use App\models\Category;

$title = $category->category_name;
$breadcrumbs = [
	['label' => 'Home', 'url' => url('/')],
	['label' => 'Category', 'url' => route('category.index')],
	['label' => $category->category_name, 'url' => '#'],
];
?>

@extends('layouts.main')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card card-primary card-outline">
				<div class="card-header">
					<h3 class="card-title">Detail: {{ $title }}</h3>
				</div>
				<div class="card-body pl-3">
					<table class="table table-bordered table-sm">
						<tbody>
							<tr>
								<td width="20%">Name</td>
								<td>{{ $category->category_name }}</td>
							</tr>
							<tr>
								<td>Type</td>
								<td>{{ Category::listType()[$category->category_type] }}</td>
							</tr>
							<tr>
								<td>Parent</td>
								<td>{{ ($category->parent) ? $category->parent->category_name : '-' }}</td>
							</tr>
							<tr>
								<td>Last Update</td>
								<td>{{ $category->lastUpdate() }}</td>
							</tr>
						</tbody>
					</table>
					<br>

					<a class="btn btn-sm btn-warning mr-1" href="{{ route('category.edit', $category->category_id) }}">
						<i class="fa fa-pen"></i> Edit
					</a>
					@if ($category->isDeletable())
						<form action="{{ route('category.destroy', $category->category_id) }}" method="POST" style="display:inline;">
							@csrf
							@method('DELETE')
							<button type="submit" onclick="return confirm('Are you sure you want to delete this category?')" class="btn btn-danger btn-sm">
								<i class="fa fa-trash"></i> Delete
							</button>
						</form>
					@endif
					<br><br>

					@if ($category->children()->exists())
					<h5>List Children</h5>
					<table class="table table-bordered table-sm w-50">
						<thead class="table-dark">
							<tr>
								<th style="width: 10%">No</th>
								<th style="width: 25%">Name</th>
								<th>Type</th>
								<th>Last Update</th>
								{{-- <th></th> --}}
							</tr>
						</thead>
						<tbody>
							@foreach ($category->children as $key => $item)
								<tr>
									<td>{{ $key + 1 }}</td>
									<td>{{ $item->category_name }}</td>
									<td>{{ Category::listType()[$item->category_type] }}</td>
									<td>{{ $item->lastUpdate() }}</td>
									{{-- <td class="text-center w-3">
										<a href="{{ route('category.show', $item->category_id) }}" class="btn btn-info btn-xs">
											<i class="fa fa-eye"> View</i>
										</a>
									</td> --}}
								</tr>
							@endforeach
						</tbody>
					</table>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection