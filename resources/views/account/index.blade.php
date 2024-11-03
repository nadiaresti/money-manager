<?php
use App\Models\AccountGroup;

$title = 'List Account';
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
					<a class="btn btn-primary btn-sm mb-3" href="{{ route('account.create') }}">
						<i class="fa fa-plus"></i> Create Account
					</a>

					{{-- Filter Form --}}
					<form method="GET" action="{{ route('account.index') }}">
						<div class="row col-12 mb-3">
							<select name="group_id" class="form-control form-control-sm col-2 mr-2">
								<option value="">All Group</option>
								@foreach (AccountGroup::getList() as $key => $each)
									<option value="{{ $key }}" {{ request('group_id') == $key ? 'selected' : '' }}>{{ $each }}</option>
								@endforeach
							</select>
							<button type="submit" class="btn btn-outline-primary btn-sm">Search</button>
						</div>
					</form>
					{{-- End of Filter --}}

					{{-- Data List --}}
					<table id="example2" class="table table-bordered table-hover" width="100%">
						<thead>
							<tr>
								<th width="5%">No</th>
								<th width="25%">Name</th>
								<th width="15%">Group</th>
								<th width="35%">Description</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $key => $item)
								<tr>
									<td>{{ $key + 1 }}</td>
									<td>{{ $item->account_name }}</td>
									<td>{{ $item->AccountGroup->group_name }}</td>
									<td>{{ $item->account_description }}</td>
									<td class="text-center">
										<a href="{{ route('account.show', $item->account_id) }}" class="btn btn-outline-primary btn-xs mr-1">
											<i class="fa fa-eye"></i> View</a>
										<a href="{{ route('account.edit', $item->account_id) }}" class="btn btn-outline-primary btn-xs mr-1">
											<i class="fa fa-pen"></i> Edit</a>
										<form action="{{ route('account.destroy', $item->account_id) }}" method="POST" style="display:inline;">
											@csrf
											@method('DELETE')
											<button type="submit" onclick="return confirm('Are you sure you want to delete this account?')" class="btn btn-outline-primary btn-xs">
												<i class="fa fa-trash"></i> Delete
											</button>
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					{{ $data->links('pagination::custom') }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection