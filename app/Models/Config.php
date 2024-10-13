<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Config extends Model
{
	use HasFactory;

	protected $table = 'config';
	protected $primaryKey = 'config_id';
	public $timestamps = false;

	protected $fillable = [
		'config_name', 'config_key', 'config_value',
	];

	public static function getConfig()
    {
        // Try to get the configuration from the cache
        $config = Cache::get('config');

        // If not in cache, retrieve from the database and cache it
        if (!$config) {
			$config = [];
            foreach (Config::all() as $each) {
                $config[$each->config_key] = $each->config_value;
            }
            Cache::put('config', $config, 60);
        }

        return $config;
    }
}
