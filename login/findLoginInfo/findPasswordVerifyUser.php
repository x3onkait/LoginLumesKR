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

    $email = $_GET['email'];

    $query = "SELECT * FROM member WHERE email = '$email'";
    $row   = mysqli_fetch_array(mysqli_query($conn, $query));

    if($row) {

        if($row['password'] === "redacted") {

            ?>

            <script>
                Swal.fire({
                    icon : 'error',
                    title : 'DENIED',
                    text : '영구정지된 계정',
                    footer : '해당 계정 복구에 대해서는 관리자에게 직접 문의하셔야 합니다.'
                }).then((result) => {
                    location.href = "../login.php";
                })
            </script>

            <?php

            die();

        }

        $requested_user_id = $row['id'];

        // 계정 존재
        // 인증 이메일을 보내서 비밀번호를 초기화
        $verify_email_authkey = sprintf("%06x",rand(0,16777215));
        $_SESSION['verify_email_authkey'] = $verify_email_authkey;

        $verify_email_to = $row['email'];

        $verify_email_subject = "[login.lumes.kr] '$verify_email_to' 계정에 대한 비밀번호 찾기 인증 이메일";

        $verify_email_contents  = "<p>&nbsp;안녕하세요, <strong>" . $requested_user_id . "</strong> 회원님.</p>";
        $verify_email_contents .= "<p>&nbsp;<a href='login.lumes.kr' target='_blank'>login.lumes.kr</a> 에서 회원님이 <strong>비밀번호 찾기(초기화)</strong>를 요청하셨습니다.</p>";
        $verify_email_contents .= "<p>&nbsp;비밀번호를 바꾸기 위해서는 먼저 본인임을 인증하실 수 있어야 합니다.</p>";
        $verify_email_contents .= "<p>&nbsp;아래 <strong>인증코드</strong>를 인증 창에 입력하셔서 본인 인증을 마쳐 주세요.</p>";
        $verify_email_contents .= "<p>&nbsp;</p>";

        $verify_email_contents .= "<table style='height: 60px; width: 206px; border-collapse: collapse; margin-left: auto; margin-right: auto;' border='1'>";
        $verify_email_contents .=   "<tbody>";
        $verify_email_contents .=       "<tr style='height: 19px;'>";
        $verify_email_contents .=           "<td style='width: 202px; height: 19px; text-align: center;'><strong>인증 코드</strong></td>";
        $verify_email_contents .=       "</tr>";
        $verify_email_contents .=       "<tr style='height: 19px;'>";
        $verify_email_contents .=           "<td style='width: 202px; height: 19px; text-align: center;'>" . $verify_email_authkey . "</td>";
        $verify_email_contents .=       "</tr>";
        $verify_email_contents .=   "</tbody>";
        $verify_email_contents .= "</table>";

        $verify_email_contents .= "<p>&nbsp;</p>";


        $verify_email_headers = "From: noreply@lumes.kr\r\n";
        $verify_email_headers .= "Content-Type: text/html;\r\n";

        mail($verify_email_to, $verify_email_subject, $verify_email_contents, $verify_email_headers);

        ?>

        <script>

            // 비밀번호 초기화 질문창
            Swal.fire({

                title: '본인 인증',
                icon: 'question',
                html: '<input type="text" id="authkey" class="swal2-input" placeholder="6자리 인증코드(16진수)">',
                confirmButtonText: '확인하기',
                footer: '<b>ID가 ' + '[ <?php echo $requested_user_id ?> ]' + ' 인 계정을 찾습니다.</b> 가입 당시 이메일 주소로 보내진 인증 메일을 확인하여 6자리 인증코드를 입력해주세요.',
                allowOutsideClick: false,
                focusConfirm: false,
                preConfirm: () => {
                    const userInputAuthKey = Swal.getPopup().querySelector('#authkey').value
                    if (!userInputAuthKey) {
                        Swal.showValidationMessage('인증키를 입력해 주세요!')
                    }
                    return { userInputAuthKey : userInputAuthKey }
                }

            }).then((result) => {

                // 인증 절차
                location.href = "./findPasswordProcess.php?userInputAuthKey=" + result.value.userInputAuthKey + "&userEmailAddress=" + "<?php echo $email ?>";

            });

        </script>

        <?

    } else {

        // 계정 존재하지 않음

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