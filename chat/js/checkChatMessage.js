const chatMessage                       = document.querySelector("#userChatMessage");
const chatMessageSubmitButton           = document.querySelector("#sendChatButton");
const chattingForm                      = document.querySelector("#chattingForm");


chatMessageSubmitButton.addEventListener("click", function(e){

    if(chatMessage.value !== "") {

        chattingForm.action = "sendChat.php";
        chattingForm.method = "POST";
        chattingForm.submit();

    } else {

        // 이미지 없음
        Swal.fire({
            icon: 'error',
            title: 'ERROR',
            text: '채팅 메시지 없음',
            footer: '메시지를 입력해 주세요!'
        })

    }

})