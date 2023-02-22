<?php
	//config
	require_once('/var/www/html/inven/inc/config.php');
	//require_once('./../inc/config.php');

	$arrRtn     = array(
		'code'  => 500,
		'msg'   => ''
	);

?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
	<link href="./../assets/css/style.css" rel="stylesheet">
	<title>index</title>
</head>
<body>
	<!-- 헤더 부분 -->
	<header>
		<center>
		</center>
	</header>
	<!-- 본문 부분 -->
	<section class="insert_body">
		<div>
			<h2>정보 입력</h2><br />
		</div>
		<article>
			<form name="add_form_entry" id="add_form_entry" method="post" action="excel_file_read.php" enctype="multipart/form-data">
				<label for="inputFileName"></label>
				<input type="file" name="inputFileName" size="40">
				<input type="submit" value="확인">
			</form>
		</article>
		<article>
			<form class="insert_frm" action="cpInsert_result.php" method="post" name="frm" onSubmit="return Checkform()">
                <div class="mb-3 mt-3">
                    <label for="cpType" class="form-label">회사유형:</label><br>
                    <!--<input type="text" class="form-control" id="cpType" name="cpType" placeholder="예)개인, 법인">-->
					<input type="radio" id="cpType" name="cpType" value="개인" checked>
					<label for="cpType_solo">개인사업자</label>
					<input type="radio" id="cpType" name="cpType" value="법인">
					<label for="cpType_cp">법인사업자</label><br>

                    <label for="cpName" class="form-label">회사명:</label>
                    <input type="text" class="form-control" id="cpName" name="cpName" maxlength="10" placeholder="예) 교농">

                    <label for="cpPhoneNum" class="form-label">회사 전화번호:</label>
                    <input type="text" class="form-control" id="cpPhoneNum" name="cpPhoneNum" placeholder="예) 010-1234-7890" maxlength="20">

                    <label for="cpFaxNum" class="form-label">회사 팩스번호:</label>
                    <input type="text" class="form-control" id="cpFaxNum" name="cpFaxNum" placeholder="예) 033-1234-5678" maxlength="20">

                    <label for="cpEmail" class="form-label">대표 이메일:</label>
                    <input type="email" class="form-control" id="cpEmail" name="cpEmail" placeholder="example@gmail.com">

                    <label for="cpAddress" class="form-label">회사 주소:</label>
                    <input type="text" class="form-control" id="cpAddress" name="cpAddress" placeholder="예) 서울시 강남구 삼성동 16-1">

                    <label for="cpRegiNum" class="form-label">사업자 등록번호:</label>
                    <input type="text" class="form-control" id="cpRegiNum" name="cpRegiNum" placeholder="개인사업자는 주민번호를 입력바랍니다." maxlength="20">

                    <label for="cpCeoName" class="form-label">대표자 성함:</label>
                    <input type="text" class="form-control" id="cpCeoName" name="cpCeoName" placeholder="예) 홍길동">

                    <label for="cpManager" class="form-label">담당자 이름:</label>
                    <input type="text" class="form-control" id="cpManager" name="cpManager" placeholder="예) 임꺽정">

                    <label for="cpUptae" class="form-label">업태:</label>
                    <input type="text" class="form-control" id="cpUptae" name="cpUptae" placeholder="예) 농업, 축산업, 음식업">

                    <label for="cpUpjong" class="form-label">업종:</label>
                    <input type="text" class="form-control" id="cpUpjong" name="cpUpjong" placeholder="예) 작물재배업, 축산, 임업">
                </div>
				<div class="d-grid gap-2 d-md-block">
					<button type="submit" class="btn btn-success">작성</button>
					<button type="button" class="btn btn-dark" onclick="javascript:history.back();">취소</button>
				</div>
			</form>
		</article>
	</section>
    <!-- 사이트 정보 부분 -->
	<footer>
		<br />
		<button type="button" class="btn btn-secondary" onclick="location.href='./../inven.php'">돌아가기</button>
	</footer>
</body>
</html>
<script>
    //데이터 필수 입력 체크
    function Checkform(){
        if( frm.cpType.value == ""){
            frm.cpType.focus();
            alert("회사 유형을 입력해 주십시오.");

            return false;
        }
        if( frm.cpName.value == ""){
            frm.cpName.focus();
            alert("회사명을 입력해 주십시오.");

            return false;
        }
        if( frm.cpPhoneNum.value == ""){
            frm.cpPhoneNum.focus();
            alert("회사 전화번호를 입력해 주십시오.");

            return false;
        }
        if( frm.cpAddress.value == ""){
            frm.cpAddress.focus();
            alert("회사 주소를 입력해 주십시오.");

            return false;
        }
        if( frm.cpRegiNum.value == ""){
            frm.cpRegiNum.focus();
            alert("사업자 등록번호 또는 개인사업자의 경우 주민번호를 입력해 주십시오.");

            return false;
        }
        if( frm.cpCeoName.value == ""){
            frm.cpCeoName.focus();
            alert("대표자명을 입력해 주십시오.");

            return false;
        }
    }
</script>