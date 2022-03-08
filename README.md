# LoginLumesKR
 로그인, 회원가입, 게시글 작성, 포인트 제도 등 잡다하게 들어가 있는 게시판 웹 서비스입니다.  
 사용 가능하고 어느정도 테스팅이 끝나 사용 가능한 항목들은  
 [login.lumes.kr](http://login.lumes.kr)에 접속하셔서 사용하실 수 있습니다(개발자가 호스팅 중).



### 데이터베이스 항목

`guestbook` DB 구조 (사용자가 pagination이 적용된 게시판에 직접 글을 올릴 때, 해당 내용이 저장되는 데이터베이스.)
```sql
CREATE TABLE IF NOT EXISTS `guestbook` (
  `idx` int(11) NOT NULL auto_increment,
  `writer_id` varchar(255) NOT NULL,
  `writer_nickname` varchar(30) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `date` datetime NOT NULL,
  `role` varchar(30) NOT NULL,
  PRIMARY KEY  (`idx`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8
```
- idx : (auto_increment 적용) 게시글 유 번호
- writer_id : 게시글 작성자의 ID
- writer_nickname : 게시글 작성자의 닉네임
- comment : 게시글 내용(본문)
- date : 게시글 작성 날짜
- role : 게시글 작성자의 역할(Admin - 관리자 / QA - Quality Assurance 등..)

`member` DB 구조 (본 웹페이지에 가입하는 사용자들의 정보가 저장되는 데이터베이스.)
```sql
CREATE TABLE IF NOT EXISTS `member` (
  `idx` int(20) NOT NULL auto_increment,
  `id` varchar(30) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `exp` int(20) NOT NULL default '100',
  `role` varchar(30) NOT NULL,
  `last_activity_time` datetime NOT NULL,
  PRIMARY KEY  (`idx`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;
```
- idx : (auto_increment 적용) 유저 고유 번호
- id : 유저 ID
- nickname : 유저 닉네임
- password : 유저 패스워드 (PHP의 표준 내장 함수에 따라 hash처리됨.)
- email : 유저 이메일 주소
- exp : 유저 경험치
- role : 유저 역할(Admin - 관리자 / QA - Quality Assurance 등..)
- last_activity_time : 유저의 마지막 활동 시간. 정확하게는 게시글을 올린 마지막 시간(초 단위)으로, 이를 기반으로 도배 시도 여부를 판단하고 필터링을 실시함.

