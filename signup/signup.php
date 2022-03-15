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

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- end of sweetalert -->

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
                Swal.fire({
                    icon: 'error',
                    title: 'ReCAPTCHA...?',
                    text: '리캡챠 확인을 해 주세요!',
                    footer: '자동가입을 방지하기 위해 ReCAPTCHA를 사용하는 중입니다.'
                })
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
                <input name="password" type="password" class="form-control" id="password" placeholder="(~255 바이트) | 8자리 이상">
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

            <!-- 개인정보 처리방침 -->
            <p>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample"
                    aria-expanded="false" aria-controls="collapseExample">
                    개인정보 처리방침 및 서비스 규약
                </button>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                귀하는 본 사이트인 login.lumes.kr에 가입함으써, 아래의 규칙 및 개인정보 처리방침에 대해 동의하게 됩니다.<br><br>

                &nbsp;&nbsp;- 귀하는 가입을 하면서 ID와 닉네임, 비밀번호, 이메일을 입력해야 하며, 이때 이메일은 실제 사용 이메일을 첨부하여야 합니다. 사용 불가능한 이메일을 임의로 넣을 경우 계정 복구 등 도움 절차에 있어 신원 파악이 불가한 바, 불이익을 받을 수 있습니다.<br><br>

                &nbsp;&nbsp;- 관리자는 정보 보안 위협에 대비하여 최대한 개인정보 보호와 보존을 지킬 의무를 가지고 있습니다. 귀하의 계정의 정보는 안전하게 처리되며, 비밀번호는 PHP 표준에 의거 hash 처리되어 보관됩니다. 또한 요청이 있을 경우, 신원 확인 후 즉시 개인정보를 폐기합니다.<br><br>

                &nbsp;&nbsp;- 이 서비스에 저장되는 모든 정보는 관리자 이외에는 열람할 수 없으며, 관리자는 제3자에게 해당 개인정보를 공유하지 않음을 약속합니다.<br><br>

                &nbsp;&nbsp;- 귀하는 본 사이트의 사용자로써, 게시판 등에서 활동시 선량하고 긍정적인 인터넷 문화를 만들어갈 책임이 있습니다. 댓글이나 방명록 작성, 기타 어떤 형태로도 무분별한 혐오 표현, 욕설, 광고, 음란물 게시, 모욕, 개인정보 유출과 같은 행위를 할 경우 실제 현행법에 의해 처벌받을 수 있으며 그 외 통보 없는 게시물 삭제 및 계정 영구 정지와 같은 별도 제재가 시행될 수 있으며, 해당 영구정지 기록은 반영구적으로 공개될 수 있습니다.<br><br>

                &nbsp;&nbsp;- 본 사이트에 대한 게시글 도배 등 모든 형태의 서비스거부공격(DoS; Denial of Service)를 금지합니다. 해당 공격 발생 시, 호스팅사나 운영자에 의해 민형사상 책임을 물을 수 있습니다.<br><br>

                &nbsp;&nbsp; - 본 사이트는 게시판 기능과 더불어 보안적인 측면도 고려하고 있기에, 이에 대한 상시 보안 점검은 환영합니다. 권한 탈취, EXP(경험치) 기능 악용, 오버플로우 등 모든 형태의 사이버 공격을 시도하실 수 있습니다. 단, 서비스거부공격과 관리자 권한 탈취 후 그 권한을 임의로 사용하는 행위, 탈취한 내용을 공공연히 배포하는 엄격히 금지합니다. 그 외 제안 사항, 잠재적 문제점 등에 대한 보고도 환영합니다.<br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;- 제안 사항에는 현행 기능 개선 내용, 새로운 기능 요청 등이 포함됩니다.<br>
                &nbsp;&nbsp;&nbsp;&nbsp;- 잠재적 문제점에는 현행 기능에서의 구조적인 문제, 코드상 결함 등이 포함됩니다.<br>
                &nbsp;&nbsp;&nbsp;&nbsp;- 보안 취약점이나 문제점, 제안 사항 등은 agerio100@naver.com으로 이메일을 남겨주시거나 이 웹페이지의 Github(https://github.com/x3onkait/LoginLumesKR)에 Issue를 남겨 주시면 조치하겠습니다.<br>
                &nbsp;&nbsp;&nbsp;&nbsp;- 보안 취약점이나 문제점, 제안 사항 등을 보고하실 때, 사용하시는 login.lumes.kr 내 계정(ID와 등록된 이메일 주소)을 알려주시면 QA(Quality Assurance) 배지를 붙여드립니다.<br>

                <br><br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;- Lumes Sage, 2022년 03월 06일 
                </div>
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

            if (id.getAttribute('data-isValidated') === "true" && email.getAttribute('data-isValidated') === "true") {
                if (nickname.value === "") {
                    Swal.fire({
                        icon: 'error',
                        title: '회원가입 오류',
                        text: '닉네임을 입력해 주세요!'
                    })
                } else {
                    if (password.value && password.value === passwordCheck.value) {
                        if(password.value.length < 8) {
                            Swal.fire({
                                icon: 'error',
                                title: '회원가입 오류',
                                text: '비밀번호 안전도 미달',
                                footer: '최소 8자리 이상의 비밀번호를 설정해주세요.'
                            })
                        } else {
                            signupForm.submit();
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '회원가입 오류',
                            text: '비밀번호 불일치',
                            footer: '비밀번호와 그 확인이 서로 일치해야 합니다. 제대로 입력하셨는지 확인해주세요.'
                        })
                    }
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: '회원가입 오류',
                    text: '검증 부재',
                    footer: '아이디와 이메일 검증을 실시해 주세요!'
                })
            }
        });
    </script>
</body>

</html>