<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
	protected $primaryKey = 'category_id';
	public $timestamps = false;

	const TYPE_INCOME = 1;
	const TYPE_EXPENSE = 2;
	const TYPE_TRANSFER = 3;

	protected $fillable = [
		'category_name', 'category_type', 'parent_id', 'updated_by', 'updated_at',
	];

	// ----------------- Validation
	public static function validate($data, $category_id = null)
	{
		$rules = [
			'category_name' => ['required', 'string', 'max:50', Rule::unique('category')->ignore($category_id, 'category_id')],
			'category_type' => ['required', 'int', 'max:10'],
			'parent_id' => ['int', 'max:10'],
			'updated_by' => ['required', 'int', 'max:10'],
			'updated_at' => ['required', 'date_format:Y-m-d H:i:s'],
		];
		return Validator::make($data, $rules);
	}

	// ----------------- Relation
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

	public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

	public function transaction()
	{
		return $this->hasMany(Transaction::class, 'category_id', 'category_id');
	}

	// ----------------- Others
	public function lastUpdate()
	{
		$user = User::find($this->updated_by);
		return "$this->updated_at (".$user->username.")";
	}

	public function isDeletable()
	{
		// Check if it is a child OR a parent that doesn't have child
		$success = (empty($this->parent_id) && !$this->children()->exists());
		$success |= (!empty($this->parent_id));

		// Check if category has created transaction
		$success &= (!$this->transaction()->exists());

		return $success;
	}

	public static function getList()
	{
		$result = [];
		foreach (Category::all() as $item) {
			$result[$item->category_id] = $item->category_name;
		}
		return $result;
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
