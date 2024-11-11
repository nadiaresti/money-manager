<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Transaction extends Model
{
	use HasFactory;

	protected $table = 'transaction';
	protected $primaryKey = 'trans_id';
	public $timestamps = false;

	const TYPE_INCOME = 1;
	const TYPE_EXPENSE = 2;
	const TYPE_TRANSFER = 3;

	protected $fillable = [
		'category_id', 'account_id', 'trans_date', 'trans_type', 'trans_amount', 'trans_remark',
		'updated_by', 'updated_at',
	];

	// ----------------- Relation
	public function account()
	{
		return $this->belongsTo(Account::class, 'account_id', 'account_id');
	}

	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id', 'category_id');
	}

	public function file()
	{
		return $this->hasOne(TransactionFile::class, 'trans_id', 'trans_id');
	}

	public function transfer()
	{
		return $this->hasOne(TransactionTransfer::class, 'trans_id', 'trans_id');
	}

	// ----------------- Validation
	public static function validate($data)
	{
		$rules = [
			'category_id' => ['required', 'int', 'max:10'],
			'account_id' => ['required', 'int', 'max:10'],
			'trans_date' => ['required', 'date_format:Y-m-d'],
			'trans_type' => ['required', 'int'],
			'trans_amount' => ['required', 'gt:0'],
			'trans_remark' => ['nullable', 'string', 'max:250'],
			'updated_by' => ['required', 'int', 'max:10'],
			'updated_at' => ['required', 'date_format:Y-m-d H:i:s'],
		];

		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
	}

	// ----------------- Others
	public function lastUpdate()
	{
		$user = User::find($this->updated_by);
		return "$this->updated_at ($user->username)";
	}

	public static function listType()
	{
		return [
			self::TYPE_INCOME => 'Income',
			self::TYPE_EXPENSE => 'Expense',
			self::TYPE_TRANSFER => 'Transfer',
		];
	}
}
