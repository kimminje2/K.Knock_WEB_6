<?php
#db.php : db연결

#mysql 서버의 위치 : localhost
$host = "localhost";
#mysql 계정
$user = "winter_";
$password = "";
#접속할 데이터베이스 이름
$dbname = "board";

#위 설정 정보로 mysql 서버 접속
$conn = mysqli_connect($host, $user, $password, $dbname);

#접속 실패 시 오류 메시지 출력
if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

#php와 mysql 사이 데이터를 주고받을 때 문자셋 : 한글이 깨지는 것을 방지
mysqli_set_charset($conn, "utf8mb4");
?>