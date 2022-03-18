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

if (isset($_POST['g-recaptcha-response'])) {
    $captcha = $_POST['g-recaptcha-response'];
    $privatekey = "6LciGk8eAAAAAKt_-juc2-AwEvLb8kjJyR7cCwpN";
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => $privatekey,
        'response' => $captcha,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    );

    $curlConfig = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $data
    );

    $ch = curl_init();
    curl_setopt_array($ch, $curlConfig);
    $response = curl_exec($ch);
    curl_close($ch);
}

$jsonResponse = json_decode($response);

if ($jsonResponse->success === true) {
    // ReCAPTCHA validation successful
    
    // DB connection
    require(dirname(__FILE__) . "/../dbconnection.php");

    $id = $_POST['id'];
    $email = $_POST['email'];

    // 클라이언트측에서 중간에 값을 변조해 중복 로그인을 시도하는 경우를 차단하기 위해 백엔드에서 한번 더 검사
    $query_for_ID = "SELECT * FROM member WHERE id ='{$id}'";
    $query_for_email = "SELECT * FROM member WHERE email ='{$email}'";
    $isDuplicated_ID = mysqli_fetch_array(mysqli_query($conn, $query_for_ID));
    $isDuplicated_email = mysqli_fetch_array(mysqli_query($conn, $query_for_email));

    if ($isDuplicated_ID === NULL && $isDuplicated_email === NULL) {

        // 클라이언트 측 검증 결과를 신뢰할 수 있음
        $nickname = $_POST['nickname'];
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        date_default_timezone_set("Asia/Seoul");
        $last_activity_time = date("Y-m-d H:i:s");

        // role은 유저의 역할을 나타냄. 관리자는 Admin, Quality Assessment를 담당하면 QA 등으로 관리자가 별도로 지정하지 않는 한 기본값 user
        $query = "INSERT INTO member (id, nickname, password, email, exp, role, last_activity_time, guestbookQty) VALUES('$id', '$nickname', '$hashedPassword', '$email', 100, 'user', '$last_activity_time', 0)";

        $result = mysqli_query($conn, $query);

        if ($result === false) {

            ?>

            <script>
                Swal.fire({
                    icon : 'error',
                    title : 'UNEXPECTED',
                    text : '예기치 못한 문제가 발생했습니다.',
                    footer : '다음 에러 메시지를 관리자에게 전해주세요. : ' + <?php mysqli_error($conn) ?>
                }).then((result) => {
                    location.href = "../index.php";
                })
            </script>

            <?php

        } else {

            // 프로필 사진 (기본 프로필 사진으로 일단 복사)
            copy("/_serverasset/_defaultProfilePictures/_defaultProfileImage.jpg", "/_serverasset/_userProfilePictures/profilePic_'$id'.jpg");

            ?>

            <script>
                Swal.fire({
                    icon : 'success',
                    title : '반갑습니다!',
                    text : '회원가입이 완료되었습니다.',
                    footer : '로그인하여 서비스를 이용하실 수 있습니다.'
                }).then((result) => {
                    location.href = "../index.php";
                })
            </script>

            <?php

        }

    } else {

        ?>

            <script>
                Swal.fire({
                    icon : 'warning',
                    title : 'ERROR!',
                    text : '입력값 변조 의심',
                    footer : '중복가입 시도는 허용되지 않습니다.'
                }).then((result) => {
                    location.href = "../index.php";
                })
            </script>

        <?php

    }

}

else {
    // ReCAPTCHA validation fail

    ?>

            <script>
                Swal.fire({
                    icon : 'error',
                    title : 'ERROR!',
                    text : '가입 실패',
                    footer : '자동가입방지를 위한 ReCAPTCHA를 수행하여 로봇이 아님을 증명해주세요. 자동화된 가입은 허용되지 않습니다.'
                }).then((result) => {
                    location.href = "../index.php";
                })
            </script>

    <?php

}

?>
