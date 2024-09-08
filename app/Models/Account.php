<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Account extends Model
{
	use HasFactory;

	protected $table = 'account';
	protected $primaryKey = 'account_id';
	public $timestamps = false;

	protected $fillable = [
		'group_id', 'account_name', 'account_description', 'account_amount', 'updated_by', 'updated_at',
	];

	// ----------------- Validation
	public static function validate($data, $account_id = null)
	{
		$rules = [
			'group_id' => ['required', 'int', 'max:10'],
			'account_name' => ['required', 'string', 'max:50', Rule::unique('account')->ignore($account_id, 'account_id')],
			'account_description' => ['nullable', 'string', 'max:150'],
			'updated_by' => ['required', 'int', 'max:10'],
			'updated_at' => ['required', 'date_format:Y-m-d H:i:s'],
		];
		return Validator::make($data, $rules);
	}

	// ----------------- Relation
	public function accountGroup()
	{
		return $this->belongsTo(AccountGroup::class, 'group_id', 'group_id');
	}

	public function transaction()
	{
		return $this->hasMany(Transaction::class, 'account_id', 'account_id');
	}

	// ----------------- Others
	public function lastUpdate()
	{
		$user = User::find($this->updated_by);
		return "$this->updated_at (".$user->username.")";
	}

	public function isDeletable()
	{
		return (!$this->transaction()->exists());
	}
}
