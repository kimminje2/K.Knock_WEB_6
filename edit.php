<?php
require_once "db.php";

#게시글 id 가져오기
$id = $_GET['id'];

#posts 테이블에서 id에 해당하는 게시글 가져오기
$sql = "SELECT * FROM posts WHERE id = ?";
#sql 준비
$stmt = mysqli_prepare($conn, $sql);
#sql에 데이터 바인딩 : ?에 id 연결
mysqli_stmt_bind_param($stmt, "i", $id);
#sql 실행 : DB 조회
mysqli_stmt_execute($stmt);

#result = sql 실행 결과
$result = mysqli_stmt_get_result($stmt);
#post = result에서 게시글 데이터 배열
# $post['id'], $post['title'], $post['content'] $post['author_id'] $post['created_at'] 으로 접근 가능
$post = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>게시글 수정</title>
</head>
<body>
    <h1>게시글 수정</h1>

    <!--수정 내용을 edit_process.php로 전달  -->
    <form action="edit_process.php" method="post">
        <!--게시글 번호를 화면에 보이지 않게 함께 전달-->
        <input type="hidden" name="id" value="<?= $post['id'] ?>">

        <p>
            제목<br>
            <!--text 양식에 기존 제목 값을 미리 입력-->
            <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
        </p>

        <p>
            내용<br>
            <!--기존 내용 값을 미리 입력-->
            <textarea name="content" rows="10" cols="60"><?= htmlspecialchars($post['content']) ?></textarea>
        </p>
        <!--버튼 클릭 시 수정 내용 전달-->
        <button type="submit">수정</button>
    </form>

    <p>
        <!--수정 취소시 다시 원 글로 복귀-->
        <a href="view.php?id=<?= $post['id'] ?>">취소</a>
    </p>
</body>
</html>