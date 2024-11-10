<?php

namespace App\Helpers;

use App\Models\Config;
use IntlDateFormatter;
use NumberFormatter;

class GeneralHelper
{
    /**
	 * 1 - Y-m-d: 2024-12-31
	 * 2 - d-m-Y: 31-12-2024
	 * 3 - d F Y: 31 December 2024
	 */
    public static function formatDate($date)
    {
        $format = Config::getConfig()['format_date'];
        switch ($format) {
            case 1:
                $result = date('Y-m-d', strtotime($date));
                break;
            case 2:
                $result = date('d-m-Y', strtotime($date));
                break;
            case 3:
                $months = self::months('EN', 1);
                $mo = date('n',strtotime($date));
                $result = date('d ', strtotime($date)) . $months[$mo] . date(' Y',strtotime($date));
                break;
            default:
                $result = '';
                break;
        }

        return $result;
    }

    public static function months($lang, $format = 1)
    {
        if (strtoupper($lang) == 'EN') {
            $result[1] = ($format == 1) ? 'Jan' : 'January';
            $result[2] = ($format == 1) ? 'Feb' : 'February';
            $result[3] = ($format == 1) ? 'Mar' : 'March';
            $result[4] = ($format == 1) ? 'Apr' : 'April';
            $result[5] = ($format == 1) ? 'Mei' : 'May';
            $result[6] = ($format == 1) ? 'Jun' : 'June';
            $result[7] = ($format == 1) ? 'Jul' : 'July';
            $result[8] = ($format == 1) ? 'Ags' : 'August';
            $result[9] = ($format == 1) ? 'Sep' : 'September';
            $result[10] = ($format == 1) ? 'Oct' : 'October';
            $result[11] = ($format == 1) ? 'Nov' : 'November';
            $result[12] = ($format == 1) ? 'Dec' : 'December';
        } elseif (strtoupper($lang) == 'ID') {
            $result[1] = ($format == 1) ? 'Jan' : 'Januari';
            $result[2] = ($format == 1) ? 'Feb' : 'Februari';
            $result[3] = ($format == 1) ? 'Mar' : 'Maret';
            $result[4] = ($format == 1) ? 'Apr' : 'April';
            $result[5] = ($format == 1) ? 'Mei' : 'Mei';
            $result[6] = ($format == 1) ? 'Jun' : 'Juni';
            $result[7] = ($format == 1) ? 'Jul' : 'Juli';
            $result[8] = ($format == 1) ? 'Ags' : 'Agustus';
            $result[9] = ($format == 1) ? 'Sep' : 'September';
            $result[10] = ($format == 1) ? 'Oct' : 'Oktober';
            $result[11] = ($format == 1) ? 'Nov' : 'November';
            $result[12] = ($format == 1) ? 'Dec' : 'Desember';
        } elseif (strtoupper($lang) == 'ROM') {
            $result[1] = 'I';
            $result[2] = 'II';
            $result[3] = 'III';
            $result[4] = 'IV';
            $result[5] = 'V';
            $result[6] = 'VI';
            $result[7] = 'VII';
            $result[8] = 'VIII';
            $result[9] = 'IX';
            $result[10] = 'X';
            $result[11] = 'XI';
            $result[12] = 'XII';
        }

        return $result;
    }

    public static function formatMoney($value, $use_pad = true)
    {
        $config = Config::getConfig();
        $locale = $config['locale_format_number'] ?? '';
        $currency = $config['currency'] ?? '';
        $decimal = $config['decimal'] ?? '';
		switch($locale) {
			case 'id-ID' :
				$tnumber = $use_pad ?
                    str_pad(number_format($value, $decimal, ',', '.'), 11, ' ', STR_PAD_LEFT):
				    number_format($value, $decimal, ',', '.');
				$str = $currency . $tnumber;
				break;
            case 'en-US' :
                $tnumber = $use_pad ?
                    str_pad(number_format($value, $decimal, '.', ','), 11, ' ', STR_PAD_LEFT):
                    number_format($value, $decimal, '.', ',');
                $str = $currency . $tnumber;
                break;
			default:
				$tnumber = $use_pad ?
                    str_pad(number_format($value, $decimal, ',', '.'), 7, ' ', STR_PAD_LEFT):
				    number_format($value, $decimal, ',', '.');
				$str = ltrim($tnumber);
				break;
		}
		return $str;
    }

    public static function assertNumber($value)
    {
        return (double) str_replace(',', '', $value);
    }
}