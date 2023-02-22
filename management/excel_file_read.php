<?php
//config
require_once __DIR__ . '/../inc/config.php';

//변수 정리
$arrRtn = array(
	'code' => 500,
	'msg' => ''
);

error_reporting(E_ALL);
ini_set('display_errors', '1');

//print_r($_SERVER['DOCUMENT_ROOT']);

require_once('/vendor/autoload.php');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

try {

	//transaction
	$_mysqli->begin_transaction();

	$server_inputFileName = $_FILES['inputFileName']['tmp_name'];

	//echo $server_inputFileName;

	//PC파일명 및 확장자 
	$pc_FileName = $_FILES['inputFileName']['name'];
	$file_type = pathinfo($pc_FileName, PATHINFO_EXTENSION);


	//Excel File 확장자 확인
	if ($file_type == 'xls') {
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
	} else if ($file_type == 'xlsx') {
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
	} else {
		echo '처리할 수 있는 엑셀 파일이 아닙니다';
		exit;
	}


	//PhpSpreadsheet로 읽어서 배열에 저장하기
	//서버에 업로드된 파일의 현재 시트를 읽어서 $spreadData란 배열에 저장

	$spreadsheet = $reader->load($server_inputFileName);
	$spreadData = $spreadsheet->getActiveSheet(0)->toArray(); // $spreadsheet->getSheet(1); sheet 지정 가능

	//print_r($spreadsheet);

	//행 카운트
	$rows = count($spreadData);
	//print_r($rows);

	//열 카운트
	$cols = (count($spreadData, COUNT_RECURSIVE) / count($spreadData)) - 1;

	//excel Data 배열 생성
	for ($iLoop1 = 1; $iLoop1 < $rows + 1; ++$iLoop1) {
		${"insertData" . $iLoop1} = array();
	}



	//데이터 삽입
	for ($iLoop1 = 0; $iLoop1 < $rows; ++$iLoop1) {
		for ($iLoop2 = 0; $iLoop2 < $cols; ++$iLoop2) {
			${"insertData" . $iLoop1}[$iLoop2] = $spreadData[$iLoop1][$iLoop2];
		}
		//echo '<br>';
	}


	//필수 데이터 체크
	for ($iLoop1 = 1; $iLoop1 < $rows; ++$iLoop1) {
		while (true) {
			$row = 1;
			if (empty(${"insertData" . $iLoop1}[0])) {
				$row = $row + $iLoop1;
				$errorCode = "error code: " . $row . "번째 행의 필수 항목(" . ${"insertData0"}[0] . ")을 입력 바랍니다.";
				echo "<script>alert('엑셀 데이터를 삽입할 수 없습니다.\\n$errorCode')</script>";
				echo "<script>history.back()</script>";
				exit();

			}
			if (empty(${"insertData" . $iLoop1}[1])) {
				$row = $row + $iLoop1;
				$errorCode = "error code: " . $row . "번째 행의 필수 항목(" . ${"insertData0"}[1] . ")을 입력 바랍니다.";
				echo "<script>alert('엑셀 데이터를 삽입할 수 없습니다.\\n$errorCode')</script>";
				echo "<script>history.back()</script>";
				exit();
			}
			if (empty(${"insertData" . $iLoop1}[5])) {
				$row = $row + $iLoop1;
				$errorCode = "error code: " . $row . "번째 행의 필수 항목(" . ${"insertData0"}[5] . ")을 입력 바랍니다.";
				echo "<script>alert('엑셀 데이터를 삽입할 수 없습니다.\\n$errorCode')</script>";
				echo "<script>history.back()</script>";
				exit();
			}
			if (empty(${"insertData" . $iLoop1}[6])) {
				$row = $row + $iLoop1;
				$errorCode = "error code: " . $row . "번째 행의 필수 항목(" . ${"insertData0"}[6] . ")을 입력 바랍니다.";
				echo "<script>alert('엑셀 데이터를 삽입할 수 없습니다.\\n$errorCode')</script>";
				echo "<script>history.back()</script>";
				exit();
			}
			if (empty(${"insertData" . $iLoop1}[7])) {
				$row = $row + $iLoop1;
				$errorCode = "error code: " . $row . "번째 행의 필수 항목(" . ${"insertData0"}[7] . ")을 입력 바랍니다.";
				echo "<script>alert('엑셀 데이터를 삽입할 수 없습니다.\\n$errorCode')</script>";
				echo "<script>history.back()</script>";
				exit();
			}
			break;
		}
		//echo $iLoop1."번 확인 했습니다.<br>";
	}

	//DB 변수 초기화
	//변수 정리
	$cpType = '';
	$cpName = '';
	$cpPhoneNum = '';
	$cpFaxNum = '';
	$cpEmail = '';
	$cpAddress = '';
	$cpRegiNum = '';
	$cpCeoName = '';
	$cpManager = '';
	$cpUptae = '';
	$cpUpjong = '';
	$count = 0;


	for ($iLoop1 = 1; $iLoop1 < $rows; ++$iLoop1) {
		//Data
		for ($iLoop2 = 0; $iLoop2 < $cols; ++$iLoop2) {
			if ($iLoop2 == 0) {
				$cpType = isset(${"insertData" . $iLoop1}[$iLoop2]) ? ${"insertData" . $iLoop1}[$iLoop2] : '';
			}
			if ($iLoop2 == 1) {
				$cpName = isset(${"insertData" . $iLoop1}[$iLoop2]) ? ${"insertData" . $iLoop1}[$iLoop2] : '';
			}
			if ($iLoop2 == 2) {
				$cpPhoneNum = isset(${"insertData" . $iLoop1}[$iLoop2]) ? ${"insertData" . $iLoop1}[$iLoop2] : '';
			}
			if ($iLoop2 == 3) {
				$cpFaxNum = isset(${"insertData" . $iLoop1}[$iLoop2]) ? ${"insertData" . $iLoop1}[$iLoop2] : '';
			}
			if ($iLoop2 == 4) {
				$cpEmail = isset(${"insertData" . $iLoop1}[$iLoop2]) ? ${"insertData" . $iLoop1}[$iLoop2] : '';
			}
			if ($iLoop2 == 5) {
				$cpAddress = isset(${"insertData" . $iLoop1}[$iLoop2]) ? ${"insertData" . $iLoop1}[$iLoop2] : '';
			}
			if ($iLoop2 == 6) {
				$cpRegiNum = isset(${"insertData" . $iLoop1}[$iLoop2]) ? ${"insertData" . $iLoop1}[$iLoop2] : '';
			}
			if ($iLoop2 == 7) {
				$cpCeoName = isset(${"insertData" . $iLoop1}[$iLoop2]) ? ${"insertData" . $iLoop1}[$iLoop2] : '';
			}
			if ($iLoop2 == 8) {
				$cpManager = isset(${"insertData" . $iLoop1}[$iLoop2]) ? ${"insertData" . $iLoop1}[$iLoop2] : '';
			}
			if ($iLoop2 == 9) {
				$cpUptae = isset(${"insertData" . $iLoop1}[$iLoop2]) ? ${"insertData" . $iLoop1}[$iLoop2] : '';
			}
			if ($iLoop2 == 10) {
				$cpUpjong = isset(${"insertData" . $iLoop1}[$iLoop2]) ? ${"insertData" . $iLoop1}[$iLoop2] : '';
			}
		}
		//Escape String
		$cpType = $_mysqli->real_escape_string($cpType);
		$cpName = $_mysqli->real_escape_string($cpName);
		$cpPhoneNum = $_mysqli->real_escape_string($cpPhoneNum);
		$cpFaxNum = $_mysqli->real_escape_string($cpFaxNum);
		$cpEmail = $_mysqli->real_escape_string($cpEmail);
		$cpAddress = $_mysqli->real_escape_string($cpAddress);
		$cpRegiNum = $_mysqli->real_escape_string($cpRegiNum);
		$cpCeoName = $_mysqli->real_escape_string($cpCeoName);
		$cpManager = $_mysqli->real_escape_string($cpManager);
		$cpUptae = $_mysqli->real_escape_string($cpUptae);
		$cpUpjong = $_mysqli->real_escape_string($cpUpjong);

		//DB Query
		$query = "
			INSERT INTO knCompany ( companyType, name, phone, fax, email, address,
								   regiNumber, ceoName, contactName, uptae, upjong) 
						VALUES ('{$cpType}', '{$cpName}', '{$cpPhoneNum}', '{$cpFaxNum}', '{$cpEmail}', '{$cpAddress}',
								'{$cpRegiNum}', '{$cpCeoName}', '{$cpManager}', '{$cpUptae}', '{$cpUpjong}')
									  
		";

		//결과 데이터
		$result = false;

		$_result = $_mysqli->query($query);

		//insert_Error
		if (!$_result) {
			$code = 501;
			$msg = "등록 중 오류가 발생했습니다.(code {$code})\n관리자에게 문의해 주세요.";
			throw new mysqli_sql_exception($msg, $code);
		}
		//insert_OK
		if ($_result) {
			$count++;
			$result = true;
			$query = '';
			$cpType = '';
			$cpName = '';
			$cpPhoneNum = '';
			$cpFaxNum = '';
			$cpEmail = '';
			$cpAddress = '';
			$cpRegiNum = '';
			$cpCeoName = '';
			$cpManager = '';
			$cpUptae = '';
			$cpUpjong = '';
		}
		//commit
		$_mysqli->commit();
	}


} catch (mysqli_sql_exception $e) {
	$arrRtn['code'] = $e->getCode();
	$arrRtn['msg'] = $e->getMessage();
	echo json_encode($arrRtn);
	$mysqli->rollBack();
} catch (Exception $e) {
	$arrRtn['code'] = $e->getCode();
	$arrRtn['msg'] = $e->getMessage();
	echo json_encode($arrRtn);
	$mysqli->rollBack();
} finally {

}

