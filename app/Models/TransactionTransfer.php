<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TransactionTransfer extends Model
{
	use HasFactory;

	protected $table = 'transaction_transfer';
	protected $primaryKey = 'transfer_id';
	public $timestamps = false;

	protected $fillable = ['trans_id', 'destination_id', 'admin_fee'];

	// ----------------- Relation
	public function transaction()
	{
		return $this->belongsTo(Transaction::class, 'trans_id', 'trans_id');
	}

	public function account()
	{
		return $this->belongsTo(Account::class, 'destination_id', 'account_id');
	}

	// ----------------- Validation
	public static function validate($data)
	{
		$rules = [
			'trans_id' => ['required', 'int'],
			'destination_id' => ['required', 'int'],
		];

		$validate = Validator::make($data, $rules);
		if ($validate->fails()) {
			throw new ValidationException($validate);
		}
	}
}
