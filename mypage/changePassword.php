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

    $conn = mysqli_connect("localhost", "luminous", "alphatrox2048@@", "luminous");

    $id = $_SESSION['id'];
    $currentPassword = $_POST['current-password'];
    $newPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
    
    // 사용자가 비밀번호를 바꾸기 위해 입력한 "현재 패스워드" 항목이 진짜 유효한지 검사하고 그럴 경우에만 변경 시행
    $realCurrentPassword = mysqli_fetch_array(mysqli_query($conn, "SELECT password FROM member WHERE id = '$id'"));
    $realCurrentPassword = $realCurrentPassword['password'];


    $passwordVerification = password_verify($currentPassword, $realCurrentPassword);

    if($passwordVerification === true){

        // 인증 성공, 비밀번호 갱신.
        $query = "UPDATE member SET password = '$newPassword' WHERE id = '$id'";
        $result = mysqli_query($conn, $query);

        if($result === false) {

            ?>

            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'UNEXPECTED!',
                    text: '패스워드 갱신에 실패했습니다.',
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

        }else{

            ?>

            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'OK',
                    text: '비밀번호가 변경되었습니다.',
                    footer: '변경된 비밀번호로 다시 로그인 해 보세요.'
                }).then((result) => {
                    location.href = "../logout/logoutProcess.php";
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
                text: '현재 패스워드가 올바르지 않습니다.',
                footer: '현재 비밀번호를 모르신다면 비밀번호 찾기를 시도해 보세요.'
            }).then((result) => {
                location.href = "./mypage.php";
            })

        </script>


        <?php
    
    }


?>