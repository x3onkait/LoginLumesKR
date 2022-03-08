<?php
    session_start();
    header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN.LUMES.KR</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="shortcut icon" href="/favicon/logo.png">

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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

    <!-- toastr.js -->
    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- end of toastr.js -->

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- end of sweetalert -->

    <link rel="stylesheet" type="text/css" href="./css/siteactivity.css" />

</head>



<?php

    include("../navbar.php")

?>

<body>

    <!-- <h1>under construction...</h1>
    <h6>EXP 트랜젝션, EXP 제공 기록, 계정 영구정지 기록 등 다채로운 관상용 페이지 제작 예정... www</h6> -->

    <?php

        $conn = mysqli_connect("localhost", "luminous", "alphatrox2048@@", "luminous");
        
        $query = "SELECT * FROM exp_transactions ORDER BY idx DESC LIMIT 100";
        $result = mysqli_query($conn, $query);

        $exp_unit = '&nbsp;<span style="color: gray">EXP</span>';

        echo '<h4 style="text-align: center; margin-top: 40px;"><b>EXP 거래 기록</b></h4>';

        echo '<div class="exp-transactions-table">';
            echo '<table class="table" id="exp_transaction_table">';
                echo '<thead class="thead-light">';
                    echo '<tr>';
                        echo '<th scope="col" style="text-align: center;">No.</th>';
                        echo '<th scope="col" style="text-align: center;">ID / DATE</th>';
                        echo '<th scope="col" style="text-align: center;">FROM</th>';
                        echo '<th scope="col" style="text-align: center;"></th>';
                        echo '<th scope="col" style="text-align: center;">TO</th>';
                        echo '<th scope="col" style="text-align: center;">송금 금액</th>';
                    echo '</tr>';
                echo '</thead>';

            echo '<tbody>';

        while($row = mysqli_fetch_array($result)) {

                echo '<tr>';

                    if($row['type'] === "TRANSFER") {
                        echo '<th scope="col" style="text-align: center;">' . $row['idx'] . '<br>' 
                            . '<span class="badge badge-primary" onclick="explain_TRANSFER()">TRANSFER</span>' . '</th>';
                    }
                    
                    echo '<th scope="col" style="text-align: center;">' 
                            . '<h5><span class="badge badge-light" onclick="explain_ID()">' . $row['transaction_number'] . '</span></h5>' 
                            . '<span class="badge badge-dark" onclick="explain_TRANSACTION_TIME()">Transaction Date : ' . $row['date'] . '</span></th>';

                    echo '<th scope="col" style="text-align: center;" onclick="explain_FROM()">' . $row['source'] . '</th>';
                    echo '<th scope="col" style="text-align: center;"> ▶ </th>';
                    echo '<th scope="col" style="text-align: center;" onclick="explain_TO()">' . $row['target'] . '</th>';
                    echo '<th scope="col" style="text-align: center;" onclick="explain_AMOUNT()">' . number_format($row['amount']) . $exp_unit . '</th>';

                echo '</tr>';

        }

                echo '</tbody>';
            echo '</table>';
        echo '</div>';

    ?>

</body>

<script>

    // TRANSACTION 도움말

    function explain_TRANSFER(){
        Swal.fire({
            icon: 'question',
            title: '도움말',
            text: 'TRANSFER',
            footer: '<b>사용자 간 마이페이지의 EXP 송금 기능을 통해 EXP를 주고받은 경우에 해당하는 거래 종류입니다.'
                    + '따라서 EXP를 준 유저(FROM)와 받은 유저(TO)가 반드시 존재합니다.</b>'
        })
    }

    function explain_ID(){
        Swal.fire({
            icon: 'question',
            title: '도움말',
            text: 'ID',
            footer: '<b>송수신측간 이루어진 거래에 대한 정보를 한 문자열로 취합하여 SHA256처리한 고유 거래 번호입니다.'
                    + 'sha256($거래타입 + $송신자ID + $수신자ID + $거래량(정수) + $거래일시(Y-m-d H:i:s.u));와 같이 저장됩니다.' 
                    + '자세한 내용은 Github에 올라간 공개 코드를 참조해주세요.</b>'
        })
    }

    function explain_TRANSACTION_TIME(){
        Swal.fire({
            icon: 'question',
            title: '도움말',
            text: 'DATE',
            footer: '<b>당사자 간 거래가 성사된 일시입니다.</b>'
        })
    }

    function explain_FROM(){
        Swal.fire({
            icon: 'question',
            title: '도움말',
            text: 'FROM',
            footer: '<b>EXP를 송금한 사람의 ID입니다.</b>'
        })
    }

    function explain_TO(){
        Swal.fire({
            icon: 'question',
            title: '도움말',
            text: 'FROM',
            footer: '<b>EXP를 송금받은 사람의 ID입니다.</b>'
        })
    }

    function explain_AMOUNT(){
        Swal.fire({
            icon: 'question',
            title: '도움말',
            text: 'AMOUNT',
            footer: '<b>송금한 EXP의 양입니다. 최소단위는 1EXP이며 양의 정수입니다.</b>'
        })
    }

</script>