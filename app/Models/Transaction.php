<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';
	protected $primaryKey = 'trans_id';
	public $timestamps = false;

	const TYPE_INCOME = 1;
	const TYPE_EXPENSE = 2;
	const TYPE_TRANSFER = 3;

    // ----------------- Relation
	public function account()
	{
		return $this->belongsTo(Account::class, 'account_id', 'account_id');
	}

	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id', 'category_id');
	}

	public function files()
	{
		return $this->hasMany(TransactionFile::class, 'trans_id', 'trans_id');
	}

	public function transfer()
	{
		return $this->hasOne(TransactionTransfer::class, 'trans_id', 'trans_id');
	}

	// ----------------- Validation
	public static function validate($data)
	{

	}

	// ----------------- Others
	public function lastUpdate()
	{
		$user = User::find($this->updated_by);
		return "$this->updated_at ($user->username)";
	}

	public function isUpdatable()
	{
		$period = Period::where(['period_name' => $this->period_name]);
		return ($period->period_status == Period::STAT_OPEN);
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
