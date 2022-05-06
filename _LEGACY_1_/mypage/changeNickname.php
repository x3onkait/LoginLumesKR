<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN.LUMES.KR</title>
    <link rel="stylesheet" href="./css/mypage.css">
    <link rel="shortcut icon" href="/favicon/logo.png">

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- end of sweetalert -->

</head>

<body>
    <!-- 프로세스 처리 구간이라서 굳이 뭘 할 건 없음. -->
</body>

<?php

    session_start();
    header('Content-Type: text/html; charset=utf-8');

    // DB connection
    require(dirname(__FILE__) . "/../dbconnection.php");

    $id = $_SESSION['id'];
    $currentNickname = $_POST['current-nickname'];
    $newNickname = $_POST['new-nickname'];

    // 사용자가 닉네임을 바꾸기 위해 입력한 "현재 닉네임" 항목이 진짜 유효한지 검사하고 그럴 경우에만 변경 시행
    $realCurrentNickname = mysqli_fetch_array(mysqli_query($conn, "SELECT nickname FROM member WHERE id = '$id'"));
    $realCurrentNickname = $realCurrentNickname['nickname'];

    if($currentNickname === $realCurrentNickname) {

        // 인증 성공, 닉네임 갱신.
        $query = "UPDATE member SET nickname = '$newNickname' WHERE id = '$id'";
        $result = mysqli_query($conn, $query);

        if($result === false) {

            ?>

            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'UNEXPECTED!',
                    text: '닉네임 갱신에 실패했습니다.',
                    footer: '관리자에게 문의하세요.'
                }).then((result) => {
                    Swal.fire({
                        icon: 'info',
                        title: '에러 메시지',
                        text: '아래 에러 메시지를 관리자에게 보여주세요.',
                        footer: <?php echo mysqli_error($conn) ?>
                    }).then((result) => {
                        location.href = "../logout/logoutProcess.php";
                    });
                });

            </script>

            <?php

        } else {

            ?>

            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'OK',
                    text: '닉네임이 변경되었습니다.',
                    footer: '마이페이지에 변경된 닉네임을 확인해 보세요!'
                }).then((result) => {
                    <?php $_SESSION['nickname'] = $newNickname ?>
                    location.href = "./mypage.php";
                })
            </script>

            <?php

        }

    } else {

        ?>

        <script>
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: '현재 닉네임이 올바르지 않습니다.',
                footer: '마이페이지에서 제대로 된 닉네임을 확인해 보세요.'
            }).then((result) => {
                location.href = "./mypage.php";
            })
        </script>

        <?php

    }

?>