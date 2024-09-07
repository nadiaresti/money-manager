<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Period extends Model
{
    use HasFactory;

    protected $table = 'period';
	protected $primaryKey = 'period_id';
	public $timestamps = false;

	protected $fillable = [
		'period_name', 'period_status', 'updated_by', 'updated_at',
	];

	// ----------------- Validation
	public static function validate($data, $period_id = null)
	{
		$rules = [
			'period_name' => ['required', 'string', 'max:50', Rule::unique('account')->ignore($period_id, 'period_id')],
			'period_status' => ['required', 'int', 'max:1'],
			'updated_by' => ['required', 'int', 'max:10'],
			'updated_at' => ['required', 'date_format:Y-m-d H:i:s'],
		];
		return Validator::make($data, $rules);
	}

	// ----------------- Relation
	public function journal()
	{
		return $this->hasMany(Journal::class, 'period_id', 'period_id');
	}

	// ----------------- Others
	public function isDeletable()
	{
		return (!$this->journal()->exists());
	}
}
