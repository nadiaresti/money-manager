<?php
use App\models\Transaction;
use App\models\Category;
use App\Helpers\GeneralHelper;

$title = 'List Transaction';
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
					<div class="col-12">
						<a class="btn btn-primary btn-sm mb-3" href="{{ route('transaction.create') }}">
							<i class="fa fa-plus"></i> Create Transaction
						</a>

						{{-- Filter Form --}}
						<form method="GET" action="{{ route('transaction.index') }}">
							<div class="row col-12 mb-3">
								<input type="date" name="start_date" class="form-control form-control-sm col-2 mr-2" value="{{ request('start_date') }}">
								<input type="date" name="end_date" class="form-control form-control-sm col-2 mr-2" value="{{ request('end_date') }}">
								<select name="trans_type" class="form-control form-control-sm col-2 mr-2">
									<option value="">All Type</option>
									@foreach (Transaction::listType() as $key => $each)
										<option value="{{ $key }}" {{ request('trans_type') == $key ? 'selected' : '' }}>{{ $each }}</option>
									@endforeach
								</select>
								<select name="category_id" class="form-control form-control-sm col-2 mr-2">
									<option value="">All Category</option>
									@foreach (Category::getList() as $key => $each)
										<option value="{{ $key }}" {{ request('category_id') == $key ? 'selected' : '' }}>{{ $each }}</option>
									@endforeach
								</select>
								<button type="submit" class="btn btn-outline-primary btn-sm">Search</button>
							</div>
						</form>
						{{-- End of Filter --}}

						{{-- Data List --}}
						<div class="row col-12">
							<table class="table table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th width="5%">No</th>
										<th width="10%">Date</th>
										<th width="10%">Type</th>
										<th width="15%">Category</th>
										<th width="20%">Account</th>
										<th width="15%">Amount</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@foreach ($data as $key => $item)
										<tr>
											<td>{{ $key + 1 }}</td>
											<td>{{ GeneralHelper::formatDate($item->trans_date) }}</td>
											<td>{{ Transaction::listType()[$item->trans_type] }}</td>
											<td>{{ $item->category->category_name }}</td>
											<td>{{ $item->account->account_name }}</td>
											<td>{{ GeneralHelper::formatMoney($item->trans_amount) }}</td>
											<td class="text-center">
												<a href="{{ route('transaction.show', $item->trans_id) }}" class="btn btn-outline-primary btn-xs mr-1">
													<i class="fa fa-eye"></i> View</a>
												<a href="{{ route('transaction.edit', $item->trans_id) }}" class="btn btn-outline-primary btn-xs mr-1">
													<i class="fa fa-pen"></i> Edit</a>
												<form action="{{ route('transaction.destroy', $item->trans_id) }}" method="POST" style="display:inline;">
													@csrf
													@method('DELETE')
													<button type="submit" onclick="return confirm('Are you sure you want to delete this transaction?')" class="btn btn-outline-primary btn-xs">
														<i class="fa fa-trash"></i> Delete
													</button>
												</form>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>

						{{ $data->links('pagination::custom') }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection