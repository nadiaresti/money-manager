<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AccountGroup extends Model
{
    use HasFactory;

    protected $table = 'account_group';
    protected $primaryKey = 'group_id';
	public $timestamps = false;

    protected $fillable = [
        'group_code', 'group_name', 'updated_by', 'updated_at',
    ];

	// ----------------- Validation
    public static function validate($data, $group_id = '')
    {
        $rules = [
            'group_code' => ['required', 'string', 'max:10', Rule::unique('account_group')->ignore($group_id, 'group_id')],
            'group_name' => ['required', 'string', 'max:25'],
        ];
        return Validator::make($data, $rules);
    }

	// ----------------- Relation
    public function account()
    {
        return $this->hasMany(Account::class, 'group_id', 'group_id');
    }

	// ----------------- Others
	public function lastUpdate()
	{
		$user = User::find($this->updated_by);
		return "$this->updated_at (".$user->username.")";
	}

    public static function getList()
    {
        $result = [];
        foreach (self::all() as $item) {
            $result[$item->group_id] = $item->group_name;
        }
        return $result;
    }

    public function isDeletable()
    {
        return (!$this->account()->exists());
    }
}
