<?php
use App\models\Transaction;
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
					<a class="btn btn-primary btn-sm mb-3" href="{{ route('transaction.create') }}">
						<i class="fa fa-plus"></i> Create Transaction
					</a>
					<table id="example2" class="table table-bordered table-hover" width="100%">
						<thead>
							<tr>
								<th width="5%">No</th>
								<th width="10%">Date</th>
								<th width="15%">Type</th>
								<th width="15%">Category</th>
								<th width="15%">Amount</th>
								<th width="20%">Remark</th>
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
									<td>{{ GeneralHelper::formatMoney($item->trans_amount) }}</td>
									<td>{{ $item->trans_remark }}</td>
									<td class="text-center">
										<a href="{{ route('transaction.show', $item->trans_id) }}" class="btn btn-info btn-xs mr-1">
											<i class="fa fa-eye"></i> View</a>
										{{-- <a href="{{ route('transaction.edit', $item->trans_id) }}" class="btn btn-warning btn-xs mr-1">
											<i class="fa fa-pen"></i> Edit</a> --}}
										<form action="{{ route('transaction.destroy', $item->trans_id) }}" method="POST" style="display:inline;">
											@csrf
											@method('DELETE')
											<button type="submit" onclick="return confirm('Are you sure you want to delete this transaction?')" class="btn btn-danger btn-xs">
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