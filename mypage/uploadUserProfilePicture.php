<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN.LUMES.KR</title>
    <link rel="stylesheet" href="./css/mypage.css">
    <link rel="shortcut icon" href="/favicon/logo.png">

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- end of sweetalert -->

</head>

<body>
    <!-- 프로세스 처리 구간이라서 굳이 뭘 할 건 없음. -->
</body>

<?php

    session_start();
    header('Content-Type: text/html; charset=utf-8');
    header("Pragma: no-cache");
    header("Cache-Control: no-store, no-cache, must-revalidate"); 


    // DB connection
    require(dirname(__FILE__) . "/../dbconnection.php"); 

    $id = $_SESSION['id'];

    // 임시 파일 (프로세스 전 계류 상태)
    $tempFile = $_FILES['profileImage']['tmp_name'];

    $filename               = $_FILES['profileImage']['name'];
    list($fileType, $fileTypeExtension) = explode("/", $_FILES['profileImage']['type']);
    $fileSize               = $_FILES['profileImage']['size'];

    $isImageFileExtension   = false;

    switch($fileTypeExtension){
            case 'jpg':
            case 'jpeg':
            case 'png':
                $isImageFileExtension = true;
                break;
            
        default:
 
            ?>

                <script>
                    Swal.fire({
                        icon: 'error',
                        title: '허용되지 않는 확장자',
                        footer: '이미지 확장자로는 JPG, JPEG, PNG만 허용합니다.'
                    }).then((result) => {
                        location.href = "./mypage.php";
                    })
                </script>

            <?php

            exit;
            die();

    }

    if($fileType === "image") {

        if($isImageFileExtension) {

            // 이미지 사이즈 조정을 위한 작업
            list($imageWidth, $imageHeight) = getimagesize($tempFile);

            // 향후 따로 개인별 디렉터리 만들기 <--- 향후 구현
            $filesavePath = "../_serverasset/_userProfilePictures/" . "profilePic_" . "$id" . ".jpg";

            // 이미 예전에 프로필 사진을 업로드하여 파일이 있는 경우 지우기
            if(file_exists($filesavePath) === true) {
                unlink($filesavePath);
            }
            
            $isImageUploadSuccessful = move_uploaded_file($tempFile, $filesavePath);

            // 이미지 업로드 확인
            if($isImageUploadSuccessful === true) {

                ?>

                    <script>

                        Swal.fire({
                            icon: 'success',
                            title: '프로필 사진 업로드 완료',
                            // imageUrl: '<?php // echo $filesavePath ?>',
                            imageWidth: 400,
                            footer: '프로필 사진 변경이 성공적으로 수행되었습니다.'
                        }).then((result) => {
                            location.href = "./mypage.php"
                        })
                    </script>

                <?php

            } else {

                ?>

                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: '프로필 사진 업로드 실패',
                            footer: '프로필 사진 변경에 실패했습니다. 상황이 반복될 시, 관리자에게 문의하여 주세요.'
                        }).then((result) => {
                            location.href = "./mypage.php";
                        })
                    </script>

                    

                <?php

            }

        } else {

            // 확장자 불일치

            ?>

                <script>
                    Swal.fire({
                        icon: 'error',
                        title: '허용되지 않는 확장자!!',
                        footer: '이미지 확장자로는 JPG, JPEG, PNG만 허용합니다.'
                    }).then((result) => {
                        location.href = "./mypage.php";
                    })
                </script>

            <?php

            die();

        }

    } else {

        // 이미지 파일이 아님.

        ?>

            <script>
                Swal.fire({
                    icon: 'error',
                    title: '이미지 파일이 아닙니다.',
                    footer: '이미지(image) 파일을 업로드해 주세요.'
                }).then((result) => {
                    location.href = "./mypage.php";
                })
            </script>

        <?php

        die();

    }

?>