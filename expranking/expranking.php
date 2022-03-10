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
    <link rel="stylesheet" href="./css/expranking.css">
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

</head>

<body>

    <?php include("../navbar.php") ?>

    <?php

        // DB connection
        require(dirname(__FILE__) . "/../dbconnection.php");

        $query = "SELECT * FROM member ORDER BY exp DESC LIMIT 100";
        $result = mysqli_query($conn, $query);

        echo '<tr>';

        $rank_indicator = 1;
        $exp_unit = '&nbsp;<span style="color: gray">EXP</span>';

        // 별도의 사용자 통계
        $validated_users_count   = mysqli_fetch_array(mysqli_query($conn, "SELECT count(*) FROM `member` WHERE exp > 0"));
        $terminated_users_count  = mysqli_fetch_array(mysqli_query($conn, "SELECT count(*) FROM `member` WHERE exp < 0"));
        $total_users_count       = $validated_users_count['count(*)'] + $terminated_users_count['count(*)'];
        $validated_users_exp_sum = mysqli_fetch_array(mysqli_query($conn, "SELECT sum(exp) FROM `member` WHERE exp > 0"));

        // statistics table overall this website
        echo '<div class="ranking-table">';
            echo '<table class="table">';
                echo '<thead class="thead-light">';
                    echo '<tr>';
                        echo '<th scope="col" style="text-align: center;">총 유저 수</th>';
                        echo '<th scope="col" style="text-align: center;">실 사용자 수 / 영구정지된 사용자 수</th>';
                        echo '<th scope="col" style="text-align: center;">총 경험치</th>';
                    echo '</tr>';
                echo '</thead>';

        echo '<tr>';
            echo '<th scope="col" style="text-align: center;">' . number_format($total_users_count) . '</th>';
            echo '<th scope="col" style="text-align: center;">' . number_format($validated_users_count['count(*)']) . ' / ' . number_format($terminated_users_count['count(*)']) . '</th>';
            echo '<th scope="col" style="text-align: center;">' . number_format($validated_users_exp_sum['sum(exp)']) . $exp_unit . '</th>';
        echo '</tr>';
        

        // ranking table overall this website
        // echo '<div style="position:relative; top: 40px;">';
        echo '<div class="ranking-table">';
            echo '<table class="table">';
                echo '<thead class="thead-light">';
                    echo '<tr>';
                        echo '<th scope="col" style="text-align: center;">#</th>';
                        echo '<th scope="col" style="text-align: center;">유저 ID</th>';
                        echo '<th scope="col" style="text-align: center;">유저 닉네임</th>';
                        echo '<th scope="col" style="text-align: center;">경험치</th>';
                    echo '</tr>';
                echo '</thead>';

        while($row = mysqli_fetch_array($result)){

            echo '<tr>';

                if($row['password'] !== "redacted") {

                    if ($row['role'] === "Admin") {
                        echo '<th class="table-primary" scope="col" style="text-align: center;">' . $rank_indicator . '</th>';
                        echo '<th class="table-primary" scope="col" style="text-align: center; width: 15%;">' . $row['id'] . '&nbsp;<span class="badge badge-pill badge-primary">Admin</span>' . '</th>';
                        echo '<th class="table-primary" scope="col" style="text-align: center; width: 20%">' . $row['nickname'] . '</th>';
                        echo '<th class="table-primary" scope="col" style="text-align: center;">' . number_format($row['exp']) . $exp_unit . '</th>';
                    } else if($row['role'] === "QA") {
                        echo '<th scope="col" style="text-align: center;">' . $rank_indicator . '</th>';
                        echo '<th scope="col" style="text-align: center; width: 15%;">' . $row['id'] . '&nbsp;<span class="badge bg-dark" style="color: white;">QA</span>' . '</th>';
                        echo '<th scope="col" style="text-align: center; width: 20%">' . $row['nickname'] . '</th>';
                        echo '<th scope="col" style="text-align: center;">' . number_format($row['exp']) . $exp_unit . '</th>';
                    } else {
                        echo '<th scope="col" style="text-align: center;">' . $rank_indicator . '</th>';
                        echo '<th scope="col" style="text-align: center; width: 15%;">' . $row['id'] . '</th>';
                        echo '<th scope="col" style="text-align: center; width: 20%">' . $row['nickname'] . '</th>';
                        echo '<th scope="col" style="text-align: center;">' . number_format($row['exp']) . $exp_unit .'</th>';
                    }
                    

               } else {

                    // 영구정지된 계정
                    echo '<th class="table-danger" scope="col" style="text-align: center;">' . $rank_indicator . '</th>';
                    echo '<th class="table-danger" scope="col" style="text-align: center; width: 15%;">' . $row['id'] . '</th>';
                    echo '<th class="table-danger" scope="col" style="text-align: center; width: 20%">' . $row['nickname'] . '</th>';
                    echo '<th class="table-danger" scope="col" style="text-align: center;">' . number_format($row['exp']) . $exp_unit .'</th>';
               }

                echo '</tr>';

                $rank_indicator++;

            }

            

        

        echo '</table>';
    echo '</div>';
        

    ?>

</body>