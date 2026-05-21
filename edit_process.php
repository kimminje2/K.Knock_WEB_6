<?php
require_once "db.php";
#edit에서 수정한 제목/내용을 받아서 업데이트

#edit의 form에서 넘어온 데이터
$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];

# posts 테이블 : id 값이 일치하는 레코드 업데이트
$sql = "
    UPDATE posts
    SET title = ?, content = ?
    WHERE id = ?
";

#sql 준비
$stmt = mysqli_prepare($conn, $sql);
#sql에 데이터 바인딩 : ?에 실제 데이터 연결
#ssi : title = string, content = string, id = integer
mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $id);
#sql 실행 : 실제 DB 수정
mysqli_stmt_execute($stmt);

#view.php로 이동 : 수정된 글 확인 가능
header("Location: view.php?id=" . $id);
exit;
?>