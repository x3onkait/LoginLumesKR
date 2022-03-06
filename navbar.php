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
                    ?>

            <div id="buttons-for-logged-user">
                <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover"
                    id="exp" data-placement="bottom" title="성공적으로 로그인하셨어요!">
                    경험치 : <?php echo number_format($_SESSION['exp']); ?> EXP
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


<script>
toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

$("#loggeduser").on("click", function () {
    toastr["success"]("<?php echo $_SESSION["id"]; ?>님으로 로그인 되어 있어요.", "로그인됨");
});

$("#exp").on("click", function () {
    toastr["success"]("방명록에 댓글을 남기시면 개당 500EXP ~ 800EXP의 경험치를 드려요!", "EXP");
});

$("#logout").on("click", function () {
    Swal.fire({
        title: "정말로 로그아웃 하실건가요?",
        text: "원하신다면 언제든지 다시 로그인하세요!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '로그아웃 진행',
        cancelButtonText: '취소'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'See you soon!',
                '로그아웃 되었습니다.',
                'success'
            ).then(() => location.href = "/logout/logoutProcess.php");
        }
    });
});
</script>