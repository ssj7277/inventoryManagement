<?php
	//config
	require_once __DIR__ .'/../inc/config.php';
	require_once __DIR__ .'/../lib/paging.php';
	
	//변수 정리
	$arrRtn     = array(
    'code'  => 500,
    'msg'   => ''
	);

	
	try {
		
		//파라미터 정리
		$cpSerial       = isset($_POST['seq'])				?	$_POST['seq']     			: 0;
		$page			= isset($_POST['page'])				?	$_POST['page']				: 1;
		$searchType		= isset($_POST['searchType'])		?	$_POST['searchType']		: '';
		$searchText		= isset($_POST['searchText'])		?	$_POST['searchText']		: '';
		
		//필수 파라미터 체크
		if (!is_numeric($cpSerial)) {
			$cpSerial  = 0;
		}
		
		//DB 회사 조회
		$query1 = "
        SELECT * FROM knCompany
		WHERE serial = {$cpSerial}
		";
		
		$cp_result		= $_mysqli->query($query1);
		
		//DB 댓글 조회
		$query2 = "
        SELECT * FROM comments
		WHERE cpNum = {$cpSerial} AND isActive = 'y'
		";
	
		$comm_result	= $_mysqli->query($query2);
		if (!$cp_result || !$comm_result) {
			$code   = 502;
			$msg    = "조회 중 오류가 발생했습니다.(code {$code})\n관리자에게 문의해 주세요.";
			throw new mysqli_sql_exception($msg, $code);
		}
		//DB 회사 조회
		$dbCp = $cp_result->fetch_array();
		
		//DB 댓글 행 조회
		$dbCommRows = $comm_result->num_rows;
		
		//print_r($query);
		
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

<!DOCTYPE html>
<html lang="ko">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
		<link href="./../assets/css/style.css" rel="stylesheet">
		<title>select</title>
	</head>
	<body>
		<!-- 헤더 부분 -->
		<header>
			<center>
			</center>
		</header>
		<!-- 본문 부분 -->
		<section class ="main_body">
			<article class="select_body">
				<!-- contents -->
				<div id="contents">
					<div class="content-header">
						<h2>회사 상세조회</h2>
					</div>
					<!-- 상세조회 -->
					<div>
						<table class="select_table" id="cpTable">
							<colgroup>
								<col width = "auto"/>
								<col width = "8%"/>
								<col width = "auto"/>
								<col width = "auto"/>
								<col width = "auto"/>
								<col width = "auto"/>
								<col width = "auto"/>
								<col width = "auto"/>
								<col width = "auto"/>
								<col width = "auto"/>
								<col width = "auto"/>
							</colgroup>
							<thead>
								<tr>
									<th>회사유형</th>
									<th>회사명</th>
									<th>회사전화번호</th>
									<th>회사팩스번호</th>
									<th>회사주소</th>
									<th>대표자명</th>
									<th>대표 이메일</th>
									<th>사업자 등록번호</th>
									<th>담당자 이름</th>
									<th>업태</th>
									<th>업종</th>
								</tr>
							</thead>
							<tbody>
								<!-- 회사 리스트 -->
								<tr>
									<td><?php echo $dbCp['companyType'] ?></td>
									<td><?php echo $dbCp['name'] ?></td>
									<td><?php echo $dbCp['phone'] ?></td>
									<td><?php echo $dbCp['fax'] ?></td>
									<td><?php echo $dbCp['address'] ?></td>
									<td><?php echo $dbCp['ceoName'] ?></td>
									<td><?php echo $dbCp['email'] ?></td>
									<td><?php echo $dbCp['regiNumber'] ?></td>
									<td><?php echo $dbCp['contactName'] ?></td>
									<td><?php echo $dbCp['uptae'] ?></td>
									<td><?php echo $dbCp['upjong'] ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- 댓글 불러오기 -->	
				<div class="">
					<div class="comment_view">
						<h3>Comment</h3><hr />
						<div class="" style="margin-left:0px";>
							<table class="select_table_comment" id="commentTable" >
								<colgroup>
									<col width = "45%"/>  <!-- 내용 -->
									<col width = "12%"/> <!-- 작성자 -->
									<col width = "25%"/> <!-- 작성일 -->
									<col width = "auto"/> <!-- 삭제 버튼 -->
								</colgroup>
								<thead><?php
									if($dbCommRows > 0){ ?>
									<tr>
										<th>내용</th>
										<th>작성자</th>
										<th>작성일</th>
										<th>삭제</th>
									</tr><?php } ?>
								</thead>
								<tbody>
									<?php
										//댓글 리스트
										if($dbCommRows > 0) {
											$no		= $dbCommRows;
											while ($dbComm = $comm_result->fetch_array()) {
												//변수 정리
												$commSerial		= $dbComm['serial'];
												$commContent	= $dbComm['content'];
												$commName		= $dbComm['name'];
												$commDate 		= $dbComm['enterdate'];
											?>
											<tr>
												<td style="text-align:left";><?php echo $commContent; ?></td>
												<td><?php echo $commName; ?></td>
												<td><?php echo $commDate; ?></td>
												<td><button type="button" onclick="commentDelete()" class="btn btn-outline-danger">삭제</button></td>
											</tr>
											<?php $no--;
												}
											} else {
										?>
										<tr>
											<!-- <td colspan="5"></td> -->
										</tr> <?php
										} 	?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- /댓글 불러오기 -->
				<!-- 댓글 작성 -->			
				<div class="comment_edit">
					<form method="post" name="commEditForm" id="commEditForm">
						<input type="hidden" name="cpNum" value="<?php echo $cpSerial; ?>">
						<input type="text" name="commEditUser" id="commEditUser" class="" size="15" maxlength="10" placeholder="작성자">
						<div class="">
							<textarea class="commContent" name="commContent" id="commContent"maxlength="100" placeholder="내용"></textarea>
							<button type="button" id="commEditBtn" class="btn btn-success">작성</button>
						</div>
					</form>
				</div>		
				<!--/댓글 작성 -->
			</article>
			<br/><hr /><br />
			<!-- edit -->
			<article>
				<form class="insert_frm" action="cpModify_result.php" method="post" id="modifyCp" name="frm">
					<div class="mb-3 mt-3">
						<!-- 서칭 값-->
						<input type="hidden" name="searchType" id="searchType" value="<?php echo $searchType; ?>">
						<input type="hidden" name="searchText" id="searchText" value="<?php echo $searchText; ?>">
						<!-- /서칭 값-->
						<input type="hidden" id="" name="seq" value="<?php echo $cpSerial; ?>">
						
						<label for="cpType" class="form-label">회사유형:</label><br>
						<input type="radio" id="cpType_solo" name="cpType" value="개인">
						<label for="cpType_solo">개인사업자</label>
						<input type="radio" id="cpType_cp" name="cpType" value="법인">
						<label for="cpType_cp">법인사업자</label><br>
						
						<label for="cpName" class="form-label">회사명:</label>
						<input type="text" class="form-control" id="cpName" name="cpName" maxlength="10" placeholder="예) 교농" value="<?php echo $dbCp['name']; ?>" required>
						
						<label for="cpPhoneNum" class="form-label">회사 전화번호:</label>
						<input type="text" class="form-control" id="cpPhoneNum" name="cpPhoneNum" placeholder="예) 010-1234-7890" maxlength="20" value="<?php echo $dbCp['phone']; ?>">
						
						<label for="cpFaxNum" class="form-label">회사 팩스번호:</label>
						<input type="text" class="form-control" id="cpFaxNum" name="cpFaxNum" placeholder="예) 033-1234-5678" maxlength="20" value="<?php echo $dbCp['fax'] ?>">
						
						<label for="cpEmail" class="form-label">대표 이메일:</label>
						<input type="email" class="form-control" id="cpEmail" name="cpEmail" placeholder="example@gmail.com" value="<?php echo $dbCp['email'] ?>">
						
						<label for="cpAddress" class="form-label">회사 주소:</label>
						<input type="text" class="form-control" id="cpAddress" name="cpAddress" placeholder="예) 서울시 강남구 삼성동 16-1" value="<?php echo $dbCp['address'] ?>">
						
						<label for="cpRegiNum" class="form-label">사업자 등록번호:</label>
						<input type="text" class="form-control" id="cpRegiNum" name="cpRegiNum" placeholder="개인사업자는 주민번호를 입력바랍니다." maxlength="20" value="<?php echo $dbCp['regiNumber'] ?>">
						
						<label for="cpCeoName" class="form-label">대표자 성함:</label>
						<input type="text" class="form-control" id="cpCeoName" name="cpCeoName" placeholder="예) 홍길동" value="<?php echo $dbCp['ceoName'] ?>">
						
						<label for="cpManager" class="form-label">담당자 이름:</label>
						<input type="text" class="form-control" id="cpManager" name="cpManager" placeholder="예) 임꺽정" value="<?php echo $dbCp['contactName'] ?>">
						
						<label for="cpUptae" class="form-label">업태:</label>
						<input type="text" class="form-control" id="cpUptae" name="cpUptae" placeholder="예) 농업, 축산업, 음식업" value="<?php echo $dbCp['uptae'] ?>">
						
						<label for="cpUpjong" class="form-label">업종:</label>
						<input type="text" class="form-control" id="cpUpjong" name="cpUpjong" placeholder="예) 작물재배업, 축산, 임업" value="<?php echo $dbCp['upjong'] ?>">
					</div>
					<div class="d-grid gap-2 d-md-block">
						<button type="button" onclick="cpModify()" class="btn btn-outline-primary"><b>수정</b></button>
						<button type="button" onclick="cpDelete()" class="btn btn-outline-danger"><b>삭제</b></button>
						<button type="button" class="btn btn-outline-dark" onclick="javascript:history.back();"><b>취소</b></button>
					</div>
				</form>
				<!-- /edit -->
				<!-- 회사정보 삭제 -->
				<form id="cpDelete" action="cpDelete_result.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="seq" id="seq" value="<?php echo $cpSerial; ?>">
					<input type="hidden" name="name" id="name" value="<?php echo $dbCp['name']; ?>">
					<input type="hidden" name="searchType" id="searchType" value="<?php echo $searchType; ?>">
					<input type="hidden" name="searchText" id="searchText" value="<?php echo $searchText; ?>">
				</form>
				<!-- /삭제 -->
				<!-- 돌아가기 -->
				<form id="serchBack" action="cpSelect.php" method="get" enctype="multipart/form-data">
					<input type="hidden" name="searchType" id="searchType" value="<?php echo $searchType; ?>">
					<input type="hidden" name="searchText" id="searchText" value="<?php echo $searchText; ?>">
				</form>
				<!-- /돌아가기 -->
			</article>
		</section>
		</hr />
		<!-- 사이트 정보 부분 -->
		<footer>
			<!-- //list -->
			<button type="button" class="btn btn-secondary" onclick="detail_back()">돌아가기</button>
			<!--<p class="footer_p">사이트 정보 표시</p>-->
		</footer>
	</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script type="text/javascript">
	<?php
		$cpType = $dbCp['companyType'];
		echo "let cpType	= '$cpType';";		echo "let cpSerial	= '$cpSerial';";
	?>
	window.onload = function(){
		let cpTypeSolo = document.getElementById('cpType_solo');
		let cpTypeCP = document.getElementById('cpType_cp');
		if(cpType == '개인'){
			cpTypeSolo.checked = true;
		}
		if(cpType == '법인'){
			cpTypeCP.checked = true;
		}
	}
	//회사정보 수정
	function cpModify(){
		let inputChk = Checkform();
		if(inputChk){
			let modifyResult = confirm("수정하시겠습니까??");	
			if(modifyResult){
				document.getElementById('modifyCp').submit();
			} else alert("취소하셨습니다.");
		}
	}
	//회사정보 삭제
	function cpDelete(){
		let deleteResult = confirm("삭제하시겠습니까??");
		if(deleteResult){
			document.getElementById('cpDelete').submit();
		} else alert("취소하셨습니다.");
	}
	
	//데이터 필수 입력 체크
    function Checkform(){
        if( frm.cpName.value == ""){
            frm.cpName.focus();
            alert("회사명을 입력해 주십시오.");
			
            return 0;
			}else if( frm.cpPhoneNum.value == ""){
            frm.cpPhoneNum.focus();
            alert("회사 전화번호를 입력해 주십시오.");
			
            return 0;
			}else if( frm.cpAddress.value == ""){
            frm.cpAddress.focus();
            alert("회사 주소를 입력해 주십시오.");
			
            return 0;
			}else if( frm.cpRegiNum.value == ""){
            frm.cpRegiNum.focus();
            alert("사업자 등록번호 또는 개인사업자의 경우 주민번호를 입력해 주십시오.");
			
            return 0;
			}else if( frm.cpCeoName.value == ""){
            frm.cpCeoName.focus();
            alert("대표자명을 입력해 주십시오.");
			
            return 0;
		} else return 1;
	}
	
	function detail_back(){
		document.getElementById('serchBack').submit();
	}
	
	//댓글 생성
	document.getElementById("commEditBtn").addEventListener('click', commEditBtn);	
	function commEditBtn(){
        location.href="javascript:void(0)";
        if ($.trim($("#commEditUser").val()) == "") {
            alert("작성자를 입력해주세요.");
            $("#commEditUser").focus();
            return false;
		}
        
        if ($.trim($("#commContent").val()) == "") {
            alert("댓글 내용을 입력해 주세요.");
            $("#commContent").focus();
            return false;
		}		
		
		let formData = new FormData($("#commEditForm")[0]);
		
        $.ajax({
            url: "commentEditProc.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
				console.log(data);
				alert('댓글이 작성되었습니다.');
                var json = JSON.parse(data);
                if (json.code == 200) {
                    location.reload();
				} 
			},
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
			}
		});
	}
	//_댓글 생성
	
	//댓글 삭제	function commentDelete(){
		let commentList = document.getElementById('commentTable');
			for (let i = 1; i < commentList.rows.length; i++) {
				commentList.rows[i].cells[3].onclick = function () {
					let userName	= commentList.rows[i].cells[1].innerText;
					let enterDate	= commentList.rows[i].cells[2].innerText;
					
					//form data 생성 삽입
					let delFormData = new FormData();
					delFormData.append('cpNum', cpSerial);
					delFormData.append('userName', userName);
					delFormData.append('enterDate', enterDate);
					
					//jQuery ajax
					$.ajax({
						url: "commentDelProc.php",
						type: "POST",
						data: delFormData,
						contentType: false,
						processData: false,
						success: function (data) {
							console.log(data);
							alert('댓글이 삭제되었습니다.');
							var json = JSON.parse(data);
							if (json.code == 200) {
								location.reload();
							}
						},
						error: function (jqXHR, textStatus, errorThrown) {
							console.log(textStatus, errorThrown);
						}
					});
					//jQuery ajax.
					
					/* 
					// vanilla JS
					//string 전송 data 생성
					let delData = 'cpNum=' + cpSerial + '&userName=' + userName + '&enterDate=' + enterDate;
					
					var xhr = new XMLHttpRequest();
					xhr.open('POST', 'commentDelProc2.php');
					xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					xhr.onload = function() {
						if (xhr.status === 200){
							console.log(xhr.responseText);
							location.reload();
							
						} else if (xhr.status !== 200){
							alert('Request failed. Returned status of' + xhr.status);
						}
						
					};
					xhr.send(delData);	
					
					// vanilla JS.
					*/ 
				}
			}
		};
	//댓글 삭제.
		
</script>