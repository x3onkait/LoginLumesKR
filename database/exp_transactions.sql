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
-- 테이블 구조 `exp_transactions`
--

CREATE TABLE IF NOT EXISTS `exp_transactions` (
  `idx` int(25) NOT NULL auto_increment COMMENT '트랜젝션 순서 번호',
  `transaction_number` varchar(64) NOT NULL COMMENT '트랜젝션 고유 번호(거래 정보 hash처리)',
  `type` varchar(20) NOT NULL COMMENT '트랜젝션 종류',
  `source` varchar(255) NOT NULL COMMENT '거래 당사자 (FROM)',
  `target` varchar(255) NOT NULL COMMENT '거래 당사자 (TO)',
  `amount` double NOT NULL COMMENT '거래량',
  `date` datetime NOT NULL COMMENT '거래 시간',
  PRIMARY KEY  (`idx`)
) ENGINE=MyISAM  DEFAULT CHARSET=euckr AUTO_INCREMENT=5 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
