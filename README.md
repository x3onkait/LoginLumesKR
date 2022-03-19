# LoginLumesKR
 <p align = "center">
  <img src="https://img.shields.io/github/workflow/status/x3onkait/LoginLumesKR/CodeQL">
  <img src="https://img.shields.io/github/languages/code-size/x3onkait/LoginLumesKR">
  <img src="https://img.shields.io/tokei/lines/github/x3onkait/LoginLumesKR">
  <img src="https://img.shields.io/github/languages/top/x3onkait/LoginLumesKR">
  <img src="https://img.shields.io/website?down_color=lightgray&down_message=offline&up_color=blue&up_message=online&url=http%3A%2F%2Flogin.lumes.kr">
 </p>
 로그인, 회원가입, 게시글 작성, 포인트 제도 등 잡다하게 들어가 있는 게시판 웹 서비스입니다.  
 사용 가능하고 어느정도 테스팅이 끝나 사용 가능한 항목들은  
 http://login.lumes.kr 에 접속하셔서 사용하실 수 있습니다(개발자가 호스팅 중).
 
 #### [★] 현재 ~~프로필 사진 기능~~, 실시간 채팅 기능, ~~게시판 등에서의 프로필 사진 보이기 기능~~, 레벨링 기능 등 다양한 추가 (요청된) 기능들이 잇달아 대기중이므로, 내용이 급격하게 바뀌거나 `readme.md` 업데이트가 늦어질 수 있습니다(`readme.md`는 안정적으로 기능이 정착된 경우 해당 내용을 갱신합니다.)
 
 * * *

### 간단한 소개
 **로그인 기능이 달린 간단한 방명록**으로부터 시작됐습니다. 최대 1,000자까지 글을 적을 수 있으며, 
 글을 적을 때마다 경험치(EXP)를 일점 범위 내에서 랜덤으로 제공해줍니다. 
 주변에서 제 프로젝트를 보고 이용해주는 지인들의 여러가지 재미를 위한 요청사항들을 하나하나씩 넣기도 합니다. 
 이 경험치(EXP)는 다른 사람들에게 송금할 수도 있고 열심히 모아서 리더보드(경험치 랭킹) 상위에 머무를 수도 있습니다. 
 사용성과 더불어 보안적인 측면을 고려하고 예외적인 사항이나 보안에 문제가 생길만한 상황을 줄이는데 초점이 맞추어져 있습니다. 
 따라서 reCAPTCHA나 내용 검증과 같은 보안 장치가 코드 곳곳에 숨겨져 있습니다. 상시적으로 다른 사람들에게 
 보안 점검을 부탁하고 있고 취약점이 나오면 코드를 패치하고 있습니다.


* * *

### 미리보기
 (2022년 03월 09일 기준)  
 <img src="https://imgur.com/NvKKRo4.png" width="80%" height="80%"></img>
 <img src="https://imgur.com/DGClAkL.png" width="80%" height="80%"></img>
 <img src="https://imgur.com/O4GI8uF.png" width="80%" height="80%"></img>
 <img src="https://imgur.com/NIdwesd.png" width="80%" height="80%"></img>
 
 - 각종 모습은 업데이트나 변경 사항에 따라 달라질 수 있습니다.

* * *

### 데이터베이스 관리

 - 이 프로젝트는 데이터베이스 연결을 할 때 필요한 데이터들을 한 파일(`dbconnection.php`)에 지정하고 연결 변수인 `$conn`을 다른 파일들이 필요할 때 `require()`를 통해 불러오도록 하고 있습니다. 아래 파일 내용을 필요한대로 내용을 바꾼 다음 최상위 디렉터리에 `dbconnection.php` 란 이름으로 저장해서 사용해 주세요. 보안적인 측면을 고려하여, 비록 제작자와 같이 `localhost`로 해둔다면 사실상 데이터베이스에 접근할 방법이 마땅치 않지만, 그럼에도 불구하고 보안적인 면을 고려하면 좋겠다는 의견이 있어서 이렇게 분리하게 되었습니다. 해당 파일은 `.gitignore`에 등록되어 repository에는 별도로 등록되지 않습니다.

```php
<?php

    // MYSQL 데이터베이스 로그인 및 DB 이름 정보를 한 파일에 통합해서 관리


    $servername = "_NAME_";
    $dbusername = "_DATABASE_USER_NAME_";
    $dbpassword = "_DATABASE_USER_PASSWORD_";
    $dbname     = "_DATABASE_NAME_";

    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

    if ($conn -> connect_error) {

        die("Connection failed: " . $conn -> connect_error);
    
    }

?>
```

사용 예시) 
```php
    header('Content-Type: text/html; charset=utf-8');

    // DB connection
    require(dirname(__FILE__) . "/../../dbconnection.php");

    $email = $_GET['email'];

    $query = "SELECT * FROM member WHERE email = '$email'";
    $row   = mysqli_fetch_array(mysqli_query($conn, $query));
```

* * *

### 데이터베이스 항목

- 이 웹페이지는 웹 서비스로서, 사용자들의 정보들을 저장하고 관리하기 위한 데이터베이스 운영이 필요합니다. 
- 데이터베이스의 구조(Database structure)파일은 `/database`에 테이블마다 `*.sql` 파일 형식으로 저장되어 있습니다.

