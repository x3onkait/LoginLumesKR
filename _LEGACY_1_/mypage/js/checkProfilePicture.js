const image                     = document.querySelector("#userSubmittedProfileImage");
const imageUploadButton         = document.querySelector("#uploadUserProfilePictureFormSubmitButton");
const imageSubmitForm           = document.querySelector("#uploadUserProfilePictureForm");


imageUploadButton.addEventListener("click", function(e){

    if(image.value !== ""){
        // 이미지 있음
        let imageSize = image.files[0].size;
        let imageSizeinKiloBytes = parseInt(imageSize / 1024).toLocaleString('ko-KR');

        if(imageSize > (1024 * 1024)){

            // 파일 용량 초과

            Swal.fire({
                icon: 'error',
                title: '파일이 너무 큽니다!',
                footer: '프로필 사진은 1MB(1,024KB)를 초과해서는 안 됩니다. 현재 크기는' + imageSizeinKiloBytes + 'KB 입니다.' 
            })

        } else {

            // 전송 시도
            Swal.fire({
                title: '프로필 이미지 변경',
                text: "업로드할까요?",
                icon: 'question',
                footer: '기존의 프로필 사진을 대체하게 됩니다. 또한, 프로필사진은 기본적인 네티켓(인터넷 예절)과 서비스이용약관을 위배해서는 안 됩니다.',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '아뇨...',
                confirmButtonText: '네!'
            }).then((result) => {
                if (result.isConfirmed) {
                    imageSubmitForm.action = "uploadUserProfilePicture.php";
                    imageSubmitForm.method = "POST";
                    imageSubmitForm.submit();
                }
            })

        }

    } else {
        // 이미지 없음
        Swal.fire({
            icon: 'error',
            title: 'ERROR',
            text: '이미지 없음',
            footer: '이미지를 먼저 선택하고 전송을 시도해 보세요.'
        })
    }

});