<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TransactionFile extends Model
{
	use HasFactory;

	protected $table = 'transaction_file';
	protected $primaryKey = 'file_id';
	public $timestamps = false;

	protected $fillable = [
		'trans_id', 'file_name', 'file_type',
	];

	// ----------------- Relation
	public function transaction()
	{
		return $this->belongsTo(Transaction::class, 'trans_id', 'trans_id');
	}

	// ----------------- Validation
	public static function validate($data)
	{
		$rules = [
			'trans_id' => ['required', 'int'],
			'file_name' => ['required', 'string', 'max:250'],
			'file_type' => ['required', 'string', 'max:50'],
		];

		$validate = Validator::make($data, $rules);
		if ($validate->fails()) {
			throw new ValidationException($validate);
		}
	}
}
