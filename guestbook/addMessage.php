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

session_start();

if (isset($_SESSION['id'])) {

    // 공백(whitespace)이 있는 문자열도 허용하지 않음...
    $comment = trim(addslashes(htmlspecialchars($_POST['comment'])));

    // 공백 필터링 우회 차단...
    $comment = str_replace("​ ", "", $comment);                // U+0020 차단
    $comment = str_replace("　", "", $comment);                // U+3000 차단
    $comment = str_replace("​", "", $comment);                 // U+200B 차단
    $comment = str_replace("ᅟ", "", $comment);                  // U+115F 차단
    $comment = str_replace("ᅠ", "", $comment);                  // U+1160 차단
    $comment = str_replace("ㅤ", "", $comment);                 // U+3164 차단
    $comment = str_replace("ﾠ", "", $comment);                  // U+FFA0 차단
    $comment = str_replace("⠀", "", $comment);                  // U+2280 차단

    if ($comment !== "") {

        // 빈 메시지는 이제 허용하지 않음
        
        // DB connection
        require(dirname(__FILE__) . "/../dbconnection.php");

        $writer_id = $_SESSION['id'];
        $writer_nickname = $_SESSION['nickname'];
        $writer_role = $_SESSION['role'];

        // 경험치는 데이터베이스에서.
        // 도배를 막기 위해 마지막 활동 시간을 가져와 2초 이내에 글을 또 올리려고 시도하는지도 가져온다.
        $writer_exp_db_result = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM member WHERE id = '$writer_id'"));
        $writer_exp = $writer_exp_db_result['exp'];
        $writer_last_activity_time = $writer_exp_db_result['last_activity_time'];

        // 마지막으로 글을 올린 시간과 비교하여 글을 올리는 간격 (초)
        // 4초 간격 이내로 매우 짧게 글을 다시 계속해서 올릴려고 하는 경우 차단
        date_default_timezone_set("Asia/Seoul");
        $writer_activity_interval = strtotime(date('Y-m-d H:i:s')) - strtotime($writer_last_activity_time);
        if($writer_activity_interval < 4) {

            ?>

            <script>

                Swal.fire({
                    icon: 'error',
                    title: 'ERROR',
                    text: '과도한 요청 탐지',
                    footer: '<b>무분별한 도배 행위를 막기 위해, 게시글은 개당 최소 4초 이상의 간격을 두고 올리셔야 합니다. 조금 진정하세요.</b>'
                }).then((result) => {
                    location.href = "../index.php";
                });

            </script>

            <?php

            die();

        }

        $t = microtime(true);
        $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
        $d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));
        $date = $d->format("Y-m-d H:i:s.u");

            
        $query = "INSERT INTO guestbook (writer_id, writer_nickname, comment, date, role) VALUES('$writer_id', '$writer_nickname' ,'$comment', '$date', '$writer_role')";
        $result = mysqli_query($conn, $query);

        if ($result === false) {

            echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
            echo mysqli_error($conn);

            ?>

            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'UNEXPECTED!',
                    text: '에러!!',
                    footer: '\"\\\"나 \"\'\"와 같은 문자열은 상황에 따라 입력이 제한될 수 있습니다.'
                }).then((result) => {
                    Swal.fire({
                        icon: 'info',
                        title: '에러 메시지',
                        text: '아래 에러 메시지를 관리자에게 보여주세요.',
                        footer: <?php echo mysqli_error($conn) ?>
                    }).then((result) => {
                        location.href = "../index.php";
                    });
                });

            </script>

            <?php

        } else {

            $add_exp = rand(500, 800);
            $writer_exp += $add_exp;
            $current_time = date("Y-m-d H:i:s");
            $result_exp_db_update                = mysqli_query($conn, "UPDATE member SET exp = '$writer_exp' WHERE id = '$writer_id'");
            $result_last_acitvity_time_db_update = mysqli_query($conn, "UPDATE member SET last_activity_time = '$current_time'");
            if ($result_exp_db_update === false || $result_last_acitvity_time_db_update === false) {

                ?>

                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'UNEXPECTED!',
                        text: '에러!!',
                        footer: '경험치 누적 또는 시간 기록에 문제가 생겼습니다.'
                    }).then((result) => {
                        Swal.fire({
                            icon: 'info',
                            title: '에러 메시지',
                            text: '아래 에러 메시지를 관리자에게 보여주세요.',
                            footer: <?php echo mysqli_error($conn) ?>
                        }).then((result) => {
                            location.href = "../index.php";
                        });
                    });

                </script>

                <?php
    
            }

            echo '<script>';
            echo 'location.href = "../index.php";';
            echo '</script>';

        }


    } else {

        ?>

        <script>

        Swal.fire({
            icon: 'error',
            title: 'ERROR',
            text: '메시지가 없네요...',
            footer: '메시지를 입력하고 전송하기를 시도하세요! 공백만 입력하는 것은 허용되지 않으며, 공백을 우회하기 위해 전각 공백 등을 사용하는 것도 금지됩니다.'
        }).then((result) => {
            location.href = "../index.php";
        });

        </script>

        <?php

    }

} else {

    ?>

    <script>

    Swal.fire({
        icon: 'error',
        title: 'ERROR',
        text: '누구시죠?',
        footer: '아니, 로그인부터 하고 글을 적으시라구요!'
    }).then((result) => {
        location.href = "../index.php";
    });

    </script>

    <?php

}

?>
