<?php
    header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon/logo.png">
    <title>LOGIN.LUMES.KR</title>

    <link rel="stylesheet" href="./css/signup.css">
    <script src="checkDuplication.js"></script>

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

    <!-- Google ReCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- end of Google ReCAPTCHA -->

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
                    <a class="nav-link" href="http://lumes.kr" target="_blank">LUMES.KR로 돌아가기</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">((WANNA HACK ME?))</a>
                </li>

            </ul>
        </div>
    </nav>

    <script>
        function requireReCAPTCHA() {
            if (grecaptcha.getResponse() === "") {
                alert("ReCAPTCHA를 체크해주세요.");
                return false;
            } else {
                return true;
            }
        }
    </script>

    <form action="signupProcess.php" method="POST" id="signup-form" onsubmit="return requireReCAPTCHA()">
        <div class="w-50 ml-auto mr-auto mt-5">
            <div class="mb-3 ">
                <label for="id" class="form-label">ID</label>
                <input name="id" type="text" class="form-control" id="id" placeholder="(~30 바이트)"
                    data-isValidated="false">
                <button type="button" class="btn btn-secondary" onclick="checkIDDuplication()"
                    style="position:relative; float: right; margin-top: 5px;">ID 중복 검사</button>
            </div>
            <div class="mb-3 ">
                <label for="nickname" class="form-label">닉네임</label>
                <input name="nickname" type="text" class="form-control" id="nickname" placeholder="(~30 바이트)">
            </div>
            <div class="mb-3 ">
                <label for="password" class="form-label">비밀번호</label>
                <input name="password" type="password" class="form-control" id="password" placeholder="(~255 바이트)">
            </div>
            <div class="mb-3 ">
                <label for="passwordCheck" class="form-label">비밀번호 (재확인)</label>
                <input name="passwordCheck" type="password" class="form-control" id="password-check"
                    placeholder="비밀번호를 다시 한번 입력해 주세요.">
            </div>
            <div class="mb-3 ">
                <label for="email" class="form-label">이메일</label>
                <input name="email" type="text" class="form-control" id="email"
                    placeholder="(~255바이트) | 인증 등의 문제가 있을 수 있으니 사용하시는 이메일을 쓰시길 권장합니다." data-isValidated="false">
                <button type="button" class="btn btn-secondary" onclick="checkEmailDuplication()"
                    style="position:relative; float: right; margin-top: 5px;">이메일 중복 검사</button>
            </div>

            <div class="mt-5 col text-center">
                <div class="g-recaptcha" data-sitekey="6LciGk8eAAAAAGwmpLhWQs7eGruJ7bqJK7q7Tph_"></div>
                <button type="button" id="signup-button" class="btn btn-primary mb-3"
                    style="position:relative; text-align: center; margin-top: 100px;">회원가입</button>
            </div>
        </div>
    </form>

    <script>
        
        const signupForm = document.querySelector("#signup-form");
        const signupButton = document.querySelector("#signup-button");
        const id = document.querySelector("#id");
        const nickname = document.querySelector("#nickname");
        const email = document.querySelector("#email");
        const password = document.querySelector("#password");
        const passwordCheck = document.querySelector("#password-check");

        signupButton.addEventListener("click", function (e) {

            if (id.getAttribute('data-isValidated') === "true" && email.getAttribute('data-isValidated') ===
                "true") {
                if (nickname.value === "") {
                    alert('닉네임을 입력해 주세요.');
                } else {
                    if (password.value && password.value === passwordCheck.value) {
                        signupForm.submit();
                    } else {
                        alert("비밀번호가 서로 일치하지 않습니다.");
                    }
                }
            } else {
                alert('ID와 이메일 검증을 해 주세요.');
            }
        });
    </script>
</body>

</html>