<?php
   session_start();
   header('Content-Type: text/html; charset=utf-8');
   header("Pragma: no-cache");
   header("Cache-Control: no-store, no-cache, must-revalidate"); 
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
            $qty_unit = '&nbsp;<span style="color: gray">???</span>';

            echo '<table class="table" id="userInformationTable">';
                echo '<thead class="thead-dark">';
                    echo '<tr>';
                        echo '<th scope="col" style="text-align: center">ID</th>';
                        echo '<th scope="col" style="text-align: center">?????????</th>';
                        echo '<th scope="col" style="text-align: center">?????????</th>';
                        echo '<th scope="col" style="text-align: center">?????? ?????????</th>';
                        echo '<th scope="col" style="text-align: center">?????? ?????????</th>';
                    echo '</tr>';
                echo '</thead>';
            
                echo '<tbody>';
                    echo '<tr>';
                        echo '<th scope="row"  style="text-align: center">' . $userInformation['id'] . '</th>';
                        echo '<td style="text-align: center">' . $userInformation['email'] . '</td>';
                        echo '<td style="text-align: center">' . $userInformation['nickname'] . '</td>';
                        echo '<td style="text-align: center">' . number_format($userInformation['exp']) . ' ' . $exp_unit .'</td>';
                        echo '<td style="text-align: center">' . number_format($userInformation['guestbookQty']) . ' ' . $qty_unit .'</td>';
                    echo '</tr>';
                echo '</tbody>';
            echo '</table>';

      ?>
    <!-- end -->

    <!-- badge selection -->
    <?php

        function closestLowerHigherNr($array, $nr) {

            sort($array);
            $re_arr = array('lower' => min(current($array), $nr), 'higher' => max(end($array), $nr), 'closest' => $nr);

            foreach($array as $num){

                if($nr > $num) $re_arr['lower'] = $num;

                else if($nr <= $num){
                    $re_arr['higher'] = $num;
                    break;
                }

            }

            $re_arr['closest'] = (abs($nr - $re_arr['lower']) < abs($re_arr['higher'] - $nr)) ? $re_arr['lower'] : $re_arr['higher'];
        
            return $re_arr;
        }

        $userExpBadge = "/_serverasset/_badge/exp/";
        $userRoleBadge = "/_serverasset/_badge/role/";
        $userMessageQtyBadge = "/_serverasset/_badge/message/";
        $userTransactionQtyBadge = "/_serverasset/_badge/transaction/";

        // ?????? ??????(??????)?????? ?????? ????????? ??????
        // ?????? ?????? ?????????(???????????? EXP ???..)???????????? ?????? ????????? ?????????(1??????, 50???...)??? ?????? ????????? ?????? ???????????? ?????? ?????????.

        // ?????? exp
        if($userInformation['exp'] >= 1000000){
            $userProgressToNextExpBadgeLevel = 100;
        }else{
            $userExpBadgeDecision = [1000000, 500000, 100000, 50000, 10000, 1];
            $result = closestLowerHigherNr($userExpBadgeDecision, $userInformation['exp']);
            $result = $result['higher'];

            $userProgressToNextExpBadgeLevel = ($userInformation['exp'] / $result) * 100;

        }

        // ?????? ?????????
        if($userInformation['guestbookQty'] >= 1000000){
            $userProgressToNextMessageQtyBadgeLevel = 100;
        }else{
            $userExpBadgeDecision = [5000, 1000, 500, 100, 50, 10, 1];
            $result = closestLowerHigherNr($userExpBadgeDecision, $userInformation['guestbookQty']);
            $result = $result['higher'];

            $userProgressToNextMessageQtyBadgeLevel = ($userInformation['guestbookQty'] / $result) * 100;

        }

        // ?????? ????????? ??????
        if($userInformation['expTransactionQty'] >= 10000000){
            $userProgressToNextTransactionBadgeLevel = 100;
        }else{
            $userExpBadgeDecision = [10000000, 5000000, 1000000, 500000, 100000, 50000];
            $result = closestLowerHigherNr($userExpBadgeDecision, $userInformation['expTransactionQty']);
            $result = $result['higher'];

            $userProgressToNextTransactionBadgeLevel = ($userInformation['expTransactionQty'] / $result) * 100;
        }

        // ????????? ?????? ?????? ??????
        if($userInformation['exp'] >= 1000000){

            $userExpBadge .= "1M.png";
            $userExpBadgeMessage = "Millionaire";

        } else if($userInformation['exp'] >= 500000) {

            $userExpBadge .= "500K.png";
            $userExpBadgeMessage = "Quite high!";

        } else if($userInformation['exp'] >= 100000) {

            $userExpBadge .= "100K.png";
            $userExpBadgeMessage = "One hundred";

        } else if($userInformation['exp'] >= 50000) {

            $userExpBadge .= "50K.png";
            $userExpBadgeMessage = "You visited here, right?";

        } else if($userInformation['exp'] >= 10000) {

            $userExpBadge .= "10K.png";
            $userExpBadgeMessage = "Beginner";

        } else {

            $userExpBadge .= "1.png";
            $userExpBadgeMessage = "Welcome";

        }


        // ?????? ?????????(???) ?????? ?????? ??????
        if($userInformation['guestbookQty'] >= 5000) {

            $userMessageQtyBadge .= "5K.png";
            $userMessageQtyBadgeMessage = "Wow, so much speakin'";

        } else if($userInformation['guestbookQty'] >= 1000) {

            $userMessageQtyBadge .= "1K.png";
            $userMessageQtyBadgeMessage = "thousand of speech";

        } else if($userInformation['guestbookQty'] >= 500) {

            $userMessageQtyBadge .= "500.png";
            $userMessageQtyBadgeMessage = "Submit Submit Submit";

        } else if($userInformation['guestbookQty'] >= 100) {

            $userMessageQtyBadge .= "100.png";
            $userMessageQtyBadgeMessage = "ordinary talker";

        } else if($userInformation['guestbookQty'] >= 50) {

            $userMessageQtyBadge .= "50.png";
            $userMessageQtyBadgeMessage = "Still shy!";

        } else if($userInformation['guestbookQty'] >= 10) {

            $userMessageQtyBadge .= "10.png";
            $userMessageQtyBadgeMessage = "introduce yourself";

        } else {

            $userMessageQtyBadge .= "1.png";
            $userMessageQtyBadgeMessage = "hello world";

        }

        // transaction ?????? ?????? ??????
        if($userInformation['expTransactionQty'] >= 10000000) {

            $userTransactionQtyBadge .= "10M.png";
            $userTransactionQtyBadgeMessage = "Professional banker";

        } else if($userInformation['expTransactionQty'] >= 5000000) {

            $userTransactionQtyBadge .= "5M.png";
            $userTransactionQtyBadgeMessage = "a godfather";

        } else if($userInformation['expTransactionQty'] >= 1000000) {

            $userTransactionQtyBadge .= "1M.png";
            $userTransactionQtyBadgeMessage = "businessperson";

        } else if($userInformation['expTransactionQty'] >= 500000) {

            $userTransactionQtyBadge .= "500K.png";
            $userTransactionQtyBadgeMessage = "Transact quite a lot";

        } else if($userInformation['expTransactionQty'] >= 100000) {

            $userTransactionQtyBadge .= "100K.png";
            $userTransactionQtyBadgeMessage = "a hundred thousand";

        } else if($userInformation['expTransactionQty'] >= 50000) {

            $userTransactionQtyBadge .= "50K.png";
            $userTransactionQtyBadgeMessage = "send send send";

        } else {

            $userTransactionQtyBadge .= "0.png";
            $userTransactionQtyBadgeMessage = "exp beginner";

        }


        // ?????? ?????? ?????? ??????
        if($userInformation['role'] === "Admin"){

            $userRoleBadge .= "Admin.png";
            $userRoleBadgemessage = "Wow, you're an admin";

        } else if($userInformation['role'] === "QA") {

            $userRoleBadge .= "QA.png";
            $userRoleBadgemessage = "Quality Assurance!";

        } else {

            $userRoleBadge .= "user.png";
            $userRoleBadgemessage = "You're a user!";

        }

    ?>

    <table class="table table-striped" id="userBadgeTable">
        <thead>
            <th>
                <img src="<?php echo $userExpBadge ?>" width="150px">
            </th>
            <th>
                <img src="<?php echo $userMessageQtyBadge ?>" width="150px">
            </th>
            <th>
                <img src="<?php echo $userTransactionQtyBadge ?>" width="150px">
            </th>
            <th>
                <img src="<?php echo $userRoleBadge ?>" width="150px">
            </th>
        </thead>
        <tbody>
            <tr>
                <td>
                    <span><strong>????????? ??????</strong></span><br>
                    <span>"<?php echo $userExpBadgeMessage ?>"</span>
                </td>
                <td>
                    <span><strong>????????? ??????</strong></span><br>
                    <span>"<?php echo $userMessageQtyBadgeMessage ?>"</span>
                </td>
                <td>
                    <span><strong>EXP ?????? ??????</strong></span><br>
                    <span>"<?php echo $userTransactionQtyBadgeMessage ?>"</span>
                </td>
                <td>
                    <span><strong>?????? ??????</strong></span><br>
                    <span>"<?php echo $userRoleBadgemessage ?>"</span>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" 
                             style="width: <?php echo $userProgressToNextExpBadgeLevel ?>%;" aria-valuenow="25" 
                             aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" 
                             style="width: <?php echo $userProgressToNextMessageQtyBadgeLevel ?>%;" aria-valuenow="25" 
                             aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" 
                             style="width: <?php echo $userProgressToNextTransactionBadgeLevel ?>%;" aria-valuenow="25" 
                             aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </td>
                <td>
                    
                </td>
            </tr>
        </tbody>
    </table>

    <table id="changeInformationForm">
        <thead>
            <tr>
                <!-- upload user's custom profile picture -->
                <!-- action="uploadUserProfilePicture.php" -->
                <td>
                    <form id="uploadUserProfilePictureForm" enctype="multipart/form-data" onsubmit="return false;">
                        <label for="formFile" class="form-label">????????? ????????? ???????????? ?????????. (1MB ??????)</label>
                        <div class="form-inline form-group">
                            <input class="form-control" type="file" name="profileImage" id="userSubmittedProfileImage">
                            <button type="submit" class="btn btn-primary" id="uploadUserProfilePictureFormSubmitButton">?????????</button>    
                        </div>
                        
                    </form>

                    <?php 

                        $id                     = $_SESSION['id'];
                        $profilePicturePath     = "../_serverasset/_userProfilePictures/" . "profilePic_" . "$id" . ".jpg";
                    
                        // ????????? ???????????? ???????????? ?????? ????????? ????????? ??????
                        // ???????????? ?????? ?????? ??????????????? ?????? ????????? ?????? ??????
                        $profilePicturePath .= "?t=" . time();      

                        echo '<img id="profileImage" src="' . $profilePicturePath . '" alt="profilePicture">';
                    
                    ?>

                </td>
                <td>
                    <!-- change current user's password -->
                    <form id="changePasswordForm" onsubmit="return false;">
                        <div class="ml-auto mr-auto mt-2">
                            <div class="mb-3">
                                <label for="current-password" class="form-label">?????? ????????????</label>
                                <input name="current-password" type="password" class="form-control" id="current-password"
                                    placeholder="?????? ??????????????? ????????? ?????????." data-isValidated="false">
                            </div>
                            <div class="mb-3">
                                <label for="new-password" class="form-label">????????? ????????????</label>
                                <input name="new-password" type="password" class="form-control" id="new-password"
                                    placeholder="???????????? ??????????????? ????????? ?????????. (8?????? ??????)" data-isValidated="false">
                            </div>
                            <div class="mb-3">
                                <label for="new-password-check" class="form-label">????????? ???????????? (?????????)</label>
                                <input name="new-password-check" type="password" class="form-control"
                                    id="new-password-check" placeholder="???????????? ??????????????? ?????? ??? ????????? ?????????."
                                    data-isValidated="false">
                            </div>
                            <button class="btn btn-primary" id="changePasswordSubmitButton">???????????? ????????????</button>
                            <div>
                    </form>
                    <!-- end -->
                </td>
                <td>
                    <!-- change current user's password -->
                    <form id="changeNicknameForm" onsubmit="return false;">
                        <div class="ml-auto mr-auto mt-2">
                            <div class="mb-3">
                                <label for="current-nickname" class="form-label">?????? ?????????</label>
                                <input name="current-nickname" type="text" class="form-control" id="current-nickname"
                                    placeholder="?????? ???????????? ????????? ?????????." data-isValidated="false">
                            </div>
                            <div class="mb-3">
                                <label for="new-nickname" class="form-label">????????? ?????????</label>
                                <input name="new-nickname" type="text" class="form-control" id="new-nickname"
                                    placeholder="????????? ????????? ???????????? ????????? ?????????." data-isValidated="false">
                            </div>
                            <div class="mb-3">
                                <label for="new-nickname-check" class="form-label">????????? ????????? (?????????)</label>
                                <input name="new-nickname-check" type="text" class="form-control"
                                    id="new-nickname-check" placeholder="????????? ????????? ???????????? ?????? ??? ????????? ?????????."
                                    data-isValidated="false">
                            </div>
                            <button class="btn btn-primary" id="changeNicknameSubmitButton">????????? ????????????</button>
                            <div>
                    </form>
                    <!-- end -->
                </td>
            </tr>
        </thead>
    </table>

    <!-- ????????? ????????? ?????? ??????...! EXP??? ?????? ???????????? ????????? ??? ??????. -->
    <form class="form-inline" id="sendExpForm" onsubmit="return false;">
        <div class="form-group mb-2">
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <label for="sendExpTarget" class="sr-only">?????? ??????</label>
            <span class="input-group-text">@</span>
            <input type="text" class="form-control" id="sendExpTarget" name="sendExpTarget" placeholder="?????? ?????? ID">
        </div>
        <h6> ?????? </h6>
        <div class="form-group mx-sm-3 mb-2">
            <label for="sendExpAmount" class="sr-only">EXP</label>
            <input type="number" class="form-control" id="sendExpAmount" name="sendExpAmount" placeholder="EXP ??? ??????">
            <span class="input-group-text">EXP</span>
        </div>
        <h6> EXP??? ????????????.&nbsp;&nbsp;</h6>
        <button type="submit" class="btn btn-primary mb-2" id="sendExpAmountSubmitButton">????????????</button>
    </form>

    <?php

        // ???????????? ?????? ??????(!) ?????????
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
    <script type="text/javascript" src="./js/checkProfilePicture.js"></script>

</html>