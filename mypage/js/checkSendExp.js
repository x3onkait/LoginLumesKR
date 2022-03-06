const sendExpForm               = document.querySelector("#sendExpForm");
const sendExpFormSubmitButton   = document.querySelector("#sendExpAmountSubmitButton");
const sendExpTarget             = document.querySelector("#sendExpTarget");
const sendExpAmount             = document.querySelector("#sendExpAmount");

sendExpFormSubmitButton.addEventListener("click", function(e){

    if(sendExpTarget.value !== "" && sendExpAmount.value !== "") {

        // 유효한 경험치를 보내려고 시도하고 있는가? (정수 확인 및 양수 여부 확인)
        if(sendExpAmount.value % 1 === 0 && sendExpAmount.value > 0) {

            // 전송 시도
            Swal.fire({
                title: '경험치를 정말로...',
                text: "송금할까요?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '아뇨...',
                confirmButtonText: '네!'
            }).then((result) => {
                if (result.isConfirmed) {
                    sendExpForm.action = "sendExp.php";
                    sendExpForm.method = "POST";
                    sendExpForm.submit();
                }
            })

        } else {

            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: '보내시려는 경험치가 유효하지 않습니다.',
                footer: '<b>양의 정수 외의 값은 허용되지 않습니다.</b>'
            })

        }

    } else {

        Swal.fire({
            icon: 'error',
            title: 'ERROR',
            text: '경험치 송금 폼에 있는 모든 항목을 입력해 주세요.',
            footer: '분명 빈 칸이 존재할 겁니다.'
        })

    }

});