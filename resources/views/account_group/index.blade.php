<?php
$title = 'List Account Group';
$breadcrumbs = [
	['label' => 'Home', 'url' => url('/')],
	['label' => $title, 'url' => '#'],
];
?>

@extends('layouts.main')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card card-primary card-outline">
				<div class="card-body">
					<a class="btn btn-primary btn-sm mb-3" href="{{ route('account-group.create') }}">
						<i class="fa fa-plus"></i> Create Account Group
					</a>
					<table id="example2" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Group Code</th>
								<th>Group Name</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $key => $item)
								<tr>
									<td>{{ $key + 1 }}</td>
									<td>{{ $item->group_code }}</td>
									<td>{{ $item->group_name }}</td>
									<td class="text-center">
										<a href="{{ route('account-group.show', $item->group_id) }}" class="btn btn-outline-primary btn-xs mr-1">
											<i class="fa fa-eye"></i> View</a>
										<a href="{{ route('account-group.edit', $item->group_id) }}" class="btn btn-outline-primary btn-xs mr-1">
											<i class="fa fa-pen"></i> Edit</a>
										<form action="{{ route('account-group.destroy', $item->group_id) }}" method="POST" class="d-inline">
											@csrf
											@method('DELETE')
											<button type="submit" onclick="return confirm('Are you sure you want to delete this account group?')" class="btn btn-outline-primary btn-xs">
												<i class="fa fa-trash"></i> Delete
											</button>
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection