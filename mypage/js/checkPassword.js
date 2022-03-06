const changePasswordForm = document.querySelector("#changePasswordForm");
const changePasswordFormSubmitButton = document.querySelector("#changePasswordSubmitButton");
const currentPassword = document.querySelector("#current-password");
const newPassword = document.querySelector("#new-password");
const newPasswordCheck = document.querySelector("#new-password-check");

changePasswordFormSubmitButton.addEventListener("click", function (e) {

    if (currentPassword.value !== "" && newPassword.value !== "" && newPasswordCheck.value !== "") {

        if (newPassword.value !== newPasswordCheck.value) {
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: '변경하려는 비밀번호가 정확하지 않습니다.',
                footer: '재입력 항목과 내용이 정확해야 합니다.'
            })
        } else {
            Swal.fire({
                title: '비밀번호를 정말로...',
                text: "바꿀까요?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '아뇨...',
                confirmButtonText: '네!'
            }).then((result) => {
                if (result.isConfirmed) {
                    changePasswordForm.action = "changePassword.php";
                    changePasswordForm.method = "POST";
                    changePasswordForm.submit();
                }
            })
        }
    } else {
        Swal.fire({
            icon: 'error',
            title: 'ERROR',
            text: '비밀번호 변경 폼에 있는 모든 항목을 입력해 주세요.',
            footer: '분명 빈 칸이 존재할 겁니다.'
        })
    }
});