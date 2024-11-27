<?php
use App\Models\Transaction;
use App\Helpers\GeneralHelper;

$title = 'View Transaction';
$breadcrumbs = [
	['label' => 'Home', 'url' => url('/')],
	['label' => 'Transaction', 'url' => route('transaction.index')],
	['label' => $title, 'url' => '#'],
];
?>

@extends('layouts.main')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card card-primary card-outline">
				<div class="card-header">
					<h3 class="card-title">{{ Transaction::listType()[$transaction->trans_type] }}</h3>
				</div>
				<div class="card-body row">
					<div class="col-6">
						<table class="table table-bordered table-sm w-100">
							<tbody>
								<tr>
									<td>Date</td>
									<td>{{ GeneralHelper::formatDate($transaction->trans_date) }}</td>
								</tr>
								@if (!empty($transaction->category))
								<tr>
									<td>Category</td>
									<td>{{ $transaction->category->category_name }}</td>
								</tr>
								@endif
								<tr>
									<td>Account</td>
									<td>{{ $transaction->account->account_name }}</td>
								</tr>
								@if (!empty($transaction->transfer))
								<tr>
									<td>Destination Account</td>
									<td>{{ $transaction->transfer->account->account_name ?? '' }}</td>
								</tr>
								@endif
								<tr>
									<td>Amount</td>
									<td>{{ GeneralHelper::formatMoney($transaction->trans_amount) }}</td>
								</tr>
								@if (!empty($transaction->transfer->admin_fee))
								<tr>
									<td>Fee</td>
									<td>{{ !empty($transaction->transfer) ? GeneralHelper::formatMoney($transaction->transfer->admin_fee) : 0 }}</td>
								</tr>
								@endif
								<tr>
									<td>Remark</td>
									<td>{!! nl2br($transaction->trans_remark) !!}</td>
								</tr>
								<tr>
									<td>Last Update</td>
									<td>{{ $transaction->lastUpdate() }}</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="col-6 pl-5">
						<?php $file_name = (!empty($transaction->file)) ? $transaction->file->file_name : ''; ?>
						@if (empty($transaction->file))
							<div class="col-sm-10 border d-flex align-items-center justify-content-center" style="max-width: 400px; min-height: 200px" id="preview">
								<i class="text-secondary">No preview</i>
							</div>
						@elseif ($transaction->file->file_type == 'image')
							<img src="{{ asset("storage/uploads/$file_name") }}" style="width: 400px;">
						@else
							<div class="iframe-container" style="position: relative; width: 80%; height: 300px;">
								<iframe src="{{ asset("storage/uploads/$file_name") }}" frameborder="0" style="width: 100%; height: 100%;"></iframe>
								{{-- <button class="btn btn-primary btn-mini position-absolute" id="show-file" style="left: 10%; top: 10%; transform: translate(-50%, -50%);">
									<i class="fa fa-eye"></i>
								</button> --}}
							</div>
						@endif
					</div>
					<br>

					<a class="btn btn-sm btn-warning" href="{{ route('transaction.edit', $transaction->trans_id) }}">
						<i class="fa fa-pen"></i> Edit
					</a> &nbsp;
					<a class="btn btn-sm btn-danger" href="{{ route('transaction.destroy', $transaction->trans_id) }}">
						<i class="fa fa-trash"></i> Delete
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
