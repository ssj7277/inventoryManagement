<?php
//config
require_once __DIR__ . '/../inc/config.php';

//변수 정리
$arrRtn = array(
	'code' => 500,
	'msg' => ''
);


try {
	//변수 정리
	$searchType = isset($_POST['searchType']) ? $_POST['searchType'] : '';
	$searchText = isset($_POST['searchText']) ? $_POST['searchText'] : '';
	$cpSerial = isset($_POST['seq']) ? $_POST['seq'] : '0';

	//print_r($_POST);

	//DB Query
	$query = "
        UPDATE knCompany
		SET isActive = 'n'
		WHERE serial = '{$cpSerial}'
	";

	$delete_result = $_mysqli->query($query);


	if (!$delete_result) {
		$code = 501;
		$msg = "삭제 중 오류가 발생했습니다.(code {$code})\n관리자에게 문의해 주세요.";
		throw new mysqli_sql_exception($msg, $code);
	}

	//성공
	if ($delete_result) {
		echo "<script>alert('성공적으로 삭제되었습니다.');</script>";
		echo "<script>sendPost();</script>";
		//echo "<script>location.href='./../management/cpSelect.php';</script>";
	}


} catch (mysqli_sql_exception $e) {
	$arrRtn['code'] = $e->getCode();
	$arrRtn['msg'] = $e->getMessage();
	echo json_encode($arrRtn);
} catch (Exception $e) {
	$arrRtn['code'] = $e->getCode();
	$arrRtn['msg'] = $e->getMessage();
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
			<form id="delete_ok" action="cpSelect.php" method="get" enctype="multipart/form-data">
				<input type="hidden" name="searchType" id="searchType" value="<?php echo $searchType ?>">
				<input type="hidden" name="searchText" id="searchText" value="<?php echo $searchText ?>">
			</form>
		</section>
		<footer>
		</footer>
	</body>

	</html>

	<script type="text/javascript">

		window.onload = function () {
			sendPost();
		}
		function sendPost() {
			document.getElementById('delete_ok').submit();
		}

	</script>