<?php
require_once "db.php";

#index.php에서 조회할 게시글 id 주소로 전달
$id = $_GET['id'];

#posts.* : posts의 모든  컬럼 가져오기
#users.username : users의 username 가져오기
#JOIN : posts테이블의 author_id와 users테이블의 users.id 연결
$sql = "
    SELECT posts.*, users.username
    FROM posts
    JOIN users ON posts.author_id = users.id
    WHERE posts.id = ?
";

#posts.id = ? 값 연결
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
#조회한 게시글을 $post 배열에 저장
$post = mysqli_fetch_assoc($result);

#comments.* : comments의 모든 컬럼 가져오기
#user.username : users의 username 가져오기
#JOIN : comments 테이블의 author_id와 users테이블의 users.id 연결
#WHERE : 특정 id 게시글의 댓글만 가져오기 (조건)
#ORDER BY : 댓글 오름차순 정렬
$comment_sql = "
    SELECT comments.*, users.username
    FROM comments
    JOIN users ON comments.author_id = users.id
    WHERE comments.post_id = ?
    ORDER BY comments.id ASC ";

#WHERE의 특정 id 값 연결
$comment_stmt = mysqli_prepare($conn, $comment_sql);
mysqli_stmt_bind_param($comment_stmt, "i", $id);
mysqli_stmt_execute($comment_stmt);

#댓글 조회 결과를 $comments에 저장
$comments = mysqli_stmt_get_result($comment_stmt);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <style>
        a {
            text-decoration: none;
        }
    </style>
    <title>게시글 보기</title>
</head>
<body>
    <!--게시글 제목-->
    <h1><?= htmlspecialchars($post['title']) ?></h1>

    <!--작성자, 작성일 값-->
    <p>작성자: <?= htmlspecialchars($post['username']) ?></p>
    <p>작성일: <?= $post['created_at'] ?></p>

    <hr>
    <!--게시글 내용 출력-->
    <!--htmlspecialchars() : HTML 태그를 안전하게 문자로 변경-->
    <!--nl2br() : 줄바꿈을 <br>로 변환-->
    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

    <hr>

    <p>
        <!--수정 : edit.php / 삭제 : delete.php / 목록 : index.php로 이동-->
        <a href="edit.php?id=<?= $post['id'] ?>">수정</a>
        <a href="delete.php?id=<?= $post['id'] ?>">삭제</a>
        <a href="index.php">목록</a>
    </p>

    <hr>

    <h2>댓글</h2>

    <!--댓글 존재 확인-->
    <?php if (mysqli_num_rows($comments) > 0): ?>
        <!--댓글을 한 줄씩 반복 출력-->
        <?php while ($comment = mysqli_fetch_assoc($comments)): ?>
            <div>
                <!--댓글 작성자-->
                <p><?= htmlspecialchars($comment['username']) ?></p>
                <!--댓글 내용-->
                <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                <!--작성일-->
                <p>작성일: <?= $comment['created_at'] ?></p>
                <!--수정 : comment_edit / 삭제 : comment_delete-->
                <!--id : 삭제할 댓글 id / post_id : 돌아올 게시글 id-->
                <a href="comment_edit.php?id=<?= $comment['id'] ?>">수정</a>
                <!--id : 삭제할 댓글 id / post_id : 돌아올 게시글 id-->
                <a href="comment_delete.php?id=<?= $comment['id'] ?>&post_id=<?= $post['id'] ?>">삭제</a>
            </div>
            <hr>
        <?php endwhile; ?>
    <!--댓글이 없을 경우-->    
    <?php else: ?>
        <p>댓글이 없습니다.</p>
    <?php endif; ?>

    <h3>댓글 작성</h3>
    <!--댓글 내용 : comment_write.php로 전달-->
    <form action="comment_write.php" method="post">
        <!--게시글 id를 숨겨서 함께 전달-->
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">

        <p>
            <!--댓글 입력-->
            <textarea name="content" rows="4" cols="60" required></textarea>
        </p>
        
        <!--버튼 클릭 시 comment_write.php로 전달-->
        <button type="submit">저장</button>
    </form>
</body>
</html>
