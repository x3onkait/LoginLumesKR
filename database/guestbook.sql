-- phpMyAdmin SQL Dump
-- version 4.0.10.17
-- https://www.phpmyadmin.net
--
-- 호스트: localhost
-- 처리한 시간: 22-03-15 22:56
-- 서버 버전: 5.0.96-log
-- PHP 버전: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 데이터베이스: `luminous`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `guestbook`
--

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
