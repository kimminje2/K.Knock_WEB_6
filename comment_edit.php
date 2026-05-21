<?php
require_once "db.php";
#댓글 수정

#주소에서 수정할 댓글 id 전달
$id = $_GET['id'];

#comments 테이블에서 특정 id 댓글 불러오기
$sql = "SELECT * FROM comments WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
# ? 자리에 들어갈 id 연결
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

#sql 실행 결과 값 comment 배열로 저장
$result = mysqli_stmt_get_result($stmt);
#$comment['id'] / $comments['post_id'] / $comment['author_id'] / $comment['content'] / $comment['created_at']
$comment = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>댓글 수정</title>
</head>
<body>
    <h1>댓글 수정</h1>
    <!--수정 내용을 comment_update.php로 전달-->
    <form action="comment_update.php" method="post">
        <!--수정 댓글 id-->
        <input type="hidden" name="id" value="<?= $comment['id'] ?>">
        <!--수정 후 돌아갈 게시글 id-->
        <input type="hidden" name="post_id" value="<?= $comment['post_id'] ?>">

        <p>
            댓글 내용<br>
            <!--기존 댓글 내용-->
            <textarea name="content" rows="5" cols="60" required><?= htmlspecialchars($comment['content']) ?></textarea>
        </p>
        <!--버튼 클릭 시 comment_update로 전송-->
        <button type="submit">수정</button>
    </form>

    <p>
        <!--원 게시글로 이동-->
        <a href="view.php?id=<?= $comment['post_id'] ?>">취소</a>
    </p>
</body>
</html>