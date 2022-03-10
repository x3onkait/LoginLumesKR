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

</head>

<body>
    <!-- 프로세스 처리 구간이라서 굳이 뭘 할 건 없음. -->
</body>

<?php

    session_start();

    header('Content-Type: text/html; charset=utf-8');

    // DB connection
    require(dirname(__FILE__) . "/../../dbconnection.php");

    $realAuthKey = $_SESSION['verify_email_authkey'];
    $userInputAuthKey = $_GET['userInputAuthKey'];
    $userEmailAddress = $_GET['userEmailAddress'];

    if($realAuthKey === $userInputAuthKey) {

        // 인증 성공
        // 새로운 패스워드 지정 후 알려주기

        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $newUserPassword = substr(str_shuffle($permitted_chars), 0, 10);
        $newUserPasswordHashed = password_hash($newUserPassword, PASSWORD_DEFAULT);

        $query = "UPDATE member SET password = '$newUserPasswordHashed' where email = '$userEmailAddress'";

        $result = mysqli_fetch_array(mysqli_query($conn, $query));

        if($result === false){

            // 반영 실패(unexpted)

            ?>

            <script>
                Swal.fire({
                    icon : 'error',
                    title : 'UNEXPECTED',
                    text : '예기치 못한 문제가 발생했습니다.',
                    footer : '다음 에러 메시지를 관리자에게 전해주세요. : ' + <?php mysqli_error($conn) ?>
                }).then((result) => {
                    location.href = "../login.php";
                })
            </script>

            <?php

            die();

        } else {

            // 반영 성공

            ?>

            <script>

                Swal.fire({
                    icon: 'success',
                    title: '본인 인증됨',
                    text: '본인임이 인증되었습니다.',
                    footer: '비밀번호가 [ <?php echo $newUserPassword ?> ] 으로 초기화되었습니다. 일단 이 비밀번호로 로그인하시고,'
                            + '그 후 마이페이지에서 비밀번호를 다른 걸로 바꾸시기 바랍니다.',
                    allowOutsideClick: false,
                }).then((result) => {
                    location.href = "../login.php";
                });

            </script>

            <?php

        }


    } else {

        // 인증 실패
        ?>

        <script>

        Swal.fire({
            icon: 'error',
            title: '본인 인증 실패',
            text: '인증 코드가 올바르지 않습니다.',
            footer: '인증 코드를 올바르게 입력하도록 다시 시도해 주세요.',
            allowOutsideClick: false,
        }).then((result) => {
            location.href = "../login.php";
        });

        </script>

        <?php

    }

?>