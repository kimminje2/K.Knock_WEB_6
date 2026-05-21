<?php
require_once "db.php";
#댓글 작성 처리

#view.php의 댓글 form에서 데이터 전달
$post_id = $_POST['post_id'];
$content = $_POST['content'];
#임의 고정
$author_id = 1;

#comments 테이블에 댓글 추가
#post_id : 게시글 id
#author_id : 작성자
#content : 댓글 내용
$sql = "
    INSERT INTO comments (post_id, author_id, content)
    VALUES (?, ?, ?)
";

#VALUES (?, ?, ?)에 값 연결
$stmt = mysqli_prepare($conn, $sql);
#post_id : integer / author_id : integer / content : string
mysqli_stmt_bind_param($stmt, "iis", $post_id, $author_id, $content);
mysqli_stmt_execute($stmt);

#저장 후 원 게시글로 이동
header("Location: view.php?id=" . $post_id);
exit;
?>