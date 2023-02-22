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
    $page              = !empty($_GET['page'])              	? $_GET['page']            		: 1;
    $searchType        = isset($_GET['searchType'])          	? $_GET['searchType']       	: '';
    $searchText        = isset($_GET['searchText'])	        	? $_GET['searchText']     		: '';

    //필수 파라미터 체크
    if (!is_numeric($page)) {
        $page  = 1;
    }


    //변수 정리
    $size           = PAGING_SIZE;
    $offset         = ($page - 1) * $size;
    $scale          = PAGING_SCALE;
    $where          = '';
	$total			= 0;
	
	//검색
	$searchType		= $_mysqli->real_escape_string($searchType);
	$searchText		= $_mysqli->real_escape_string($searchText);
	if($searchText) {
		$where	.="AND {$searchType} LIKE '%{$searchText}%' ";
	}


    //DB 회사조회
    $query = "
        SELECT SQL_CALC_FOUND_ROWS *, IFNULL(counter, 0) AS counter
        FROM knCompany A LEFT JOIN (SELECT cpNum, COUNT(*) AS counter FROM comments WHERE isActive = 'y'  GROUP BY cpNum) B ON A.serial = B.cpNum
        WHERE 1 AND isActive = 'y'
            {$where}
        ORDER BY serial desc
        LIMIT {$offset}, {$size}
    ";
		

    $cp_result = $_mysqli->query($query);
    if (!$cp_result) {
        $code   = 502;
        $msg    = "조회 중 오류가 발생했습니다.(code {$code})\n관리자에게 문의해 주세요.";
        throw new mysqli_sql_exception($msg, $code);
    }
		
	
    $sub_result     = $_mysqli->query("SELECT FOUND_ROWS() AS total");
    $sub_dbarray    = $sub_result->fetch_array();
    $total          = $sub_dbarray['total'];
    $sub_result->free();

    //페이징
    $arrParams  = array(
        'searchType'    => $searchType,
        'searchText'   	=> $searchText
    );
    $param      = http_build_query($arrParams);
    $_pg    	= new PAGING($total, $page, $arrParams, $size, $scale);
	
	
	
	//검색
	$searchType		= $_mysqli->real_escape_string($searchType);
	$searchText		= $_mysqli->real_escape_string($searchText);
	if($searchText) {
		$where	.="AND {$searchType} LIKE '%{$searchText}%' ";
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
			<h2>회사 조회</h2>
		</center>
	</header>
	<!-- 본문 부분 -->
	<section class="main_body">
		<article class="select_body">
			<!-- contents -->
			<div id="contents">
				<div class="list-header">
					<div class="page-view">
						<span class="num">전체 <b><?php echo $total ?></b>건</span>
					</div>
					<!-- 상세페이지  -->
					<form id="company_list" action="cpSelect_detail.php" method="post" enctype="multipart/form-data">
							<input type="hidden" name="seq" id="seq" value="">
							<input type="hidden" name="page" id="page" value="<?php echo $page ?>" >
							<input type="hidden" name="searchType" id="searchType" value="<?php echo $searchType ?>" >
							<input type="hidden" name="searchText" id="searchText" value="<?php echo $searchText ?>" >
					</form>
					<!-- 검색 -->
					<form id="searchForm" method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
						<fieldset class="select_filedset">
						<select title="검색항목선택" label="검색항목선택" class="form-category" name="searchType" id="searchType">
							<option value="name">회사명</option>
							<option value="address">회사주소</option>
						</select>
						<span class="input-group">
							<input type="text" placeholder="검색어를 입력하세요." class="form-keyword" label="검색어" title="검색어" name="searchText" id="searchText" />
							<button type="submit" class="btn-search" title="검색버튼" label="검색버튼">검색</button>
						</span>
						</fieldset>
					</form>
				</div>
				<!-- list -->
				<table class="select_table">
					<colgroup>
						<col width = "4%"/>
						<col width = "7%"/>
						<col width = "10%"/>
						<col width = "10%"/>
						<col width = "10%"/>
						<col width = "auto"/>
						<col width = "8%"/>
						<col width = "auto"/>
						<col width = "auto"/>
						<col width = "auto"/>
						<col width = "auto"/>
						<col width = "auto"/>
						<col width = "4%"/>
					</colgroup>
					<thead>
						<tr>
							<th>번호</th>
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
							<th>댓글</th>
						</tr>
					</thead>
					<tbody>
					<?php
					//회사 리스트
					if ($total > 0) {
						$no     = $total - $offset;
						while ($dbCp = $cp_result->fetch_assoc()) {
							$cpName = mb_strimwidth($dbCp['name'], 0, 64, "...", "utf-8");
							$cpSeq  = $dbCp['serial']; ?>
							<tr>
								<td><?php echo $no ?></td>
								<td><?php echo $dbCp['companyType'] ?></td>
								<td><button type="button" class="btn btn-outline-dark" id=<?php echo $cpSeq ?> onclick="cp_click(this.id)"><?php echo $cpName ?></button></td>
								<td><?php echo $dbCp['phone'] ?></td>
								<td><?php echo $dbCp['fax'] ?></td>
								<td><?php echo $dbCp['address'] ?></td>
								<td><?php echo $dbCp['ceoName'] ?></td>
								<td><?php echo $dbCp['email'] ?></td>
								<td><?php echo $dbCp['regiNumber'] ?></td>
								<td><?php echo $dbCp['contactName'] ?></td>
								<td><?php echo $dbCp['uptae'] ?></td>
								<td><?php echo $dbCp['upjong'] ?></td>
								<td><?php echo $dbCp['counter'] ?></td>
							</tr>
							<?php $no--; 
						}
					} else {
						?>
							<tr>
								<td colspan="12">등록된 회사가 없습니다.</td>
							</tr>  <?php
			     	}	?>
					</tbody>
				</table>
			</div>
			<div class="table-pagination">
              <ul class="pagination">
                  <?=$_pg->getPaging();?>
              </ul>
			</div>
		</article>
	</section>
	<!-- 사이트 정보 부분 -->
	<footer>
		<button type="button" class="btn btn-secondary" onclick="location.href='./../inven.php'">돌아가기</button>
	</footer>
</body>
</html>
<script>
//데이터 필수 입력 체크
    function Checkform(){		
		if( frm.cpName.value == ""){
            frm.cpName.focus();
            alert("회사명을 입력해 주십시오.");

            return false;
        }
		if( frm.cpCeoName.value == ""){
            frm.cpCeoName.focus();
            alert("대표자명을 입력해 주십시오.");

            return false;
        }
        if( frm.cpRegiNum.value == ""){
            frm.cpRegiNum.focus();
            alert("사업자 등록번호 또는 개인사업자의 경우 주민번호를 입력해 주십시오.");

            return false;
        }
    }
	
	function cp_click(clicked_id){
        //alert(clicked_id);
		var myElement   = document.getElementById("seq");
		myElement.value = clicked_id;
		document.getElementById('company_list').submit();
    }
</script>
