<?php
require_once "db.php";

#comment_edit.php의 form에서 데이터 전달
#수정할 댓글 id
$id = $_POST['id'];
#수정 후 돌아갈 게시글 id
$post_id = $_POST['post_id'];
#수정한 댓글 내용
$content = $_POST['content'];

#id가 일치하는 댓글 업데이트
$sql = "
    UPDATE comments
    SET content = ?
    WHERE id = ?
";

#sql 준비
$stmt = mysqli_prepare($conn, $sql);
#?에 들어갈 값 연결 : content = string / id = integer
mysqli_stmt_bind_param($stmt, "si", $content, $id);
#sql 실행
mysqli_stmt_execute($stmt);

#수정 후 원 게시글로 이동
header("Location: view.php?id=" . $post_id);
exit;
?>