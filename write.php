<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>글쓰기</h1>
    <!-- 글쓰기 폼 : 입력한 제목, 내용 write_process.php로 post 방식 전송 -->
    <form action="write_process.php" method="post">
        <p>
            <label for="title">제목</label><br>
            <input type="text" name="title" id="title">
        </p>
        <p>
            <label for="content">내용</label><br>
            <textarea name="content" id="content" cols="30" rows="10"></textarea>
        </p>
        <p>
            <button type="submit">작성</button>
        </p>
</body>
</html>