// ID 중복 검사
function checkIDDuplication() {

    let id = document.getElementById("id").value;

    if (id) {
        url = "checkID.php?id=" + id;
        window.open(url, "check ID", "top=50, left=50, width=300, height=100");
    } else {
        alert("아이디를 입력하세요");
    }

    return;

}

//Email 중복 검사
function checkEmailDuplication() {
 
    let email = document.getElementById("email").value;

    if (email) {
        url = "checkEmail.php?email=" + email;
        window.open(url, "check Email", "top=50, left=50, width=300, height=100");
    } else {
        alert("이메일 주소를 입력하세요");
    }

    return;

}