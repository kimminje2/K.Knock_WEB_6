<?php
require_once "db.php";

#write의 form에서 넘어온 데이터
$title = $_POST['title'];
$content = $_POST['content'];
#author_id는 임시로 1로 고정(test용)
$author_id = 1;

#제목이 비어있는 경우 상세 페이지 이동 불가 예외 처리
#trim() : 문자열 앞뒤 공백 제거 => 제목이 공백으로만 입력된 경우도 포함
if (trim($title) === "") 
{
    echo "<script>
            alert('제목을 입력해주세요.');
            history.back();
          </script>";
    exit;
}

#게시글 posts 테이블 삽입
$sql = "INSERT INTO posts (title, content, author_id) VALUES (?, ?, ?)";
#sql 준비
$stmt = mysqli_prepare($conn, $sql);
#sql에 데이터 바인딩 : ?에 실제 데이터 연결
#ssi : title = string, content = string, author_id = integer
mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $author_id);
#sql 실행 : 실제 DB 수정
mysqli_stmt_execute($stmt);

#게시글 목록 index.php로 이동
header("Location: index.php");
exit;
?>