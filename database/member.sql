-- phpMyAdmin SQL Dump
-- version 4.0.10.17
-- https://www.phpmyadmin.net
--
-- 호스트: localhost
-- 처리한 시간: 22-03-09 16:49
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
-- 테이블 구조 `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `idx` int(20) NOT NULL auto_increment COMMENT '유저 고유 번호(가입순서 번호)',
  `id` varchar(30) NOT NULL COMMENT '유저의 ID',
  `nickname` varchar(30) NOT NULL COMMENT '유저의 닉네임(이름)',
  `password` varchar(255) NOT NULL COMMENT '유저의 비밀번호',
  `email` varchar(255) NOT NULL COMMENT '유저의 이메일 주소',
  `exp` double NOT NULL default '100' COMMENT '유저의 경험치',
  `role` varchar(30) NOT NULL COMMENT '유저의 역할',
  `last_activity_time` datetime NOT NULL COMMENT '유저의 마지막 활동 시간(게시글 업로드 시간)',
  PRIMARY KEY  (`idx`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
