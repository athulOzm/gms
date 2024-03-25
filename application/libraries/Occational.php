<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Occational {

    private $date_format;

    function __construct() {
        $CI = & get_instance();
        $CI->date_format = $CI->session->userdata('date_format');
    }

    function dateConvertMyformat($date) {
        $CI = & get_instance();
        if ($CI->date_format == 1) {
            $final_date = date('d-m-Y', strtotime($date));
        } elseif ($CI->date_format == 2) {
            $final_date = date('m-d-Y', strtotime($date));
        } elseif ($CI->date_format == 3) {
            $final_date = date('Y-m-d', strtotime($date));
        }
        return $final_date;
    }

    function dateConvert($date) {
        list($year, $month, $day) = explode('-', $date);
        //list($hour,$minute,$second) = explode(':',$date);
        $day = $day + 1;
        $day = $day - 1;
        switch ($month) {
            case "01":
                $month = 'JAN';
                break;
            case "02":
                $month = 'FEB';
                break;
            case "03":
                $month = 'MAR';
                break;
            case "04":
                $month = 'APR';
                break;
            case "05":
                $month = 'MAY';
                break;
            case "06":
                $month = 'JUN';
                break;
            case "07":
                $month = 'JUL';
                break;
            case "08":
                $month = 'AUG';
                break;
            case "09":
                $month = 'SEP';
                break;
            case "10":
                $month = 'OCT';
                break;
            case "11":
                $month = 'NOV';
                break;
            case "12":
                $month = 'DEC';
                break;
        }
        $final_date = $day . ' - ' . $month . ' - ' . $year;
        return $final_date;
    }

    function dateConvertMyfomat($date) {
        return $date;
        die();
    }

}
