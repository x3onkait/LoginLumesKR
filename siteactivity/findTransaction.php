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

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- end of sweetalert -->

    <link rel="stylesheet" href="./css/findTransaction.css">

</head>

<body>
    <!-- 프로세스 처리 구간이라서 굳이 뭘 할 건 없음. -->
</body>

<?php

    // DB connection
    require(dirname(__FILE__) . "/../dbconnection.php");

    $transaction_number = $_GET['transaction_number'];

    $query = "SELECT * FROM exp_transactions WHERE transaction_number = '$transaction_number'";
    $result = mysqli_fetch_array(mysqli_query($conn, $query));

    if($result === NULL){

        // 거래정보 없음
        ?>

        <script>

            Swal.fire({
                icon: 'error',
                title: '거래정보 없음',
                footer: '주어진 ID에 대응되는 거래 내역이 존재하지 않습니다.'
            }).then((result) => {
                location.href = "./siteactivity.php";
            })

        </script>

        <?php

    } else {

        // 거래정보 있음
        ?>

        <script>

            Swal.fire({
                icon: 'success',
                title: '거래정보 있음',
                footer: '주어진 ID에 대응되는 거래 내역이 존재합니다!'
            }).then((result) => {
                Swal.fire({
                    icon: 'info',
                    title: '거래 정보',
                    footer:   '<table style="table-layout: fixed; width: 100%">'
                            + '<tbody>'
                            +   '<tr class="table-info">'
                            +        '<td style="width: 30%; text-align: center;"> 거래 ID </td>'
                            +        '<td style="word-wrap: break-word; text-align: center; font-weight:bold"> <?php echo $result["transaction_number"] ?> </td>'
                            +   '</tr>'
                            +   '<tr>'
                            +        '<td style="width: 30%; text-align: center;"> 거래 타입 </td>'
                            +        '<td style="word-wrap: break-word; text-align: center; font-weight:bold"> <?php echo $result["type"] ?> </td>'
                            +   '</tr>'
                            +   '<tr>'
                            +        '<td style="text-align: center;"> 거래 일시</td>'
                            +        '<td style="word-wrap: break-word; text-align: center; font-weight:bold"> <?php echo $result["date"] ?> </td>'
                            +   '</tr>'
                            +   '<tr>'
                            +       '<td style="text-align: center;"> 거래 당사자 </td>'
                            +       '<td style="word-wrap: break-word; text-align: center; font-weight:bold"> <?php echo $result['source'] ?> ▶ <?php echo $result['target'] ?> </td>'
                            +   '</tr>'
                            +   '<tr>'
                            +       '<td style="text-align: center;"> 거래량 </td>'
                            +       '<td style="word-wrap: break-word; text-align: center; font-weight:bold"> <?php echo number_format($result['amount']) ?> EXP</td>'
                            +   '</tr>'
                            + '</table>'
                }).then((result) => {
                    location.href = "./siteactivity.php";
                })
            })

        </script>
        <?php

    }

?>