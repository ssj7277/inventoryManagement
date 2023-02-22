<?php
//config
require_once __DIR__ .'/../inc/config.php';

//변수 정리
$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
);

error_reporting(E_ALL);

ini_set('display_errors', '1');

//print_r($_POST);

try {
	
    //트랜잭션
    //$_mysqli->begin_transaction();

    //파라미터 정리
    $user			= isset($_POST['commEditUser'])		?	$_POST['commEditUser']		: '';
	$content		= isset($_POST['commContent'])		?	$_POST['commContent']		: '';
	$cpNum			= isset($_POST['cpNum'])			?	$_POST['cpNum']				: 0;


	//tag 제거
	$user 		= strip_tags($user);
	$content	= strip_tags($content);
	$cpNum		= strip_tags($cpNum);
	
	//공백 제거
	$user		= trim($user);
	$content	= trim($content);
	$cpNum		= trim($cpNum);
	
	//Escape String
    $user 		= $_mysqli->real_escape_string($user);
	$content	= $_mysqli->real_escape_string($content);
	$cpNum		= $_mysqli->real_escape_string($cpNum);
	
    //DB
    $query = "
        INSERT INTO comments
            (cpNum, name, content, isActive)
        VALUES 
            ('{$cpNum}', '{$user}', '{$content}', 'y')
    ";
    
	$edit_result = $_mysqli->query($query);

    if (!$edit_result) {
        $code   = 501;
        $msg    = "수정 중 오류가 발생했습니다.(code {$code})\n관리자에게 문의해 주세요.";
        throw new mysqli_sql_exception($msg, $code);
    }
	

    //커밋
    $_mysqli->commit();

    //성공
    $arrRtn['code']    = 200;
    $arrRtn['msg']     = "등록되었습니다.";

} catch (mysqli_sql_exception $e) {
    $_mysqli->rollback();
    $arrRtn['code']    = $e->getCode();
    $arrRtn['msg']     = $e->getMessage();

} catch (Exception $e) {
    $_mysqli->rollback();
    $arrRtn['code']    = $e->getCode();
    $arrRtn['msg']     = $e->getMessage();

} finally {
    echo json_encode($arrRtn);
}