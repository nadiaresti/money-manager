<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $table = 'journal';
	protected $primaryKey = 'journal_id';
	public $timestamps = false;

    // ----------------- Relation
	public function account()
	{
		return $this->belongsTo(Account::class, 'account_id', 'account_id');
	}

}
