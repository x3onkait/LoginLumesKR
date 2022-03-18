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

    if($_SESSION['id'] === false) {

        ?>

            <script>
        
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: '누구시죠?',
                footer: '아니, 로그인부터 하고 글을 적으시라구요!'
            }).then((result) => {
                location.href = "./chat.php";
            });
        
            </script>
    
        <?php

        die();

    }

    // DB connection
    require(dirname(__FILE__) . "/../dbconnection.php");

    $writer_id                  = $_SESSION['id'];
    $writer_nickname            = $_SESSION['nickname'];
    $writer_role                = $_SESSION['role'];
    $ip                         = $_SERVER['REMOTE_ADDR'];
    $content                    = $_POST['userChatMessage'];
    $message_room               = "public";               // 일단 모두 공개 채팅방인 "public" 사용
                                                          // 나중에 따로 방을 만들게 되면 그때 분리하는 것으로 함.

    $t = microtime(true);
    $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
    $d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));
    $date = $d->format("Y-m-d H:i:s.u");

    $query = "INSERT 
              INTO chat 
                     (message_room, writer_id, writer_nickname, content, date, ip, writer_role) 
              VALUES ('$message_room', '$writer_id', '$writer_nickname', '$content', '$date', '$ip', '$writer_role')";

    $result = mysqli_query($conn, $query);


    if($result === false) {

        // 업로드 실패

        ?>

            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'UNEXPECTED!',
                    text: '채팅 메시지 등록 실패',
                    footer: '같은 문제가 계속 발생될 시 서비스가 다운되었는지 관리자에게 물어보세요.'
                }).then((result) => {
                    Swal.fire({
                        icon: 'info',
                        title: '에러 메시지',
                        text: '아래 에러 메시지를 관리자에게 보여주세요.',
                        footer: <?php echo mysqli_error($conn) ?>
                    }).then((result) => {
                        location.href = "./chat.php";
                    });
                });

            </script>

        <?php

        die();

    } else {

        // 업로드 성공

        $add_exp = rand(300, 500);
        $current_time = date("Y-m-d H:i:s");
        $result_member_db_update = mysqli_query($conn, "UPDATE member 
                                                        SET exp = exp + '$add_exp', 
                                                            guestbookQty = guestbookQty + 1,
                                                            last_activity_time = '$current_time' 
                                                        WHERE id = '$writer_id'");

        if ($result_member_db_update === false) {

            ?>

            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'UNEXPECTED!',
                    text: '에러!!',
                    footer: '경험치 DB 반영에 문제가 생겼습니다.'
                }).then((result) => {
                    Swal.fire({
                        icon: 'info',
                        title: '에러 메시지',
                        text: '아래 에러 메시지를 관리자에게 보여주세요.',
                        footer: <?php echo mysqli_error($conn) ?>
                    }).then((result) => {
                        location.href = "./chat.php";
                    });
                });

            </script>

            <?php

            die();

        } else {

            // successful
            echo "<script> location.href='./chat.php' </script>";

        }

    }


?>