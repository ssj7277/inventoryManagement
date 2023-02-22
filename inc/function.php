<?php
//error 결과 출력
error_reporting(E_ALL);

ini_set('display_errors', '1');

//리퍼러 체크

function check_referer($url = '')
{
    if (strpos($_SERVER['HTTP_REFERER'], $url) !== FALSE && !empty($url)) {

    } else {
        //  $code = 404;
        //  $msg  = "접근 오류\n다시 시도해 주세요.";
        //  throw new Exception($msg, $code);
    }
}