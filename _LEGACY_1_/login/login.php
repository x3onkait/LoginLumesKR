<?php

    header('Content-Type: text/html; charset=utf-8');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN.LUMES.KR</title>
    <link rel="stylesheet" href="./css/login.css">
    <link rel="shortcut icon" href="/favicon/logo.png">

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css"
        href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

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

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
        <a class="navbar-brand" href="http://login.lumes.kr" id="navbar-brand-name">LOGIN.LUMES.KR</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="http://lumes.kr" target="_blank">LUMES.KR??? ????????????</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">((WANNA HACK ME?))</a>
                </li>

            </ul>
        </div>
    </nav>


    <form method="POST" action="loginProcess.php">
        <div id="login-form" class="w-50 ml-auto mr-auto mt-5">
            <div class="mb-3 ">
                <label for="exampleFormControlInput1" class="form-label">?????????</label>
                <input name="id" type="text" class="form-control" autocomplete="on"
                    placeholder="????????? ????????????????">
            </div>
            <div class="mb-3 ">
                <label for="exampleFormControlInput1" class="form-label">????????????</label>
                <input name="password" type="password" class="form-control" autocomplete="on"
                    placeholder="???! ?????? ???????????? ?????? ?????? ??????????????? ???????????????...">
            </div>

            <button type="submit" class="btn btn-primary mb-3">???????????????</button>

            <!-- ????????? ?????? ?????? -->
            <div id="findLoginInfoButtonGroup">
                <button type="button" onclick="location.href = './findLoginInfo/findID.php'" class="btn btn-secondary mb-3">????????? ??????</button>
                <button type="button" onclick="location.href = './findLoginInfo/findPassword.html'" class="btn btn-secondary mb-3">???????????? ??????</button>
            </div>

        </div>
    </form>

    
</body>

</html>