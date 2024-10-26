<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'config_name' => 'Format Date',
                'config_key' => 'format_date',
                'config_value' => '3',
            ],
            [
                'config_name' => 'Format Input Date',
                'config_key' => 'format_input_date',
                'config_value' => '1',
            ],
            [
                'config_name' => 'Currency',
                'config_key' => 'currency',
                'config_value' => 'Rp',
            ],
            [
                'config_name' => 'Format Number',
                'config_key' => 'locale_format_number',
                'config_value' => 'id-ID',
            ],
            [
                'config_name' => 'Decimal',
                'config_key' => 'decimal',
                'config_value' => '2',
            ],
            [
                'config_name' => 'Report Type',
                'config_key' => 'report_type',
                'config_value' => 'Y-m',
            ],
        ];

        DB::table('config')->insert($data);
    }
}
