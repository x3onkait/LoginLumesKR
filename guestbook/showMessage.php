<?php
// header('Content-Type: text/html; charset=utf-8');

// DB connection
require(dirname(__FILE__) . "/../dbconnection.php");

$limit = 20;

if(isset($_GET["page"])){
    $page = intval($_GET["page"]);
} else {
    $page = 1;
}

$start_from = ($page - 1) * $limit;
$result_with_limit = mysqli_query($conn, "SELECT * FROM guestbook ORDER BY idx DESC LIMIT {$start_from}, {$limit}");


$totalPage = intval(ceil(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM guestbook")) / $limit));        // 표시 가능한 총 페이지 개수

// 페이지네이션 선택 바 (유저들이 클릭해서 보는 부분)
echo '<div style="margin-top: 60px;">';
    echo '<ul class="pagination justify-content-center">';

        echo '<li class="page-item">';
            echo '<a class="page-link" href="?page=1">맨 처음 페이지</a>';
        echo '</li>';
        
        // previous button
        if($page === 1){
            // 맨 처음 페이지인 경우 이전 페이지 버튼 사용 불가
            echo '<li class="page-item disabled">';
                echo '<a class="page-link" href="#" tabindex="-1">이전 페이지</a>';
            echo '</li>';
        }else{
            echo '<li class="page-item">';
                echo '<a class="page-link" href="?page='.($page - 1).'">이전 페이지</a>';
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
            // 맨 마지막 페이지인 경우 다음 페이지 버튼 사용 불가
            echo '<li class="page-item disabled">';
                echo '<a class="page-link" href="#" tabindex="-1">다음 페이지</a>';
            echo '</li>';
        } else {
            echo '<li class="page-item">';
                echo '<a class="page-link" href="?page='.($page + 1).'">다음 페이지</a>';
            echo '</li>';
        }

        echo '<li class="page-item">';
            echo '<a class="page-link" id="lastpage" href="?page='.($totalPage).'">마지막 페이지</a>';
        echo '</li>';

    echo '</ul>';
echo '</div>';

?> 

<div style="position:relative; top: 40px;">
        <table class="table" style="table-layout: fixed; width: 100%">
            <colgroup>
                <col width="10%" /> 
                <col width="15%" /> 
                <col width="60%" /> 
                <col width="15%" /> 
            </colgroup>
            <thead class="thead-light">
                <tr>
                    <th scope="col" style="text-align: center;">메시지 번호</th>
                    <th scope="col" style="text-align: center;">작성자 ID</th>
                    <th scope="col" style="text-align: center;" style="width:700px;">메시지 (최근 100개)</th>
                    <th scope="col" style="text-align: center;">작성시간</th>
                </tr>
            </thead>

            <tbody>

                <?php

                while ($row = mysqli_fetch_array($result_with_limit)) {
                    echo '<tr>';

                    if ($row['role'] === "Admin") {
                        echo '<td class="table-primary" scope="col" style="text-align: center;">' . $row['idx'] . '</td>';
                        echo '<th class="table-primary" scope="col" style="text-align: center;">' . $row['writer_id'] . ' (' . $row['writer_nickname'] . ')' . '&nbsp;<span class="badge badge-pill badge-primary">Admin</span>' . '</th>';
                        echo '<td class="table-primary" scope="col" style="word-wrap: break-word;">' . $row['comment'] . '</td>';
                        echo '<td class="table-primary" scope="col" style="text-align: center;">' . $row['date'] . '</td>';
                    }
                    else if ($row['role'] === "QA") {
                        echo '<td scope="col" style="text-align: center;">' . $row['idx'] . '</td>';
                        echo '<th scope="col" style="text-align: center;">' . $row['writer_id'] . ' (' . $row['writer_nickname'] . ')' . '&nbsp;<span class="badge bg-dark" style="color: white;">QA</span>' . '</th>';
                        echo '<td scope="col" style="word-wrap: break-word;">' . $row['comment'] . '</td>';
                        echo '<td scope="col" style="text-align: center;">' . $row['date'] . '</td>';
                    }
                    else {
                        echo '<td scope="col" style="text-align: center;">' . $row['idx'] . '</td>';
                        echo '<th scope="col" style="text-align: center;">' . $row['writer_id'] . ' (' . $row['writer_nickname'] . ')' . '</th>';
                        echo '<td scope="col" style="word-wrap: break-word;">' . $row['comment'] . '</td>';
                        echo '<td scope="col" style="text-align: center;">' . $row['date'] . '</td>';
                    }

                    echo '</tr>';
                }

                ?>
                
            </tbody>
        </table>
    </div>