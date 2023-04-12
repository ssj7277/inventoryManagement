<?php
//config
require_once __DIR__ . '/../inc/config.php';

//변수 정리
$arrRtn = array(
    'code' => 500,
    'msg'  => ''
);

error_reporting( E_ALL );

ini_set( 'display_errors', '1' );

//print_r($_POST);

try {

    //변수 정리
    $cpType     = isset( $_POST['cpType'] ) ? $_POST['cpType'] : '';
    $cpName     = isset( $_POST['cpName'] ) ? $_POST['cpName'] : '';
    $cpPhoneNum = isset( $_POST['cpPhoneNum'] ) ? $_POST['cpPhoneNum'] : '';
    $cpFaxNum   = isset( $_POST['cpFaxNum'] ) ? $_POST['cpFaxNum'] : '';
    $cpEmail    = isset( $_POST['cpEmail'] ) ? $_POST['cpEmail'] : '';
    $cpAddress  = isset( $_POST['cpAddress'] ) ? $_POST['cpAddress'] : '';
    $cpRegiNum  = isset( $_POST['cpRegiNum'] ) ? $_POST['cpRegiNum'] : '';
    $cpCeoName  = isset( $_POST['cpCeoName'] ) ? $_POST['cpCeoName'] : '';
    $cpManager  = isset( $_POST['cpManager'] ) ? $_POST['cpManager'] : '';
    $cpUptae    = isset( $_POST['cpUptae'] ) ? $_POST['cpUptae'] : '';
    $cpUpjong   = isset( $_POST['cpUpjong'] ) ? $_POST['cpUpjong'] : '';

    //print_r($_POST);


    //파라미터 체크
    if (empty( $cpType ) || empty( $cpName ) || empty( $cpRegiNum )) {
        $code = 404;
        $msg  = "필수 항목을 입력해 주세요";
        throw new Exception( $msg, $code );
    }

    //Escape String
    $cpType     = $_mysqli->real_escape_string( $cpType );
    $cpName     = $_mysqli->real_escape_string( $cpName );
    $cpPhoneNum = $_mysqli->real_escape_string( $cpPhoneNum );
    $cpFaxNum   = $_mysqli->real_escape_string( $cpFaxNum );
    $cpEmail    = $_mysqli->real_escape_string( $cpEmail );
    $cpAddress  = $_mysqli->real_escape_string( $cpAddress );
    $cpRegiNum  = $_mysqli->real_escape_string( $cpRegiNum );
    $cpCeoName  = $_mysqli->real_escape_string( $cpCeoName );
    $cpManager  = $_mysqli->real_escape_string( $cpManager );
    $cpUptae    = $_mysqli->real_escape_string( $cpUptae );
    $cpUpjong   = $_mysqli->real_escape_string( $cpUpjong );

    //DB Query
    $query = "
        INSERT INTO knCompany ( companyType, name, phone, fax, email, address,
                               regiNumber, ceoName, contactName, uptae, upjong) 
                    VALUES ('{$cpType}', '{$cpName}', '{$cpPhoneNum}', '{$cpFaxNum}', '{$cpEmail}', '{$cpAddress}',
                            '{$cpRegiNum}', '{$cpCeoName}', '{$cpManager}', '{$cpUptae}', '{$cpUpjong}')
                                  
    ";


    if ($_mysqli->query( $query ) === TRUE) {

        echo "회사 정보가 정상적으로 제출 되었습니다.";
    } else {
        echo "error";
    }


} catch (mysqli_sql_exception $e) {
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();
    echo json_encode( $arrRtn );
} catch (Exception $e) {
    $arrRtn['code'] = $e->getCode();
    $arrRtn['msg']  = $e->getMessage();
    echo json_encode( $arrRtn );
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
            setTimeout('go_url()', 5000) // 5초후 go_url() 함수를 호출한다.
        }

        function go_url() {
            alert('처음으로 돌아갑니다.')
            location.href = './../index.php'; // 페이지 이동...
        }
    </script>