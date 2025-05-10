<?php

use App\Models\MainModel;


function isGranted($role)
{
    return auth()->user()->isGranted($role);
}

function dateFormat($date, $format = 'Y-m-d'){
    try{
        $dt = date_create($date);
        return date_format($dt, $format);
    }catch(\Exception $e){
        return $date;
    }
}

function date_formated($date, $format = 'd-m-Y')
{
    $date = strtotime($date);
    if (!$date) {
        return null;
    }
    return date($format, $date);
}

function dateTimeFormat($date, $format = 'Y-m-d H:i:s'){
    return dateFormat($date, $format);
}

function nbrFormat($number, $decimale = 2 ){
    return number_format($number, $decimale, ',', ' ');
}

/* Number To Words Function  */
function subNumberToWords($number) {
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(         
        0   => '',
        1   => 'Un',
        2   => 'Deux',
        3   => 'Trois',
        4   => 'Quatre',
        5   => 'Cinq',
        6   => 'Six',
        7   => 'Sept',
        8   => 'Huit',
        9   => 'Neuf',
        10  => 'Dix',
        11  => 'Onze',
        12  => 'Douze',
        13  => 'Treize',
        14  => 'Quatorze',
        15  => 'Quinze',
        16  => 'Seize',
        17  => 'Dix-sept',
        18  => 'Dix-huit',
        19  => 'Dix-neuf',
        20  => 'Vingt',
        30  => 'Trente',
        40  => 'Quarante',
        50  => 'Cinquante',
        60  => 'Soixante',
        70  => 'Soixante-dix',
        80  => 'Quatre-vingt',
        90  => 'Quatre-vingt-dix',
    );

    $digits = array('', 'Cent','Mille','Lakhs', 'Crores');

    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? '' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    return $Rupees;
}

/* Number To Words Function  */
function numberToWords($number) {

    $Rupees = '';

    if( $number < 0 ){
        $number *= -1;
        $Rupees .= "Moins ";
    }

    $decimal = round($number - ($no = floor($number)), 2) * 100;

    $Rupees .= subNumberToWords($number);
    $paise = '';

    if( $decimal > 0 ){
        $paise = ' et '. subNumberToWords($decimal). 'centimes';
    }

    $Rupees .= ' Dirhams' . $paise;

    $Rupees = str_replace('Un Mille', 'Mille', $Rupees);
    $Rupees = str_replace('Un Cent', 'Cent', $Rupees);
    $Rupees = preg_replace('/\s+/', ' ',$Rupees);

    return $Rupees;
}

function showalerts(){

    $html = '<div id="alerts">';

    if ( $message = Session::get('success') ){
        $html .= '<div class="alert alert-success alert-dismissible alert-label-icon label-arrow shadow fade show" role="alert">
            <i class="ri-check-double-line label-icon"></i><strong>'. $message .'</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    if ( $message = Session::get('error') ){
        $html .= '<div class="alert alert-danger alert-dismissible alert-label-icon label-arrow shadow fade show" role="alert">
            <i class="ri-error-warning-line label-icon"></i><strong>'.$message.'</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    if($message = Session::get('warning')){
        $html .= '<div class="alert alert-warning alert-dismissible alert-label-icon label-arrow shadow fade show" role="alert">
            <i class="ri-alert-line label-icon"></i><strong>'.$message.'</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    if($message = Session::get('info')){
        $html .= '<div class="alert alert-info alert-dismissible alert-label-icon label-arrow shadow fade show" role="alert">
            <i class="ri-airplay-line label-icon"></i><strong>'.$message.'</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    if( Session::get('errors') ){
        foreach ( Session::get('errors')->all() as $error){
            $html .= '<div class="alert alert-danger alert-dismissible alert-label-icon label-arrow shadow fade show" role="alert">
                <i class="ri-error-warning-line label-icon"></i><strong>'. $error .'</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }

    return $html .'</div>';
}
