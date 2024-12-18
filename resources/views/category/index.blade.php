<?php
use App\Models\Category;

$title = 'Category';
$breadcrumbs = [
	['label' => 'Home', 'url' => url('/')],
	['label' => 'Category', 'url' => '#'],
];
?>

@extends('layouts.main')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card card-primary card-outline">
				<div class="card-body">
					<a class="btn btn-primary btn-sm mb-3" href="{{ route('category.create') }}">
						<i class="fa fa-plus"></i> Create New Category
					</a>

					{{-- Filter Form --}}
					<form method="GET" action="{{ route('category.index') }}">
						<div class="row col-12 mb-3">
							<select name="category_type" class="form-control form-control-sm col-2 mr-2">
								<option value="">All Type</option>
								@foreach (Category::listType() as $key => $each)
									<option value="{{ $key }}" {{ request('category_type') == $key ? 'selected' : '' }}>{{ $each }}</option>
								@endforeach
							</select>
							<button type="submit" class="btn btn-outline-primary btn-sm">Search</button>
						</div>
					</form>
					{{-- End of Filter --}}

					<table id="example2" class="table table-bordered table-hover" width="100%">
						<thead>
							<tr>
								<th width="5%">No</th>
								<th width="25%">Name</th>
								<th width="15%">Type</th>
								<th width="35%">Parent</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($category as $key => $item)
								<tr>
									<td>{{ $key + 1 }}</td>
									<td>{{ $item->category_name }}</td>
									<td>{{ Category::listType()[$item->category_type] }}</td>
									<td>{{ ($item->parent) ? $item->parent->category_name : '-' }}</td>
									<td class="text-center">
										<a href="{{ route('category.show', $item->category_id) }}" class="btn btn-outline-primary btn-xs mr-1">
											<i class="fa fa-eye"></i> View</a>
										<a href="{{ route('category.edit', $item->category_id) }}" class="btn btn-outline-primary btn-xs mr-1">
											<i class="fa fa-pen"></i> Edit</a>
										<form action="{{ route('category.destroy', $item->category_id) }}" method="POST" style="display:inline;">
											@csrf
											@method('DELETE')
											<button type="submit" onclick="return confirm('Are you sure you want to delete this account?')" class="btn btn-outline-primary btn-xs">
												<i class="fa fa-trash"></i> Delete
											</button>
										</form>
									</td>
								</tr>
							@endforeach

							@if (empty($category->items()))
								<tr><td colspan="5"><i>Data not found</i></td></tr>
							@endif
						</tbody>
					</table>
					{{ $category->links('pagination::custom') }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection