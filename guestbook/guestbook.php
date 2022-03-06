<div style="position:absolute; top: 15%; left:15%; width:70%;">

    <form action="/guestbook/addMessage.php" method="post">

        <div class="form-group">
            <label for="exampleFormControlTextarea1">💻 하고 싶은 말이 있으신가요?</label>
            <?php
            if (isset($_SESSION['id'])) {

                echo '<input class="form-control" name="id" type="text" placeholder="'.$_SESSION['id'].'" readonly>';
                echo '<textarea class="form-control" name="comment" id="userComment" rows="3" style="margin-bottom: 10px;" placeholder="도배, 서비스 거부 공격(DoS) 시도, 인신공격, 모욕, 욕설, 비방, 개인정보 유출, 기타 여러 사용자에게 불쾌감을 주는 등의 게시글을 올리는 행위는 법적 처벌의 대상이 될 수 있으며 통보 없이 게시글이 제거되거나 계정이 (영구)정지될 수 있습니다. / ~1,000 바이트까지..."></textarea>';
                echo '<div class="float-right"><button type="submit" class="btn btn-primary">메시지 작성하기</button></div>';
                echo '<div class="float-right"><button type="button" class="mx-2 btn btn-info">'
                        . '<span id="counter">0 Bytes / 1,000 Bytes</span>'
                        . '</button></div>';
                echo '<div class="progress" style="width: 250px">';
                    echo '<div class="progress-bar progress-bar-striped progress-bar-animated" id="counterProgressBar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>';
                echo '</div>';

                echo '<script type="text/javascript" src="guestbook/js/guestbookTextCounter.js"></script>';

            } else {

                echo '<input class="form-control" name="id" type="text" placeholder="YOU\'RE NOT LOGGED IN" readonly>';
                echo '<textarea class="form-control" id="userComment" rows="3" style="margin-bottom: 10px;" placeholder="로그인한 사용자만 게시글을 남길 수 있어요." readonly></textarea>';
                echo '<div class="float-right"><button type="submit" class="btn btn-primary" disabled>방명록 작성하기</button></div>';

            }
            
        ?>
        </div>

    </form>

    <div style="position:relative; top: 40px;">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col" style="text-align: center;">메시지 번호</th>
                    <th scope="col" style="text-align: center;">작성자 ID</th>
                    <th scope="col" style="text-align: center;">메시지 (최근 100개)</th>
                    <th scope="col" style="text-align: center;">작성시간</th>
                </tr>
            </thead>

            <tbody>
                <?php include("showMessage.php") ?>
            </tbody>
        </table>
    </div>


</div>