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
    <link rel="stylesheet" href="./css/chat.css">
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

    <!-- chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <!-- end of chart.js -->

</head>

<body>

<?php include("../navbar.php") ?>

<?php

    if(isset($_SESSION['id'])) {

        ?>

            <!-- chatting ?????? (??????) -->
            <div class="container">
                
                <div class="chattingSelectionBar">
                    #LIST
                </div>

                <div class="chattingTitle">
                    #public (under construction!!!)
                </div>

                <div class="chattingContents">
                    
                    <?php include("./showChatMessage.php") ?>

                </div>

                <div class="chattingUserTypingForm">

                    <form action="./sendChat.php" method="POST" id="chattingForm">

                        <div class="form-inline form-group">

                            <div class="chattingUsername">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">@</span>
                                    <input type="text" class="form-control" value="<?php echo $_SESSION['id'] ?>" placeholder="Username"aria-describedby="addon-wrapping" disabled>
                                </div>
                            </div>

                            <div class="chattingMessageInput">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="userChatMessage" id="userChatMessage" placeholder="???????????? ??????????????????..." aria-describedby="basic-addon2">
                                </div>
                            </div>

                            <div class="input-group-append">
                                <div class="chattingMessageSend">
                                    <button type="submit" class="btn btn-primary" name="message" id="sendChatButton">??????</button>
                                </div>
                            </div>

                        </div>
                        
                    </form>
                    
                </div>

            </div>
            <!-- chatting ?????? (???) -->

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="./js/checkChatMessage.js"></script>
            <script src="./js/autorefresh.js"></script>

        <?php

    } else {

        ?>

            <h1> ???????????? ???????????? ????????? ????????? ??? ????????????. </h1>

        <?php

    }

?>