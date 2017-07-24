<?php
/**
 * Created by PhpStorm.
 * User: Chantouch
 * Date: 7/24/2017
 * Time: 10:00 AM
 */

namespace app\Helper;

class Format
{
    public static function month($month)
    {
        $strout = '';
        $strchar = $month;
        if ($strchar == '01' || $strchar == '1') {
            $strout .= 'មករា';
        }
        if ($strchar == '2' || $strchar == '02') {
            $strout .= 'កុម្ភៈ';
        }
        if ($strchar == '3' || $strchar == '03') {
            $strout .= 'មិនា';
        }
        if ($strchar == '4' || $strchar == '04') {
            $strout .= 'មេសា';
        }
        if ($strchar == '5' || $strchar == '05') {
            $strout .= 'ឧសភា';
        }
        if ($strchar == '6' || $strchar == '06') {
            $strout .= 'មិថុនា';
        }
        if ($strchar == '7' || $strchar == '07') {
            $strout .= 'កក្កដា';
        }
        if ($strchar == '8' || $strchar == '08') {
            $strout .= 'សីហា';
        }
        if ($strchar == '9' || $strchar == '09') {
            $strout .= 'កញ្ញា';
        }
        if ($strchar == '10') {
            $strout .= 'តុលា';
        }
        if ($strchar == '11') {
            $strout .= 'វិច្ឆិកា';
        }
        if ($strchar == '12') {
            $strout .= 'ធ្នូ';
        }
        return $strout;
    }

    public static function day($day)
    {
        $strout = '';
        $strchar = $day;
        if ($strchar == 'Mon' || $strchar == 'Monday') {
            $strout .= 'ចន្ទ';
        }
        if ($strchar == 'Tue' || $strchar == 'Tuesday') {
            $strout .= 'អង្គារ';
        }
        if ($strchar == 'Wed' || $strchar == 'Wednesday') {
            $strout .= 'ពុធ';
        }
        if ($strchar == 'Thu' || $strchar == 'Thursday') {
            $strout .= 'ប្រហស្បតិ៍';
        }
        if ($strchar == 'Fri' || $strchar == 'Friday') {
            $strout .= 'សុក្រ';
        }
        if ($strchar == 'Sat' || $strchar == 'Saturday') {
            $strout .= 'សោរិ៍';
        }
        if ($strchar == 'Sun' || $strchar == 'Sunday') {
            $strout .= 'អាទិត្យ';
        }
        return $strout;
    }

    public static function khmerFormatMeetingDate($data)
    {
        $format = new Format();
        return $format->day($data->meeting_date->format('D')) . ', ' . $data->meeting_date->format('d') . ' ' . $format->month($data->meeting_date->format('m')) . ' ' . $data->meeting_date->format('Y');
    }

    public static function khmerFormatMissionDate($data)
    {
        $format = new Format();
        return $format->day($data->start_date->format('D')) . ', ' . $data->start_date->format('d') . ' ' . $format->month($data->start_date->format('m')) . ' ' . $data->start_date->format('Y')
            . ' - ' .
            $format->day($data->end_date->format('D')) . ', ' . $data->end_date->format('d') . ' ' . $format->month($data->end_date->format('m')) . ' ' . $data->end_date->format('Y');
    }
}