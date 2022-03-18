function reloadPage() {

    let messageBody = document.querySelector('.chattingContents');

    // 처음에 한 번은 즉시 실행
    $( "#userLiveChatTable" ).load(window.location.href + " #userLiveChatTable" );
    messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;

    setInterval(function(){
        
        // 메시지 페이지 갱신
        $( "#userLiveChatTable" ).load(window.location.href + " #userLiveChatTable" );

        // 메시지 스크롤 바 계속해서 아래로 내리기
        messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;

    }, 1000);

}

window.onload = reloadPage();