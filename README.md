# LoginLumesKR
 로그인, 회원가입, 게시글 작성, 포인트 제도 등 잡다하게 들어가 있는 게시판 웹 서비스입니다.  
 사용 가능하고 어느정도 테스팅이 끝나 사용 가능한 항목들은  
 [login.lumes.kr](http://login.lumes.kr)에 접속하셔서 사용하실 수 있습니다(개발자가 호스팅 중).



### 데이터베이스 항목

`guestbook` DB 구조 
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

`member` DB 구조
```sql
CREATE TABLE IF NOT EXISTS `member` (
  `idx` int(20) NOT NULL auto_increment,
  `id` varchar(30) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'login.lumes.kr 멤버들 목록',
  `exp` int(20) NOT NULL default '100',
  `role` varchar(30) NOT NULL,
  PRIMARY KEY  (`idx`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8
```
