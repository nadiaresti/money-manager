<?php
$title = $accountGroup->group_name;
$breadcrumbs = [
	['label' => 'Home', 'url' => url('/')],
	['label' => 'Account Group', 'url' => route('account-group.index')],
	['label' => $accountGroup->group_name, 'url' => '#'],
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
					<table class="table table-bordered table-sm w-50">
						<tbody>
							<tr>
								<td width="20%">Name</td>
								<td>{{ $accountGroup->group_code }}</td>
							</tr>
							<tr>
								<td>Group</td>
								<td>{{ $accountGroup->group_name }}</td>
							</tr>
							<tr>
								<td>Last Update</td>
								<td>{{ $accountGroup->lastUpdate() }}</td>
							</tr>
						</tbody>
					</table>
					<br>

					<a class="btn btn-sm btn-warning" href="{{ route('account-group.edit', $accountGroup->group_id) }}">
						<i class="fa fa-pen"></i> Edit
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection