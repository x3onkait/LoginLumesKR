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
        
        $exp_transactions_result = mysqli_query($conn, "SELECT * FROM exp_transactions ORDER BY idx DESC LIMIT 100");
        $exp_transactions_accumulation = mysqli_fetch_array(mysqli_query($conn, "SELECT sum(amount) FROM exp_transactions"));

        $exp_unit = '&nbsp;<span style="color: gray">EXP</span>';

        
        echo '<h4 style="text-align: center; margin-top: 40px;"><b>EXP 거래 기록</b></h4>';
        

        // 총 거래량 통계 및 거래 찾기
        echo '<div class="d-flex justify-content-center">';
            echo '<button type="button" class="btn btn-info" style="text-align: center; margin-right: 10px;">총 거래량 : ' . number_format($exp_transactions_accumulation['sum(amount)']) . ' EXP</button>';
            echo '<button type="button" class="btn btn-danger" onclick="findTransaction()">거래 조회하기</button>';
        echo '</div>';

        ?>

        <?php

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

        while($row = mysqli_fetch_array($exp_transactions_result)) {

                echo '<tr>';

                    if($row['type'] === "TRANSFER") {
                        echo '<th scope="col" style="text-align: center;">' . $row['idx'] . '<br>' 
                            . '<span class="badge badge-primary" onclick="explain_TRANSFER()">TRANSFER</span>' . '</th>';
                    }
                    
                    echo '<th scope="col" style="text-align: center;">' 
                            . '<h5><span class="badge badge-light" onclick="explain_ID()">' . $row['transaction_number'] . '</span></h5>' 
                            . '<button type="button" class="btn btn-primary btn-sm" style="margin-right: 20px;" onclick="copy(\'' . $row['transaction_number'] . '\')">ID 복사</button>'
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

    <script src="./siteactivity_help.js"></script>

</body>

<script>

    async function findTransaction() {
        
        const { value: transactionHexID } = await Swal.fire({
            title: '거래 조회',
            icon: 'info',
            input: 'textarea',
            inputLabel: 'Message',
            inputPlaceholder: '거래 ID (ex. a8d910a233f8afc9...)',
            inputAttributes: {
                'aria-label': '거래 ID'
            },
            confirmButtonText: '조회하기',
            showCancelButton: true,
            cancelButtonText: '취소',
            footer: '16진수로 된 64글자 길이의 거래 ID를 입력해주세요.',

        })

        if (transactionHexID) {
            // transaction ID는 16진수
            if(isHex("0x" + transactionHexID) === true && transactionHexID.length === 64){

                location.href = "./findTransaction.php?transaction_number=" + transactionHexID;

            } else {
                Swal.fire({
                    icon: 'error',
                    title: '형식 오류',
                    text: '거래 ID가 올바르지 않습니다.',
                    footer: '<b>거래 ID는 연속된 64자리의 16진수로 이루어져 있습니다.</b>'
                })
            }

        } else {
            Swal.fire({
                icon: 'error',
                title: ':(',
                text: '거래 ID를 입력해 주세요.'
            })
        }

    }

    function isHex(num) {
        return Boolean(num.match(/^0x[0-9a-f]+$/i))
    }

    // 클립보드에 복사
    function copyToClipboard(val) {
        const t = document.createElement("textarea");
        document.body.appendChild(t);
        t.value = val;
        t.select();
        document.execCommand('copy');
        document.body.removeChild(t);
    }

    function copy(copy_string) {
        copyToClipboard(copy_string);
        toastr["success"](copy_string, "거래ID가 클립보드에 복사됨");

    }
        
</script>