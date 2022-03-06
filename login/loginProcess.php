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

    header('Content-Type: text/html; charset=utf-8');

    $conn = mysqli_connect("localhost", "luminous", "alphatrox2048@@", "luminous");

    $id = $_POST['id'];
    $password = $_POST['password'];

    // DB 정보 가져오기
    $query = "SELECT * FROM member WHERE id ='{$id}'";
    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($result);
    $hashedPassword = isset($row['password']) ? $row['password'] : false;

    // echo $row['id'];
    // DB 정보를 가져왔으니
    // 비밀번호 검증 로직을 실행하면 된다.
    $passwordResult = password_verify($password, $hashedPassword);

    if ($passwordResult === true)
    {
        // 로그인 성공, 세션에 계정 정보 저장
        session_start();
        $_SESSION['id'] = $row['id'];
        $_SESSION['nickname'] = $row['nickname'];
        $_SESSION['exp'] = $row['exp'];
        $_SESSION['role'] = $row['role'];

        ?> 

        <script>

        Swal.fire({
            title: '반갑습니다!',
            html: '곧 메인 페이지로 이동합니다.',
            timer: 1000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                location.href = "../index.php";
            } else {
                location.href = "../index.php";
            }
        })
    
    
        </script>

    <?php

    } else {
    // 로그인 실패
    
    ?>

    <script>

        Swal.fire({
            icon: 'error',
            title: '잘못된 정보',
            text: '로그인 정보가 없거나 잘못되었습니다.'
        }).then((result) => {
            location.href = "./login.php";
        })

    </script>

<?php

    }

?>