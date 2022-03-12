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
    <link rel="stylesheet" href="./css/mypage.css">
    <link rel="shortcut icon" href="/favicon/logo.png">

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <!-- end of bootstrap-->

    <!-- toastr.js -->
    <link rel="stylesheet" type="text/css"
        href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- end of toastr.js -->

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- end of sweetalert -->

</head>

<body>

    <?php include ("../navbar.php") ?>

    <!-- get some current user information and show that -->
    <?php

            
            // DB connection
            require(dirname(__FILE__) . "/../dbconnection.php");
            

            $query = "SELECT * FROM member WHERE id = '" . $_SESSION['id'] . "'";
            $userInformation = mysqli_fetch_array(mysqli_query($conn, $query));

            $exp_unit = '&nbsp;<span style="color: gray">EXP</span>';

            echo '<table class="table" id="userInformationTable">';
                echo '<thead class="thead-dark">';
                    echo '<tr>';
                        echo '<th scope="col" style="text-align: center">ID</th>';
                        echo '<th scope="col" style="text-align: center">이메일</th>';
                        echo '<th scope="col" style="text-align: center">닉네임</th>';
                        echo '<th scope="col" style="text-align: center">보유 경험치</th>';
                    echo '</tr>';
                echo '</thead>';
            
                echo '<tbody>';
                    echo '<tr>';
                        echo '<th scope="row"  style="text-align: center">' . $userInformation['id'] . '</th>';
                        echo '<td style="text-align: center">' . $userInformation['email'] . '</td>';
                        echo '<td style="text-align: center">' . $userInformation['nickname'] . '</td>';
                        echo '<td style="text-align: center">' . number_format($userInformation['exp']) . ' ' . $exp_unit .'</td>';
                    echo '</tr>';
                echo '</tbody>';
            echo '</table>';

      ?>
    <!-- end -->

    <table id="changeInformationForm">
        <thead>
            <tr>
                <td>
                    <!-- change current user's password -->
                    <form id="changePasswordForm" onsubmit="return false;">
                        <div class="ml-auto mr-auto mt-2">
                            <div class="mb-3">
                                <label for="current-password" class="form-label">현재 비밀번호</label>
                                <input name="current-password" type="text" class="form-control" id="current-password"
                                    placeholder="현재 비밀번호를 입력해 주세요." data-isValidated="false">
                            </div>
                            <div class="mb-3">
                                <label for="new-password" class="form-label">새로운 비밀번호</label>
                                <input name="new-password" type="text" class="form-control" id="new-password"
                                    placeholder="변경하실 비밀번호를 입력해 주세요." data-isValidated="false">
                            </div>
                            <div class="mb-3">
                                <label for="new-password-check" class="form-label">새로운 비밀번호 (재입력)</label>
                                <input name="new-password-check" type="text" class="form-control"
                                    id="new-password-check" placeholder="변경하실 비밀번호를 한번 더 입력해 주세요."
                                    data-isValidated="false">
                            </div>
                            <button class="btn btn-primary" id="changePasswordSubmitButton">비밀번호 변경하기</button>
                            <div>
                    </form>
                    <!-- end -->
                </td>
                <td>
                    <!-- change current user's password -->
                    <form id="changeNicknameForm" onsubmit="return false;">
                        <div class="ml-auto mr-auto mt-2">
                            <div class="mb-3">
                                <label for="current-nickname" class="form-label">현재 닉네임</label>
                                <input name="current-nickname" type="text" class="form-control" id="current-nickname"
                                    placeholder="현재 닉네임을 입력해 주세요." data-isValidated="false">
                            </div>
                            <div class="mb-3">
                                <label for="new-nickname" class="form-label">새로운 닉네임</label>
                                <input name="new-nickname" type="text" class="form-control" id="new-nickname"
                                    placeholder="새롭게 바꾸실 닉네임을 입력해 주세요." data-isValidated="false">
                            </div>
                            <div class="mb-3">
                                <label for="new-nickname-check" class="form-label">새로운 닉네임 (재입력)</label>
                                <input name="new-nickname-check" type="text" class="form-control"
                                    id="new-nickname-check" placeholder="새롭게 바꾸실 닉네임을 한번 더 입력해 주세요."
                                    data-isValidated="false">
                            </div>
                            <button class="btn btn-primary" id="changeNicknameSubmitButton">닉네임 변경하기</button>
                            <div>
                    </form>
                    <!-- end -->
                </td>
            </tr>
        </thead>
    </table>

    <!-- 약간의 재미를 위한 기능...! EXP를 다른 사람한테 선물할 수 있음. -->
    <form class="form-inline" id="sendExpForm" onsubmit="return false;">
        <div class="form-group mb-2">
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <label for="sendExpTarget" class="sr-only">송금 대상</label>
            <span class="input-group-text">@</span>
            <input type="text" class="form-control" id="sendExpTarget" name="sendExpTarget" placeholder="송금 대상 ID">
        </div>
        <h6> 에게 </h6>
        <div class="form-group mx-sm-3 mb-2">
            <label for="sendExpAmount" class="sr-only">EXP</label>
            <input type="number" class="form-control" id="sendExpAmount" name="sendExpAmount" placeholder="EXP 양 입력">
            <span class="input-group-text">EXP</span>
        </div>
        <h6> EXP를 보냅니다.&nbsp;&nbsp;</h6>
        <button type="submit" class="btn btn-primary mb-2" id="sendExpAmountSubmitButton">송금하기</button>
    </form>

    <?php

        // 어드민을 위한 특별(!) 페이지
        if($_SESSION['role'] === "Admin") {

            ?>

                <link rel="stylesheet" href="./admin/css/mypageForAdmin.css">

            <?php

            include("./admin/mypageForAdmin.html");

        }

    ?>


</body>

<script type="text/javascript" src="./js/checkPassword.js"></script>
<script type="text/javascript" src="./js/checkNickname.js"></script>
<script type="text/javascript" src="./js/checkSendExp.js"></script>

</html>