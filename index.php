<?php 
#index.php : 게시글 목록을 가져와 표로 보여줌

#db.php 파일을 불러옴 : $conn 변수에 데이터베이스 연결 정보 저장 : 사용가능
require_once "db.php";

#SELECT : posts.id(글 번호) / posts.title(글 제목) / posts.created_at(작성일) / users.username(작성자)를 가져옴
#JOIN : posts 테이블, users 테이블을 author_id와 id로 연결
# ㄴ posts.author_id->users.id에서 username을 가져옴
#ORDER BY : 글 번호 기준 내림차순 정렬
$sql = "
    SELECT posts.id, posts.title, posts.created_at, users.username
    FROM posts
    JOIN users ON posts.author_id = users.id
    ORDER BY posts.id DESC";

#result : sql 실행 및 결과 저장
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        td {
            padding: 5px;
            border-right: 1px solid gray;
            text-align: center;
        }
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <!--메인 페이지-->
    <h1>게시판</h1>
    <hr>
    <p>
        <!--글쓰기 버튼 : 클릭 시 write.php로 이동-->
        <a href="write.php">
            <button type = "button">글쓰기</button>
        </a>
    </p>

    <table style = "border-collapse: collapse; width: 100%;">
        <tr style = "border-bottom: 2px solid black;">
            <th>no.</th>
            <th>제목</th>
            <th>작성자</th>
            <th>작성일</th>
        </tr>
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <!--게시글이 있는지 확인 : $result가 존재하고, 조회된 게시글 수가 1개 이상-->
            <?php while ($posts = mysqli_fetch_assoc($result)) : ?>
                <!--게시글 한 줄 씩 가져와 $posts 배열에 저장 : 게시글 번호, 제목, 작성자, 작성일-->
                <tr style = "border-bottom: 1px solid gray;">
                    <td><?= $posts['id'] ?></td>
                    <!--글 제목 출력 및 클릭 시 view.php?id= n 으로 이동 | n : $posts['id']를 파라미터로 전달-->
                    <td><a href="view.php?id=<?= $posts['id'] ?>"><?= $posts['title'] ?></a></td>
                    <td><?= $posts['username'] ?></td>
                    <td><?= $posts['created_at'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <!--게시글이 없는 경우-->
            <tr>
                <td colspan="4" style = "border-right: none; padding: 30px; text-align: center;">게시글이 없습니다.</td>
            </tr>
        <?php endif; ?>    
    </table>
</body>
</html>