    <!-- navbar navbar-expand-lg navbar-light bg-light -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
        <a class="navbar-brand" href="http://login.lumes.kr" id="navbar-brand-name">LOGIN.LUMES.KR</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <!-- <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li> -->
                <li>
                    <a class="nav-link" href="http://lumes.kr" target="_blank">LUMES.KR</a>
                </li>
                <li>
                    <a class="nav-link" href="https://github.com/x3onkait/LoginLumesKR" target="_blank">Github</a>
                </li>
                <li>
                    <a class="nav-link" href="/expranking/expranking.php">경험치 랭킹</a>
                </li>
                <li>
                    <a class="nav-link" href="/siteactivity/siteactivity.php">액티비티</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">((절대 누를 수 없는 버튼))</a>
                </li>
            </ul>

            <?php
            
                        if (isset($_SESSION['id'])) {


                        // 경험치(exp)에 대한 내용은 세션과 데이터베이스 간 차이로부터 발생하는
                        // 오류를 없애기 위해 무조건 DB에서 데이터를 그때그때 받아와서 사용
                        header('Content-Type: text/html; charset=utf-8');

                        $conn = mysqli_connect("localhost", "luminous", "alphatrox2048@@", "luminous");
                        
                        $id = $_SESSION['id'];
                        $query = "SELECT * FROM member where id='$id'";
                        
                        $result = mysqli_fetch_array(mysqli_query($conn, $query));

                        $exp = $result['exp'];

                        // 중간에 계정 정지당한 경우
                        if($result['password'] === "redacted") {

                            ?>

                                <script>

                                Swal.fire({
                                    icon: 'error',
                                    title: '계정 영구 정지 알림',
                                    text: '',
                                    footer: '심각한 수준의 서비스 정책 위반이 확인되어 계정이 영구 정지되었습니다.'
                                }).then((result) => {
                                    location.href = "./logout/logoutProcess.php";
                                });

                            </script>

                            <?php

                            die();

                        }

                    ?>

            <div id="buttons-for-logged-user">
                <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover"
                    id="exp" data-placement="bottom" title="성공적으로 로그인하셨어요!">
                    경험치 : <?php echo number_format($exp); ?> EXP
                </button>
                <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover"
                    id="loggeduser" data-placement="bottom" title="성공적으로 로그인하셨어요!">
                    <?php echo $_SESSION['id'] ?>님
                </button>
                <a role="button" class="btn btn-primary" href="/mypage/mypage.php">
                    마이페이지
                </a>
                <button type="button" class="btn btn-danger" id="logout" data-container="body" data-toggle="popover"
                    data-placement="bottom" title="세션을 파기합니다.">
                    로그아웃
                </button>
            </div>

            <script src="/navbar_toastr.js"></script>

            

            <?php
                } else {
            ?>

            <div id="buttons-for-not-logged-user">
                <button type="button" class="btn btn-success" data-container="body" data-toggle="popover"
                    data-placement="bottom" title="계정이 없으셔도 괜찮아요! 회원가입을 해 보세요!"
                    onclick="location.href='/signup/signup.php'">
                    회원가입
                </button>
                <button type="button" class="btn btn-primary" data-container="body" data-toggle="popover"
                    data-placement="bottom" title="이미 계정이 있으신가요? 로그인하세요!" onclick="location.href='/login/login.php'">
                    로그인
                </button>
            </div>

            <?php
                    }
            ?>
        </div>
    </nav>