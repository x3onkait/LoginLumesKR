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

    <!-- chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <!-- end of chart.js -->

</head>

<body>

    <?php include("../navbar.php") ?>

    <?php

        echo '<canvas id="expranking-bar-chart-horizontal" width="600" height="250"></canvas>';

        // DB connection
        require(dirname(__FILE__) . "/../dbconnection.php");

        $query = "SELECT * FROM member ORDER BY exp DESC LIMIT 100";
        $result = mysqli_query($conn, $query);

        echo '<tr>';

        $rank_indicator = 1;
        $exp_unit = '&nbsp;<span style="color: gray">EXP</span>';

        // ????????? ????????? ??????
        $validated_users_count   = mysqli_fetch_array(mysqli_query($conn, "SELECT count(*) FROM `member` WHERE exp >= 0"));
        $terminated_users_count  = mysqli_fetch_array(mysqli_query($conn, "SELECT count(*) FROM `member` WHERE exp < 0"));
        $total_users_count       = $validated_users_count['count(*)'] + $terminated_users_count['count(*)'];
        $validated_users_exp_sum = mysqli_fetch_array(mysqli_query($conn, "SELECT sum(exp) FROM `member` WHERE exp > 0"));

        // statistics table overall this website
        echo '<div class="ranking-table">';
            echo '<table class="table">';
                echo '<thead class="thead-light">';
                    echo '<tr>';
                        echo '<th scope="col" style="text-align: center;">??? ?????? ???</th>';
                        echo '<th scope="col" style="text-align: center;">??? ????????? ??? / ??????????????? ????????? ???</th>';
                        echo '<th scope="col" style="text-align: center;">??? ?????????</th>';
                    echo '</tr>';
                echo '</thead>';

        echo '<tr>';
            echo '<th scope="col" style="text-align: center;">' . number_format($total_users_count) . '</th>';
            echo '<th scope="col" style="text-align: center;">' . number_format($validated_users_count['count(*)']) . ' / ' . number_format($terminated_users_count['count(*)']) . '</th>';
            echo '<th scope="col" style="text-align: center;">' . number_format($validated_users_exp_sum['sum(exp)']) . $exp_unit . '</th>';
        echo '</tr>';
        echo '</div>';

        // ??????????????????
        $limit = 10;

        if(isset($_GET["page"])){
            $page = intval($_GET["page"]);
        } else {
            $page = 1;
        }

        $start_from = ($page - 1) * $limit;
        $result_with_limit = mysqli_query($conn, "SELECT * FROM member ORDER BY exp DESC LIMIT {$start_from}, {$limit}");

        $totalPage = intval(ceil(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM member")) / $limit));        // ?????? ????????? ??? ????????? ??????

        // ?????????????????? ?????? ??? (???????????? ???????????? ?????? ??????)
        echo '<div style="margin-top: 60px;" id="expRankingPaginationBar">';
        echo '<ul class="pagination justify-content-center">';

            echo '<li class="page-item">';
                echo '<a class="page-link" href="?page=1">??? ?????? ?????????</a>';
            echo '</li>';

                // previous button
                if($page === 1){
                    // ??? ?????? ???????????? ?????? ?????? ????????? ?????? ?????? ??????
                    echo '<li class="page-item disabled">';
                        echo '<a class="page-link" href="#" tabindex="-1">?????? ?????????</a>';
                    echo '</li>';
                }else{
                    echo '<li class="page-item">';
                        echo '<a class="page-link" href="?page='.($page - 1).'">?????? ?????????</a>';
                    echo '</li>';
                }

                // selection button
                for($pageSequence = $page - 5; $pageSequence <= $page + 5; $pageSequence++){
                    if($pageSequence < 1)
                        continue;
                    if($pageSequence === $page){
                        echo '<li class="page-item active" aria-current="page">';
                            echo '<a class="page-link" href="?page='.$pageSequence.'">'.$pageSequence.'</a>';
                        echo '</li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="?page='.$pageSequence.'">'.$pageSequence.'</a></li>';
                    }
                    if($pageSequence >= $totalPage)
                        break;
                }

                // next button
                if($page === $totalPage){
                    // ??? ????????? ???????????? ?????? ?????? ????????? ?????? ?????? ??????
                    echo '<li class="page-item disabled">';
                        echo '<a class="page-link" href="#" tabindex="-1">?????? ?????????</a>';
                    echo '</li>';
                } else {
                    echo '<li class="page-item">';
                        echo '<a class="page-link" href="?page='.($page + 1).'">?????? ?????????</a>';
                    echo '</li>';
                }

                echo '<li class="page-item">';
                    echo '<a class="page-link" id="lastpage" href="?page='.($totalPage).'">????????? ?????????</a>';
                echo '</li>';

            echo '</ul>';
        echo '</div>';

        // ?????????????????? ???

        // ranking table overall this website
        // echo '<div style="position:relative; top: 40px;">';
        echo '<div class="ranking-table">';
            echo '<table class="table">';
                echo '<thead class="thead-light">';
                    echo '<tr>';
                        echo '<th scope="col" style="text-align: center;">#</th>';
                        echo '<th scope="col" style="text-align: center;">?????? ID</th>';
                        echo '<th scope="col" style="text-align: center;">?????? ?????????</th>';
                        echo '<th scope="col" style="text-align: center;">?????????</th>';
                    echo '</tr>';
                echo '</thead>';

        // ????????? ????????? ?????? ?????? ????????? ????????? ?????????
        $exprankingUsernameData = "[";
        $exprankingUserExpamountData = "[";

        $rank_indicator = ($page - 1) * 10 + 1;

        while($row = mysqli_fetch_array($result_with_limit)){

            $exprankingUsernameData .= "\"" . $row['id'] . "\"" . ",";
            $exprankingUserExpamountData .= $row['exp'] . ",";

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

                    // ??????????????? ??????
                    echo '<th class="table-danger" scope="col" style="text-align: center;">' . $rank_indicator . '</th>';
                    echo '<th class="table-danger" scope="col" style="text-align: center; width: 15%;">' . $row['id'] . '</th>';
                    echo '<th class="table-danger" scope="col" style="text-align: center; width: 20%">' . $row['nickname'] . '</th>';
                    echo '<th class="table-danger" scope="col" style="text-align: center;">' . number_format($row['exp']) . $exp_unit .'</th>';
               }

                echo '</tr>';

                $rank_indicator++;

            }

            $exprankingUsernameData .= "]";
            $exprankingUserExpamountData .= "]";
        

        echo '</table>';
    echo '</div>';

    ?>

</body>

<script>

    Chart.defaults.global.defaultFontFamily = "lumes";

    let currentRankingIndex = <?php echo $rank_indicator ?>;

    new Chart(document.getElementById("expranking-bar-chart-horizontal"), {
        type: 'horizontalBar',
        data: {
        labels: <?php echo $exprankingUsernameData ?>,
        datasets: [
            {
                label: "EXP",
                backgroundColor: ["#C33764", "#B53565","#A73567","#913268","#722F6B", "#5F2D6C", "#4B2A6D", "#4B2A6D", "#2F286F", "#1D2671"],
                data: <?php echo $exprankingUserExpamountData ?>
            }
        ]
        },
        options: {
            responsive: false,
            legend: { display: false },
            title: {
                display: true,
                text: 'EXP ?????? (' + (currentRankingIndex - 10) + '??? ~ ' + (currentRankingIndex - 1) + '???)'
            },
            scales: {
                xAxes: [
                    {
                        ticks: {
                            callback: function(label, index, labels) {
                                // SI suffix??? ?????? ?????????
                                if(label >= 100000000000){
                                    return label / 100000000000 + 'T';
                                } else if(label >= 1000000000) {
                                    return label / 1000000000 + 'G';
                                } else if(label >= 1000000) {
                                    return label / 1000000 + 'M';
                                } else if(label >= 1000) {
                                    return label / 1000 + 'K';
                                }
                                
                            }
                        },
                        scaleLabel: {
                            display: true,
                            labelString: '1k = 1??? / 1M : 1?????? / 1G : 10??? / 1T : 1???'
                        }
                    }
                ]
            }
        }
    });

</script>