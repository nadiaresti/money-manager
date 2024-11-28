<?php
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;

$title = isset($transaction) ? "Update: " . Transaction::listType()[$transaction->trans_type] : 'Create Transaction';
$breadcrumbs = [
	['label' => 'Home', 'url' => url('/')],
	['label' => 'Transaction', 'url' => route('transaction.index')],
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
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form method="POST" action="{{ route('transaction.update', $transaction->trans_id) }}" class="form-horizontal" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="transfer_id" value="{{ $transaction->transfer_id ?? '' }}">

				<div class="form-group row">
					<label class="col-sm-2">Type</label>
					<div class="btn-group btn-group-toggle col-sm-3" data-toggle="buttons">
						@foreach (Transaction::listType() as $key => $item)
						<?php $active = ($key == $transaction->trans_type) ? 'active' : ''; ?>
						<label class="btn btn-secondary {{ $active }}">
							<input type="radio" name="trans_type" value="{{ $key }}" autocomplete="off" <?php if ($active) echo 'checked'; ?>> {{ $item }}
						</label>
						@endforeach
					</div>
				</div>

				<div class="row">
					<div class="col-6">
						<div class="form-group row">
							<label class="col-sm-4">Date</label>
							<div class="col-sm-8">
								<input type="date" name="trans_date" class="form-control col-sm-6" value="{{ $transaction->trans_date ?? old('trans_date', now()->format('Y-m-d')) }}" required>
							</div>
						</div>
						<div class="form-group row" id="category">
							<label class="col-sm-4">Category</label>
							<div class="col-sm-8">
								<select class="form-control col-sm-6" name="category_id">
									<option value="">-</option>
									@foreach (Category::getList() as $key => $item)
										<option value="{{ $key }}" {{ ($transaction->category_id ?? old('category_id')) == $key ? 'selected' : '' }}>{{ $item }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4">Account</label>
							<div class="col-sm-8">
								<select class="form-control col-sm-6" name="account_id">
									<option value="">-</option>
									@foreach (Account::getList() as $key => $item)
										<option value="{{ $key }}" {{ ($transaction->account_id ?? old('account_id')) == $key ? 'selected' : '' }}>{{ $item }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row type-transfer"
							style="display: none;">
							<label class="col-sm-4">Destination Account</label>
							<div class="col-sm-8">
								<select class="form-control col-sm-6" name="destination_id">
									<option value="">-</option>
									@foreach (Account::getList() as $key => $item)
										<option value="{{ $key }}" {{ ($transaction->transfer->destination_id ?? old('destination_id')) == $key ? 'selected' : '' }}>{{ $item }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4">Amount</label>
							<div class="input-group col-sm-4">
								<div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
								<input type="text" name="trans_amount" class="form-control format-number" value="{{ $transaction->trans_amount ?? old('trans_amount') }}">
							</div>
							<div class="input-group col-sm-3 type-transfer" style="display: none;">
								<div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
								<input type="text" name="admin_fee" class="form-control format-number" value="{{ $transaction->transfer->admin_fee ?? old('admin_fee') }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4">Remark</label>
							<div class="col-sm-8">
								<textarea class="form-control col-sm-8" rows="2" name="trans_remark" placeholder="Enter ...">{{ $transaction->trans_remark ?? old('trans_remark') }}</textarea>
							</div>
						</div>
					</div>

					{{-- File layout --}}
					<div class="col-6">
						<div class="form-group row">
							<label class="col-sm-2">File</label>
							<div class="col-sm-3">
								<input type="file" name="file" class="file-input" aria-label="File upload" id="choose-file" accept="image/*, application/pdf">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-10 offset-sm-2 border" style="max-width: 400px; min-height: 200px" id="preview">
								<?php $file_name = $transaction->file->file_name ?? ''; ?>
								@if (!empty($transaction->file) && $transaction->file->file_type == 'image')
									<input type="hidden" name="old_file" value="{{ $transaction->file->file_id }}">
									<img src="{{ asset("storage/uploads/$file_name") }}"  class="w-100 h-auto">
									<div class="btn btn-danger btn-mini position-absolute" style="top: 10px; right: 10px" id="remove-file">
										<i class="fas fa-trash"></i>
									</div>
								@elseif (!empty($transaction->file) && $transaction->file->file_type == 'application')
									<input type="hidden" name="old_file" value="{{ $transaction->file->file_id }}">
									<iframe src="{{ asset("storage/uploads/$file_name") }}" width="100%" height="400px" style="border: none;"></iframe>
									<div class="btn btn-danger btn-mini position-absolute" style="top: 10px; right: 10px" id="remove-file">
										<i class="fas fa-trash"></i>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>

				<div class="form-account row">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script>
	var type_transfer = '<?= Transaction::TYPE_TRANSFER ?>';
	$(document).ready(formCategory($('input[name="trans_type"]:checked')))
	$('input[name="trans_type"]').change(function() { formCategory($(this)) })

	$('#choose-file').change(function(e){
		$('#preview').html('');
		var file = e.target.files[0];
		var reader = new FileReader();
		reader.onload = function(e){
			if (file.type.startsWith('image/')) {
				showImage(e.target.result, false);
			} else {
				showPdf(e.target.result, false);
			}
		}
		reader.readAsDataURL(file);
	})

	$(document).on('click', '#remove-file', function() {
		$('#preview').html('');
		$('#choose-file').val('');
		$('input[name="old_file"]').val('');
	})

	function formCategory(element) {
		if (element.val() == type_transfer) {
			$('.type-transfer').show();
			$('#category').hide();
		} else {
			$('.type-transfer').hide();
			$('#category').show();
		}
	}

	function showImage(src) {
		let html = '<img src="' + src + '"  class="w-100 h-auto">'
			+ '<div class="btn btn-danger btn-mini position-absolute" style="top: 10px; right: 10px" id="remove-file">'
			+ '<i class="fas fa-trash"></i>'
			+ '</div>';
		$("#preview").html(html);
	}

	function showPdf(src) {
		let html = '<iframe src="' + src + '" width="100%" height="500px" style="border: none;"></iframe>'
			+ '<div class="btn btn-danger btn-mini position-absolute" style="top: 10px; right: 10px" id="remove-file">'
			+ '<i class="fas fa-trash"></i>'
			+ '</div>';
		$("#preview").html(html);
	}
</script>
@endsection