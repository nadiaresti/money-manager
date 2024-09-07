<?php
$title = $account->account_name;
$breadcrumbs = [
	['label' => 'Home', 'url' => url('/')],
	['label' => 'Account', 'url' => route('account.index')],
	['label' => $account->account_name, 'url' => '#'],
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
								<td>{{ $account->account_name }}</td>
							</tr>
							<tr>
								<td>Group</td>
								<td>{{ $account->accountGroup->group_name }}</td>
							</tr>
							<tr>
								<td>Description</td>
								<td>{{ $account->account_description }}</td>
							</tr>
							<tr>
								<td>Amount</td>
								<td>{{ $account->account_amount }}</td>
							</tr>
							<tr>
								<td>Last Update</td>
								<td>{{ $account->lastUpdate() }}</td>
							</tr>
						</tbody>
					</table>
					<br>

					<a class="btn btn-sm btn-warning" href="{{ route('account.edit', $account->account_id) }}">
						<i class="fa fa-pen"></i> Edit
					</a>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection