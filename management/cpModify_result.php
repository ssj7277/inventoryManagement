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


try {
		
    //변수 정리
	$searchType	= isset($_POST['searchType'])	?	$_POST['searchType']	: '';
	$searchText	= isset($_POST['searchText'])	?	$_POST['searchText']	: '';
	$cpSerial	= isset($_POST['seq'])			?	$_POST['seq']			: '';
    $cpType 	= isset($_POST['cpType']) 		?	$_POST['cpType'] 		: '';
    $cpName 	= isset($_POST['cpName']) 		?	$_POST['cpName'] 		: '';
    $cpPhoneNum = isset($_POST['cpPhoneNum']) 	?	$_POST['cpPhoneNum'] 	: '';
    $cpFaxNum 	= isset($_POST['cpFaxNum']) 	?	$_POST['cpFaxNum'] 		: '';
    $cpEmail 	= isset($_POST['cpEmail']) 		?	$_POST['cpEmail'] 		: '';
    $cpAddress 	= isset($_POST['cpAddress']) 	?	$_POST['cpAddress'] 	: '';
    $cpRegiNum 	= isset($_POST['cpRegiNum']) 	?	$_POST['cpRegiNum'] 	: '';
    $cpCeoName 	= isset($_POST['cpCeoName']) 	?	$_POST['cpCeoName'] 	: '';
    $cpManager 	= isset($_POST['cpManager']) 	?	$_POST['cpManager'] 	: '';
    $cpUptae 	= isset($_POST['cpUptae']) 		?	$_POST['cpUptae'] 		: '';
    $cpUpjong 	= isset($_POST['cpUpjong']) 	?	$_POST['cpUpjong'] 		: '';

    //print_r($_POST);

    //파라미터 체크
    if (empty($cpName) || empty($cpCeoName) || empty($cpRegiNum)) {
        $code = 404;
        $msg = "필수 항목을 입력해 주세요";
        throw new Exception($msg, $code);
    }

    //Escape String
	$cpType 		= $_mysqli->real_escape_string($cpType);
    $cpText 		= $_mysqli->real_escape_string($cpText);
    $cpName			= $_mysqli->real_escape_string($cpName);
	$cpPhoneNum		= $_mysqli->real_escape_string($cpPhoneNum);
	$cpFaxNum		= $_mysqli->real_escape_string($cpFaxNum);
    $cpEmail		= $_mysqli->real_escape_string($cpEmail);
    $cpAddress		= $_mysqli->real_escape_string($cpAddress);
	$cpRegiNum		= $_mysqli->real_escape_string($cpRegiNum);
    $cpCeoName		= $_mysqli->real_escape_string($cpCeoName);
    $cpManager		= $_mysqli->real_escape_string($cpManager);
    $cpUptae		= $_mysqli->real_escape_string($cpUptae);
    $cpUpjong		= $_mysqli->real_escape_string($cpUpjong);

    //DB Query
    $query  = "
        UPDATE knCompany SET
			companyType = '{$cpType}', name = '{$cpName}', phone = '{$cpPhoneNum}', fax = '{$cpFaxNum}',
			email = '{$cpEmail}', regiNumber = '{$cpRegiNum}', address = '{$cpAddress}', ceoName = '{$cpCeoName}',
			contactName = '{$cpManager}', uptae = '{$cpUptae}', upjong = '{$cpUpjong}'
			WHERE serial = '{$cpSerial}'
			";
	//print_r($query);

	$modify_result = $_mysqli->query($query);

    if (!$modify_result) {
        $code   = 501;
        $msg    = "수정 중 오류가 발생했습니다.(code {$code})\n관리자에게 문의해 주세요.";
        throw new mysqli_sql_exception($msg, $code);
    }

	//성공
	if($modify_result) {
		//header("Refresh:0");
		echo "<script>alert('성공적으로 수정되었습니다.');</script>";
		echo "<script>sendPost();</script>";
	}


}catch(mysqli_sql_exception $e){
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();
    echo json_encode($arrRtn);
}catch(Exception $e){
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();
    echo json_encode($arrRtn);
} finally {

}
?>

<!DOCUTYPE html>
<html lang="ko">
<head>
	<title></title>
</head>
<body>
	<header>		
	</header>
	<nav>
	</nav>
	<section>
		<!-- 상세페이지  -->
		<form id="modify_ok" action="cpSelect_detail.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="seq" id="seq" value="<?php echo $cpSerial ?>">
			<input type="hidden" name="searchType" id="searchType" value="<?php echo $searchType ?>">
			<input type="hidden" name="searchText" id="searchText" value="<?php echo $searchText ?>">
		</form>
	</section>
	<footer>
	</footer>
</body>
</html>

<script type="text/javascript">
	
	window.onload = function() {
		sendPost();
	}
	
	function sendPost() {
		document.getElementById('modify_ok').submit();
	}
</script>