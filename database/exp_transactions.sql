-- phpMyAdmin SQL Dump
-- version 4.0.10.17
-- https://www.phpmyadmin.net
--
-- 호스트: localhost
-- 처리한 시간: 22-03-10 18:52
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
) ENGINE=MyISAM  DEFAULT CHARSET=euckr AUTO_INCREMENT=18 ;

--
-- 테이블의 덤프 데이터 `exp_transactions`
--

INSERT INTO `exp_transactions` (`idx`, `transaction_number`, `type`, `source`, `target`, `amount`, `date`) VALUES
                                (1, 'b6e5d70e5ceb734e94a9dfba55219f79526d2fa74a90fca9976e2013f5cac487', 'TRANSFER', 'lumes', 'sake', 1024, '2022-03-09 01:55:22'),
                                (2, '0bac372a510be140fcd70c92bbd3f1666a16f4c4fb07a188d20fb90eaac0e668', 'TRANSFER', 'lumes', 'fudehzmffjq', 114, '2022-03-09 01:55:39'),
                                (3, '9fccb375d225109c4d7c0497ecde7614a6fefe297b3c22d90cfd78e308577ebb', 'TRANSFER', 'lumes', 'fnalsjtm', 808, '2022-03-09 01:55:48'),
                                (4, '5ead40f97aea70e30c8a70af9111b18d29cb2ccc199d01bc899c57118bbd87bf', 'TRANSFER', 'lumes', 'acane', 1111, '2022-03-09 01:56:02'),
                                (5, 'a7aaa2b046c3ad535c2d6d7764458982b302d9325f51d09da316cd3b2bf3d242', 'TRANSFER', 'sayofrenchfries', 'fnalsjtm', 1230, '2022-03-09 20:22:48'),
                                (6, 'ebb256ea2bbd540af46c1b9e65a89d1fcaf9467b5ce736c20c5a4bc96d055283', 'TRANSFER', 'sayofrenchfries', 'yyor', 1199, '2022-03-09 20:22:54'),
                                (7, '26f6e392037c06ab195b514c5bc323eb9a3ad6c96880a87c0c650150b00db6dd', 'TRANSFER', 'lumes', 'sayofrenchfries', 108444, '2022-03-09 20:23:07'),
                                (8, '065b227104924f5424ae3b6273558a1b5d5bb2222d5d3bb64f3f20c9141ee5cb', 'TRANSFER', 'sayofrenchfries', 'lumes', 103777, '2022-03-09 20:23:21'),
                                (9, '9d7662987cae32dc464e62c65973160444e5e864e39db10ca04be3d0dcc30eb5', 'TRANSFER', 'fnalsjtm', 'lumes', 100, '2022-03-10 13:23:54'),
                                (10, 'caf9e56655f3f82f28fa4b3af174b8d1cbf2d9e0b121b042e9a1c35bef5d3b6a', 'TRANSFER', 'lumes', 'fnalsjtm', 123, '2022-03-10 13:24:24'),
                                (11, '4b1c1180c16c09e406ccbc34d224633b25680317a0e1078afee07d835cf7300e', 'TRANSFER', 'sake', 'f', 0, '2022-03-10 13:24:26'),
                                (12, 'e56883168ba286254949ab54e7f478297ebefa7a1e7030df454b95da65fdae93', 'TRANSFER', 'sake', 'f', 0, '2022-03-10 13:25:54'),
                                (13, 'ca4de8f2fcd8e64da670ac9dcf0938110362fe130043dd29dfee23ee7d743757', 'TRANSFER', 'sake', 'f', 0, '2022-03-10 13:28:26'),
                                (14, '580764c2a701108092573e7c4755e76f6bb06c38eaadfa23644a19b0b44eb96f', 'TRANSFER', 'lumes', 'sake', 12, '2022-03-10 18:18:32'),
                                (15, '6fe706bd95cb437e6d65e2de77b8a1a032a2eff40fa1545014663614f4cfa123', 'TRANSFER', 'lumes', 'sayofrenchfries', 188, '2022-03-10 18:51:24'),
                                (16, '86f70a2ce82422d67106283bf7cffeb19698fd08fcaaed4d0f960f44bea73420', 'TRANSFER', 'lumes', 'sake', 8, '2022-03-10 18:51:39'),
                                (17, 'af48439e5a932450f863c10750a2f27c7dad0452858bf72cb1f6704bf94ce61e', 'TRANSFER', 'lumes', 'sake', 12, '2022-03-10 18:51:44');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
