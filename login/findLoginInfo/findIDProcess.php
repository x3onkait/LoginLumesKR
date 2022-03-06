<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN.LUMES.KR</title>
    <link rel="shortcut icon" href="/favicon/logo.png">

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- end of sweetalert -->

    <link rel="stylesheet" href="./css/commonfont.css" />

</head>

<body>
    <!-- 프로세스 처리 구간이라서 굳이 뭘 할 건 없음. -->
</body>

<?php

    header('Content-Type: text/html; charset=utf-8');

    $conn = mysqli_connect("localhost", "luminous", "alphatrox2048@@", "luminous");

    $email = $_GET['email'];
    
    $query = "SELECT id FROM member WHERE email = '$email'";
    $row   = mysqli_fetch_array(mysqli_query($conn, $query));

    if($row){
        
        // 계정 존재
        ?>

        <script>

            Swal.fire({
                icon: 'success',
                title: '계정 찾음',
                text: '해당 이메일 주소로 등록된 계정이 있습니다.',
                footer: 'ID는 ' + '<?=$row["id"]?>' + ' 입니다.',
                allowOutsideClick: false,
            }).then((result) => {
                location.href = "../login.php";
            });

        </script>

        <?php

    }else{

        // 계정이 존재하지 않음
        ?>

        <script>

            Swal.fire({
                icon: 'error',
                title: '계정 없음',
                text: '해당 이메일 주소로 등록된 계정이 없습니다..',
                footer: '회원가입을 새로 하시거나 관리자에게 문의하세요.',
                allowOutsideClick: false,
            }).then((result) => {
                location.href = "../login.php";
            });

        </script>

        <?php

    }

?>