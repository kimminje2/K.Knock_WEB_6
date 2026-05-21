<?php
require_once "db.php";

#주소로 넘어온 값을 받음 : ex) comment_delete.php?id=5&post_id=2 : id = 5, post_id = 2
#삭제할 댓글 번호 / 삭제 후 돌아갈 게시글 번호
$id = $_GET['id'];
$post_id = $_GET['post_id'];

#특정 댓글 삭제 : 특정 id의 댓글 삭제
$sql = "DELETE FROM comments WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

#삭제 끝나면 원 게시글로 복귀
header("Location: view.php?id=" . $post_id);
exit;
?>