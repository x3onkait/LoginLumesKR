<title>내 Email, 누가 쓰고 있나요?</title>

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

<script>
    let isEmailValidated = window.opener.document.querySelector("#email");
</script>

<?php

    header('Content-Type: text/html; charset=utf-8');

    $email = $_GET['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        echo '<p id="result">입력하신 내용은 올바른 이메일 주소 형식이 아닙니다.</p>';
        echo '<script>isEmailValidated.setAttribute("data-isValidated","false");</script>';

    }else{

        // DB connection
        require(dirname(__FILE__) . "/../dbconnection.php");    
    
        $query = "SELECT * FROM member WHERE email ='{$email}'";

        $result = mysqli_query($conn, $query);
        $EmailExistance = mysqli_fetch_array($result);

        if($EmailExistance === NULL){
            echo '<p id="result">사용하시고자 하는 Email 주소인 "<strong>'.$email.'</strong>"은(는) 사용 가능한 주소입니다.</p>';
            echo '<script>isEmailValidated.setAttribute("data-isValidated","true");</script>';

        } else {
            echo '<p id="result">사용하시고자 하는 Email 주소인 "<strong>'.$email.'</strong>"은(는) 이미 누군가가 사용하고 있습니다. 다른 이메일 주소를 선택해 주세요.</p>';
            echo '<script>isEmailValidated.setAttribute("data-isValidated","false");</script>';

        }

    }


?>

<div class="col text-center">
    <button type="button" class="btn btn-info" onclick="window.close()">닫기</button>
</div>