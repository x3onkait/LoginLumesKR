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

            var_dump($_SESSION);

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

        $userSuspensionTarget = $_POST['suspend-user-account-target'];

        if($userSuspensionTarget === NULL) {

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

        // 정지 조치를 내리려는 사용자가 실제로 존재하는지 한번 검사
        $isTargetExists = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM member WHERE id = '$userSuspensionTarget'"));


        if($isTargetExists) {

            if($isTargetExists['password'] === "redacted") {

                // 이미 계정 정지가 된 경우
                ?>
    
                    <script>
    
                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR',
                            text: '이미 정지된 계정',
                            footer: '해당 사용자 계정은 이미 정지된 계정입니다.'
                        }).then((result) => {
                            location.href = "../mypage.php";
                        })
    
                    </script>
    
                <?php
    
                die();
    
            }


            $query = "UPDATE member SET password = 'redacted' WHERE id = '$userSuspensionTarget'";
            $result = mysqli_query($conn, $query);

            if($result === false) {

                ?> 

                    <script>

                        // 작업 실패
                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR',
                            text: '실행 오류',
                            footer: '아래 에러 메시지를 확인하세요 : ' + <?php echo mysqli_error($conn) ?> 
                        }).then((result) => {
                            location.href = "../mypage.php";
                        });

                    </script>

                <?php

                    } else {

                ?>

                    <script>

                        // 작업 성공
                        let target = "<?php echo $userSuspensionTarget ?>";

                        Swal.fire({
                            icon: 'success',
                            title: 'OK',
                            text: '계정 제재 완료',
                            footer: '유저 @<b>' + target + ' </b>가 활동정지되었습니다.'
                        }).then((result) => {
                            location.href = "../mypage.php";
                        });

                    </script>

                <?php  

                    }

                ?>

            <?php
        
        } else {

            ?>

                <script>

                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR',
                        text: '대상이 존재하지 않음',
                        footer: '활동정지하려는 계정이 존재하지 않습니다.'
                    }).then((result) => {
                        location.href = "../mypage.php";
                    })

                </script>

            <?php

            die();

        }

    ?>

</body>