<?php
//error 결과 출력
error_reporting(E_ALL);

ini_set('display_errors', '1');

?>

<!DOCUTYPE html>
    <html lang="ko">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="./assets/css/style.css" rel="stylesheet">
        <title>index</title>
    </head>

    <body>
        <!-- 헤더 부분 -->
        <header>
            <center>
                <h1>재고 관리</h1><br />
            </center>
        </header>
        <!-- 본문 부분 -->
        <section class="main_body">
            <article>
                <button type="button" id="insertBtn" class="btn btn-primary"
                    onclick="location.href='./management/cpInsert.php'">회사 정보 입력</button><br /><br />
                <button type="button" id="selectBtn" class="btn btn-secondary"
                    onclick="location.href='./management/cpSelect.php'">회사 정보 조회</button><br /><br />
            </article>
        </section>
        <!-- 사이트 정보 부분 -->
        <footer>

        </footer>
    </body>

    </html>