`guestbook` DB 구조 (사용자가 pagination이 적용된 게시판에 직접 글을 올릴 때, 해당 내용이 저장되는 데이터베이스.)
```sql
CREATE TABLE IF NOT EXISTS `guestbook` (
  `idx` int(11) NOT NULL auto_increment COMMENT '게시글 고유 번호',
  `writer_id` varchar(255) NOT NULL COMMENT '게시글 작성자 ID',
  `writer_nickname` varchar(30) NOT NULL COMMENT '게시글 작성자 닉네임(이름)',
  `comment` varchar(1000) NOT NULL COMMENT '게시글 내용',
  `date` datetime NOT NULL COMMENT '게시글 작성 날짜',
  `ip` varchar(40) default NULL COMMENT '작성 당시에 사용된 IPv4주소',
  `role` varchar(30) NOT NULL COMMENT '게시글 작성자의 역할',
  PRIMARY KEY  (`idx`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
```
- idx : (auto_increment 적용) 게시글 유 번호
- writer_id : 게시글 작성자의 ID
- writer_nickname : 게시글 작성자의 닉네임
- comment : 게시글 내용(본문)
- date : 게시글 작성 날짜
- ip : 게시글을 작성한 당시 사용자(로그인된 사용자)의 공인IP (`$_server['REMOTE_ADDR']`)
- role : 게시글 작성자의 역할(Admin - 관리자 / QA - Quality Assurance 등..)

`member` DB 구조 (본 웹페이지에 가입하는 사용자들의 정보가 저장되는 데이터베이스.)
```sql
CREATE TABLE IF NOT EXISTS `member` (
  `idx` int(20) NOT NULL auto_increment COMMENT '유저 고유 번호(가입순서 번호)',
  `id` varchar(30) NOT NULL COMMENT '유저의 ID',
  `nickname` varchar(30) NOT NULL COMMENT '유저의 닉네임(이름)',
  `password` varchar(255) NOT NULL COMMENT '유저의 비밀번호',
  `email` varchar(255) NOT NULL COMMENT '유저의 이메일 주소',
  `exp` double NOT NULL default '100' COMMENT '유저의 경험치',
  `role` varchar(30) NOT NULL COMMENT '유저의 역할',
  `last_activity_time` datetime NOT NULL COMMENT '유저의 마지막 활동 시간(게시글 업로드 시간)',
  `guestbookQty` int(11) NOT NULL default '0' COMMENT '사용자가 올린 게시글',
  PRIMARY KEY  (`idx`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
```
- idx : (auto_increment 적용) 유저 고유 번호
- id : 유저 ID
- nickname : 유저 닉네임
- password : 유저 패스워드 (PHP의 표준 내장 함수에 따라 hash처리됨.)
- email : 유저 이메일 주소
- exp : 유저 경험치
- role : 유저 역할(Admin - 관리자 / QA - Quality Assurance 등..)
- last_activity_time : 유저의 마지막 활동 시간. 정확하게는 게시글을 올린 마지막 시간(초 단위)으로, 이를 기반으로 도배 시도 여부를 판단하고 필터링을 실시함.
- guestbookQty : 이 사용자가 `guestbook`에 올린 게시글 총 개수

`exp_transaction` DB 구조 (경험치를 주고받는 거래(transaction)에 대한 정보가 저장되는 데이터베이스)
```sql
CREATE TABLE IF NOT EXISTS `exp_transactions` (
  `idx` int(25) NOT NULL auto_increment COMMENT '트랜젝션 순서 번호',
  `transaction_number` varchar(64) NOT NULL COMMENT '트랜젝션 고유 번호(거래 정보 hash처리)',
  `type` varchar(20) NOT NULL COMMENT '트랜젝션 종류',
  `source` varchar(255) NOT NULL COMMENT '거래 당사자 (FROM)',
  `target` varchar(255) NOT NULL COMMENT '거래 당사자 (TO)',
  `amount` double NOT NULL COMMENT '거래량',
  `date` datetime NOT NULL COMMENT '거래 시간',
  PRIMARY KEY  (`idx`)
) ENGINE=MyISAM  DEFAULT CHARSET=euckr ;
```

- idx : (`auto_increment` 적용) 거래 고유 순서 번호(거래가 몇 번째 거래인지 표시하는데 그 의미가 있음.)
- transaction_number : 거래 당시의 정보들을 하나의 문자열로 이은 다음 SHA256으로 해시한 거래의 고유 번호. 거래를 검증할 때 해당 정보만 있으면 거래의 여부를 확인해 볼 수도 있음. 자세한 내용은 `/mypage/sendExp.php` 부분을 참고.
  ```php
  $transaction_number_source = $type . $id . $sendExpTarget . $sendExpAmount . $date;
  $transaction_number = hash("sha256", $transaction_number_source);
  ```
- type : 거래 종류. 일반 유저 간 송금의 경우에는 `TRANSFER`로 표시됨. 향후 거래가 늘어나면 양 늘어날 수도 있음.
- source : 거래 당사자(EXP를 보낸 사람 | FROM)
- target : 거래 당사자(EXP를 받은 사람 | TO)
- amount : 거래량. 경험치(EXP)를 재화 삼아서 최소 1EXP 단위로 송금함.
- date : 거래 성사 일시
