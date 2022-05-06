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
    $sendExpTarget = strtolower($_POST['sendExpTarget']);
    $sendExpAmount = (int)$_POST['sendExpAmount'];

    if($id === $sendExpTarget) {

        // Client-side 검증 우회로 경험치를 오히려 "채우려는" 경우
        ?>

            <script>
                Swal.fire({
                    icon: 'question',
                    title: 'Why...?',
                    text: '자기 자신에게 송금하시나요?',
                    footer: '안타깝지만 아무런 EXP 잔고의 변화가 일어나지는 않습니다. ID를 대문자 소문자 섞으셔도 안 됩니다. ID는 소문자가 원칙이에요.'
                }).then((result) => {
                    location.href = "./mypage.php";
                })
            </script>

        <?php

        die();

    }

    // 클라이언트에서 중간에 값을 가로채서 JS 인증을 우회하려는 경우 이를 탐지하고 거래를 거절.

    if(is_numeric($sendExpAmount) === false || $sendExpAmount <= 0) {

        // Client-side 검증 우회로 경험치를 오히려 "채우려는" 경우
        ?>

            <script>
                Swal.fire({
                    icon: 'question',
                    title: 'Are you a hacker?',
                    text: '클라이언트 검증을 우회하셨나요?',
                    footer: '송금 기능을 역이용하지 마세요!^^'
                }).then((result) => {
                    location.href = "./mypage.php";
                })
            </script>

        <?php

        die();

    } else {

        // 보내려는 사용자가 실제 존재하는 유저인지 확인
        $isTargetExists = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM member WHERE id = '$sendExpTarget'"));

        if($isTargetExists){

            if($isTargetExists['password'] === "redacted") {
                // 차단된 사용자에게 송금 금지

                ?>

                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR',
                        text: '거래가 유효하지 않음',
                        footer: '현재 (영구)정지된 계정에는 송금을 할 수 없습니다.'
                    }).then((result) => {
                        location.href = "./mypage.php";
                    })
                </script>

                <?php
                
                die();

            }
            
            // 자기가 가진 EXP 범위 내에서 EXP를 보내려는지 검사
            $myExpAmount = mysqli_fetch_array(mysqli_query($conn, "SELECT exp FROM member WHERE id = '$id'"));
            $myExpAmount = $myExpAmount['exp'];

            if($myExpAmount < $sendExpAmount) {

                // 자기가 가진 EXP보다 더 많이 보내려는 경우
                ?>

                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR',
                        text: 'EXP 부족',
                        footer: '현재 보유한 EXP보다 더 많은 양을 송금 시도했습니다.'
                    }).then((result) => {
                        location.href = "./mypage.php";
                    })
                </script>

                <?php

                die();

            } else {

                // 송금 개시
                $loseMyExpAmount        = mysqli_query($conn, "UPDATE member SET exp = exp - '$sendExpAmount' WHERE id = '$id'");
                $gainTargetExpAmount    = mysqli_query($conn, "UPDATE member SET exp = exp + '$sendExpAmount' WHERE id = '$sendExpTarget'");
                
                // 송금 누적내역 기록
                $addExpTransactionQty   = mysqli_query($conn, "UPDATE member SET expTransactionQty = expTransactionQty + '$sendExpAmount' 
                                                                             WHERE id = '$id' or id = '$sendExpTarget'");

                // 송금 기록 남기기
                // date_default_timezone_set("Asia/Seoul");

                $t = microtime(true);
                $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
                $d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));
                $date = $d->format("Y-m-d H:i:s.u");

                $type                   = "TRANSFER";
                $transaction_number_source = $type . $id . $sendExpTarget . $sendExpAmount . $date;
                $transaction_number     = hash("sha256", $transaction_number_source);
                $makeTransactionLog     = mysqli_query($conn, "INSERT INTO exp_transactions (transaction_number, type, source, target, amount, date) 
                                                        VALUES ('$transaction_number', '$type', '$id', '$sendExpTarget', '$sendExpAmount', '$date') ");

                if($loseMyExpAmount === false || $addExpTransactionQty === false || $gainTargetExpAmount === false || $makeTransactionLog === false) {

                    ?>

                    <script>

                        Swal.fire({
                            icon: 'error',
                            title: 'UNEXPECTED!',
                            text: 'EXP 송금 또는 송금 기록에 문제가 생겼습니다.',
                            footer: '관리자에게 문의하세요.'
                        }).then((result) => {
                            Swal.fire({
                                icon: 'info',
                                title: '에러 메시지',
                                text: '아래 에러 메시지를 관리자에게 보여주세요.',
                                footer: <?php echo mysqli_error($conn) ?>
                            }).then((result) => {
                                location.href = "../mypage.php";
                            });
                        });

                    </script>

                    <?php

                } else {

                    // 송금 성공

                    ?>

                    <script>

                        let amount = <?php echo $sendExpAmount ?>;

                        Swal.fire({
                            icon: 'success',
                            title: 'OK',
                            text: 'EXP 송금이 완료되었습니다.',
                            footer: '<b>' + amount.toLocaleString('ko-KR') + ' EXP가 송금됐습니다! </b>'
                                          
                        }).then((result) => {
                            location.href = "./mypage.php";
                        });

                    </script>

                    <?php

                }

            }

        }else{
            
            ?>

            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR',
                    text: '송금 실패',
                    footer: '<b>송금 대상이 존재하지 않습니다.</b>'
                }).then((result) => {
                    location.href = "./mypage.php";
                })
            </script>

            <?php

        }

    }

?>