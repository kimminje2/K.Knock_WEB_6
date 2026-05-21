<?php
require_once "db.php";

#주소에서 게시글 id 전달
$id = $_GET['id'];

#comments.post_id가 posts.id 참고 => 댓글 먼저 삭제 후 게시글 삭제
#외래키 오류 발생 가능
#댓글 삭제
$sql = "DELETE FROM comments WHERE post_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

#게시글 삭제
$sql = "DELETE FROM posts WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

#게시글 목록으로 복귀
header("Location: index.php");
exit;
?>