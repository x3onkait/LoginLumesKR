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

<title>내 ID, 누가 쓰고 있나요?</title>

<script>
    let isIDValidated = window.opener.document.querySelector("#id");
</script>

<?php

    header('Content-Type: text/html; charset=utf-8');

    $id = $_GET['id'];

    if (!preg_match("/^[A-Za-z0-9_]+$/",$id)) {

        echo '<p id="result">ID는 영어 대소문자, 숫자 그리고 언더바(_)로만 조합될 수 있습니다. ID를 다시 만들어 주세요.</p>';
        echo '<script>isIDValidated.setAttribute("data-isValidated","false");</script>';

    }else{

        // DB connection
        require(dirname(__FILE__) . "/../dbconnection.php");
    
        $query = "SELECT * FROM member WHERE id ='{$id}'";

        $result = mysqli_query($conn, $query);
        $IDexistance = mysqli_fetch_array($result);

        if($IDexistance === NULL){
            echo '<p id="result">사용하시고자 하는 ID인 "<strong>'.$id.'</strong>"은(는) 사용가능한 아이디입니다.</p>';
            echo '<script>isIDValidated.setAttribute("data-isValidated","true");</script>';

        } else {
            echo '<p id="result">사용하시고자 하는 ID인 "<strong>'.$id.'</strong>"은(는) 이미 누군가가 사용하고 있습니다. 다른 ID를 선택해 주세요.</p>';
            echo '<script>isIDValidated.setAttribute("data-isValidated","false");</script>';

        }
    }


?>

<div class="col text-center">
    <button type="button" class="btn btn-info" onclick="window.close()">닫기</button>
</div>