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