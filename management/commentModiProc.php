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

    //변수 정리
	$cpNum			= isset($_POST['cpNum'])		?		$_POST['cpNum']			: '';
	$userName		= isset($_POST['userName'])		?		$_POST['userName']		: '';
    $enterDate 		= isset($_POST['enterDate']) 	?		$_POST['enterDate'] 	: '';
	
	//DB Query
    $query  = "
        UPDATE comments
		SET isActive = 'n'
		WHERE cpNum = '{$cpNum}' AND name = '{$userName}'
			AND enterdate = '{$enterDate}'
	";
	//print_r($query);
	
    $delete_result = $_mysqli->query($query);

    if (!$delete_result) {
        $code   = 501;
        $msg    = "삭제 중 오류가 발생했습니다.(code {$code})\n관리자에게 문의해 주세요.";
        throw new mysqli_sql_exception($msg, $code);
    }
	
	//커밋
    $_mysqli->commit();

    //성공
    $arrRtn['code']    = 200;
    $arrRtn['msg']     = "등록되었습니다.";

}catch(mysqli_sql_exception $e){
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();
    echo json_encode($arrRtn);
}catch(Exception $e){
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();
    echo json_encode($arrRtn);
} finally {
	echo json_encode($arrRtn);
}

?>



