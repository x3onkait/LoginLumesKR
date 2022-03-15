<?php

session_start();
header('Content-Type: text/html; charset=utf-8');

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN.LUMES.KR</title>
    <link rel="shortcut icon" href="/favicon/logo.png">
    <link rel="stylesheet" href="./css/mypageForAdmin.css">

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- end of sweetalert -->

</head>

<body>

    <?php

        if($_SESSION['role'] !== "Admin") {

            ?>

                <script>

                    Swal.fire({
                        icon: 'error',
                        title: 'DENIED',
                        text: '관리자 전용',
                        footer: '이 서비스는 관리자가 아닌 일반 사용자가 이용할 수 없습니다.'
                    }).then((result) => {
                        location.href = "../mypage.php";
                    })

                </script>

                <?php

                die();

        }

        // DB connection
        require(dirname(__FILE__) . "/../../dbconnection.php");

        $giveExpTarget = $_POST['give-exp-target'];
        $giveExpAmount = $_POST['give-exp-amount'];

        if($giveExpTarget === NULL || $giveExpAmount === NULL || is_numeric($giveExpAmount) === false){


            ?>

                <script>

                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR',
                        text: '입력값이 올바르지 않음',
                        footer: '모든 필드를 입력했는지, 경험치가 정수인지 확인해주세요.'
                    }).then((result) => {
                        location.href = "../mypage.php";
                    })

                </script>

            <?php

            die();

        }


        // 경험치를 보내려는 사용자가 실제 존재하는 유저인지 확인
        $isTargetExists = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM member WHERE id = '$giveExpTarget'"));

        if($isTargetExists) {

            $query = "UPDATE member SET exp = exp + '$giveExpAmount' WHERE id = '$giveExpTarget'";
            $result = mysqli_query($conn, $query);

            // 송금 기록 남기기 
            date_default_timezone_set("Asia/Seoul");
            $t = microtime(true);
            $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
            $d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));
            $date = $d->format("Y-m-d H:i:s.u");

            if($giveExpAmount >= 0){
                $type = "GRANT";
            } else {
                $type = "DEPRIVE";
            }

            $id = $_SESSION['id'];

            $transaction_number_source = $type . $id . $giveExpTarget . $giveExpAmount . $date;
            $transaction_number     = hash("sha256", $transaction_number_source);
            $makeTransactionLog     = mysqli_query($conn, "INSERT INTO exp_transactions (transaction_number, type, source, target, amount, date) 
                                                    VALUES ('$transaction_number', '$type', '$id', '$giveExpTarget', '$giveExpAmount', '$date') ");

            if($result === false || $makeTransactionLog === false) {


                // 작업 실패
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

            die();

            } else {

                // 작업 성공
                ?>

                    <script>

                        let target = "<?php echo $giveExpTarget ?>"
                        let amount = <?php echo $giveExpAmount ?>;

                        Swal.fire({
                            icon: 'success',
                            title: 'OK',
                            text: 'EXP 수정 완료',
                            footer: '@<b>' + target + '&nbsp;</b>에게&nbsp; ' + '<b>' + amount.toLocaleString('ko-KR') + ' EXP</b>&nbsp;가 추가(제거)되었습니다!'
                        }).then((result) => {
                            location.href = "../mypage.php";
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
                    text: '대상이 존재하지 않음',
                    footer: '경험치를 추가/제거하려는 대상이 존재하지 않습니다.'
                }).then((result) => {
                    location.href = "../mypage.php";
                })

            </script>

            <?php

            die();

        }


        ?>

</body>