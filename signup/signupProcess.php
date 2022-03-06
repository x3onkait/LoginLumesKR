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
    $conn = mysqli_connect("localhost", "luminous", "alphatrox2048@@", "luminous");

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

        // role은 유저의 역할을 나타냄. 관리자는 Admin, Quality Assessment를 담당하면 QA 등으로 관리자가 별도로 지정하지 않는 한 기본값 user
        $query = "INSERT INTO member (id, nickname, password, email, exp, role) VALUES('$id', '$nickname', '$hashedPassword', '$email', 100, 'user')";

        $result = mysqli_query($conn, $query);

        if ($result === false) {
            echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
            echo mysqli_error($conn);
        }
        else {
            echo '<script>';
            echo 'alert("회원가입이 완료되었습니다");';
            echo 'location.href = "../index.php"';
            echo '</script>';
        }

    } else {

        // 중간에 값이 변조됨
        echo '<script>';
        echo 'alert("중간에 값이 변조된 것 같군요... 혹시 중복 가입을 시도하시는거라면.. 안 됩니다! 흥!");';
        echo 'location.href = "../index.php"';
        echo '</script>';

    }

}

else {
    // ReCAPTCHA validation fail
    echo '<script>';
    echo 'alert("ReCAPTCHA 실패로 회원가입이 거부되었습니다. 자동화된 시도는 허용되지 않습니다.");';
    echo 'location.href = "../index.php";';
    echo '</script>';
}

?>
