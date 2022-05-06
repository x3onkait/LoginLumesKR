const changeNicknameForm                = document.querySelector("#changeNicknameForm");
const changeNicknameFormSubmitButton    = document.querySelector("#changeNicknameSubmitButton");
const currentNickname                   = document.querySelector("#current-nickname");
const newNickname                       = document.querySelector("#new-nickname");
const newNicknameCheck                  = document.querySelector("#new-nickname-check");

changeNicknameFormSubmitButton.addEventListener("click", function(e){

    if(currentNickname.value !== "" && newNickname.value !== "" && newNicknameCheck.value !== ""){
        
        if(newNickname.value !== newNicknameCheck.value) { 

            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: '변경하려는 닉네임이 정확하지 않습니다.',
                footer: '재입력 항목과 내용이 정확해야 합니다.'
            })

        } else {

            Swal.fire({
                title: '닉네임을 정말로...',
                text: "바꿀까요?",
                icon: 'question',
                footer: '<b>닉네임 변경 이전의 활동에는 변경이 적용되지 않습니다!</b>',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '아뇨...',
                confirmButtonText: '네!'
            }).then((result) => {
                if (result.isConfirmed) {
                    changeNicknameForm.action = "changeNickname.php";
                    changeNicknameForm.method = "POST";
                    changeNicknameForm.submit();
                }
            })
        }

    } else {

        Swal.fire({
            icon: 'error',
            title: 'ERROR',
            text: '닉네임 변경 폼에 있는 모든 항목을 입력해 주세요.',
            footer: '분명 빈 칸이 존재할 겁니다.'
        })

    }

});