?>
<!DOCUTYPE html>
	<html lang="ko">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
		<link href="./../assets/css/style.css" rel="stylesheet">
		<title>result</title>

	<body>
		<!-- 헤더 부분 -->
		<header>
			<center>
				<h1>입력 결과 페이지</h1><br />
			</center>
		</header>
		<!-- 본문 부분 -->
		<section>
			<article class="bodyArticle">
				<?php
				if ($result == true) {
					echo "<script>alert('{$count}건이 정상적으로 삽입 되었습니다.');</script>";
					//echo '<script>alert("{$count}건이 정상적으로 삽입 되었습니다.");</script>';
					echo "<script>location.href='./../inven.php'</script>";
				} else {
					echo "<script>alert('데이터 삽입에 오류가 발생하였습니다.\\n데이터를 확인하세요.');</script>";
				}
				?>
				<button type="button" id="selectBtn" class="btn btn-outline-secondary"
					onclick="location.href='./../inven.php'">돌아가기</button>
			</article>
		</section>
		<!-- 사이트 정보 부분 -->
		<footer>
			<hr />
			<p class="footer_p">사이트 정보 표시</p>
		</footer>
	</body>

	</html>

	<script type="text/javascript">

		function goIndex() {
			setTimeout('go_url()', 5000)  // 5초후 go_url() 함수를 호출한다.
		}

		function go_url() {
			alert('처음으로 돌아갑니다.')
			location.href = './../inven.php'; // 페이지 이동...
		}
	</script>