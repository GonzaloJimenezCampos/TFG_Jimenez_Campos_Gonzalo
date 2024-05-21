-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-05-2024 a las 00:42:38
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fxlol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment_body` varchar(2000) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_date`, `comment_body`, `user_id`, `post_id`) VALUES
(30, '2024-04-19 19:27:24', 'This is my post, im test1', 9, 17),
(32, '2024-04-19 19:29:29', 'Im test2, this shouldnt be here', 10, 17),
(33, '2024-04-19 19:29:47', 'Im test 2, this post is about to blow up!', 10, 18),
(34, '2024-04-19 19:30:19', 'I am about to blow up!', 9, 18),
(35, '2024-04-19 19:30:55', 'We\'ll miss you', 5, 17),
(36, '2024-04-19 19:31:14', 'I dont feel so well', 5, 18),
(43, '2024-04-20 12:46:43', 'hi', NULL, 18),
(84, '2024-05-15 15:13:18', 'a', 5, 16),
(85, '2024-05-16 10:09:53', 'hola enans', 5, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likedcomments`
--

CREATE TABLE `likedcomments` (
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `likedcomments`
--

INSERT INTO `likedcomments` (`user_id`, `comment_id`) VALUES
(5, 30),
(5, 32),
(5, 33),
(5, 34),
(5, 35),
(5, 36),
(5, 43),
(5, 85),
(9, 30),
(9, 32),
(9, 33),
(9, 34),
(9, 35),
(9, 36),
(10, 30),
(10, 32),
(10, 33),
(10, 34),
(10, 35),
(10, 36);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likedposts`
--

CREATE TABLE `likedposts` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `likedposts`
--

INSERT INTO `likedposts` (`user_id`, `post_id`) VALUES
(5, 16),
(5, 17),
(9, 16),
(9, 17),
(9, 18),
(10, 16),
(10, 17),
(10, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `message` varchar(500) NOT NULL,
  `message_read` int(11) NOT NULL,
  `message_date` datetime NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`message_id`, `message`, `message_read`, `message_date`, `sender_id`, `receiver_id`) VALUES
(86, 'asdadadad', 1, '2024-04-21 20:55:06', 5, 5),
(87, 'Your comment \"hola\" in the post \"HELLO HOW ARE YOU\" was deleted. This comment was deleted because the post which contained it was deleted', 1, '2024-04-22 18:22:43', 5, 5),
(88, 'I deleted your post \"HELLO HOW ARE YOU\"', 1, '2024-04-22 18:22:43', 5, 5),
(89, 'I deleted your post \"<<<\"', 1, '2024-04-25 13:16:47', 5, 5),
(90, 'I deleted your post \"ddsa\"', 1, '2024-05-12 23:33:34', 5, 5),
(91, 'I deleted your post \"aaaa\"', 1, '2024-05-12 23:34:52', 5, 5),
(92, 'I deleted your comment \"Nice post!\" in the post \"FIRST FUNCTIONAL POST CREATION\"', 1, '2024-05-13 17:13:06', 5, 5),
(93, 'I deleted your comment \"Im test2, this comment should ...\" in the post \"FIRST FUNCTIONAL POST CREATION\"', 0, '2024-05-13 17:13:07', 5, 10),
(94, 'I deleted your comment \"Nice post! Im test1\" in the post \"FIRST FUNCTIONAL POST CREATION\"', 1, '2024-05-13 17:13:08', 5, 9),
(95, 'I deleted your post \"aa\"', 1, '2024-05-13 19:02:08', 5, 5),
(96, 'I deleted your comment \"ddddddddddd\" in the post \"Post to test the whole delete feature\"', 1, '2024-05-13 20:12:47', 5, 5),
(97, 'I deleted your comment \"12312313\" in the post \"Post to test the whole delete feature\"', 1, '2024-05-13 20:12:48', 5, 5),
(98, 'I deleted your comment \"1231313\" in the post \"Post to test the whole delete feature\"', 1, '2024-05-13 20:12:48', 5, 5),
(99, 'I deleted your comment \"asdsadasdsad\" in the post \"Post to test the whole delete feature\"', 1, '2024-05-13 20:12:49', 5, 5),
(100, 'I deleted your comment \"aaaaa\" in the post \"Post to test the whole delete feature\"', 1, '2024-05-13 20:12:49', 5, 5),
(101, 'I deleted your comment \"aaa\" in the post \"Post to test the whole delete feature\"', 1, '2024-05-13 20:12:50', 5, 5),
(102, 'I deleted your comment \"asdadasd\" in the post \"Post to test the whole delete feature\"', 1, '2024-05-13 20:12:52', 5, 5),
(103, 'I deleted your post \"ppp\"', 1, '2024-05-15 13:48:06', 5, 5),
(104, 'I deleted your post \"aaa\"', 1, '2024-05-15 13:48:07', 5, 5),
(105, 'I deleted your post \"aa\"', 1, '2024-05-16 22:13:50', 5, 5),
(106, 'I deleted your post \"aaa\"', 1, '2024-05-16 22:13:50', 5, 5),
(107, 'I deleted your post \"aaaa\"', 1, '2024-05-17 20:22:02', 5, 5),
(108, 'I deleted your post \"aaaa\"', 1, '2024-05-17 20:22:03', 5, 5),
(109, 'I deleted your post \"aaa\"', 1, '2024-05-17 20:22:03', 5, 5),
(110, 'I deleted your post \"aaa\"', 1, '2024-05-17 20:22:18', 5, 5),
(111, 'I deleted your comment \"HOLA\" in the post \"aa\"', 0, '2024-05-22 00:31:53', 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post_date` datetime NOT NULL,
  `post_title` varchar(50) NOT NULL,
  `post_body` varchar(2000) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`post_id`, `post_date`, `post_title`, `post_body`, `user_id`) VALUES
(16, '2024-04-19 19:24:00', 'FIRST FUNCTIONAL POST CREATION', 'This is the first post that has been created with the post creation tool', 5),
(17, '2024-04-19 19:26:49', 'Post test to try the delete user only', 'This is a test to see if the user gets deleted but the post doesnt', 9),
(18, '2024-04-19 19:28:34', 'Post to test the whole delete feature', 'This is a test to see if the user, post and whole interactions get deleted', 10),
(87, '2024-05-20 20:32:29', 'aaa', 'aaa', 5),
(88, '2024-05-21 23:50:06', 'aa', 'aa', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `records`
--

CREATE TABLE `records` (
  `record_id` int(11) NOT NULL,
  `record_date` datetime NOT NULL,
  `puuid` varchar(200) NOT NULL,
  `region` varchar(10) NOT NULL,
  `score` int(11) NOT NULL,
  `gold` int(11) NOT NULL,
  `damage` int(11) NOT NULL,
  `objectives` int(11) NOT NULL,
  `vision` int(11) NOT NULL,
  `kda` int(11) NOT NULL,
  `winrate` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `records`
--

INSERT INTO `records` (`record_id`, `record_date`, `puuid`, `region`, `score`, `gold`, `damage`, `objectives`, `vision`, `kda`, `winrate`, `user_id`) VALUES
(1, '2024-05-02 12:19:45', 'QyCW2nJpKz6WoUID94R0qwW1hYKFwDlgGthN_dyk5Hb_Mc2pcPAorEqnFjpAwAW00CHpMRAG4LXnqg', 'euw1', 80, 84, 80, 59, 98, 77, 60, 5),
(2, '2024-05-02 12:42:29', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 75, 70, 41, 100, 100, 65, 60, 5),
(3, '2024-05-02 13:12:04', 'gjaMJdgXUsT8gC6Bzka9wi4xcQnITVON1M70A1UT70IU95Wos0SAHTHEaokoOsC26AiIA4SxC6QLcQ', 'euw1', 72, 78, 76, 25, 100, 82, 40, 5),
(4, '2024-05-02 13:12:26', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 62, 68, 37, 45, 88, 72, 0, 5),
(5, '2024-05-02 13:18:12', '_BO14MXOyTkTdkamTYbS0DqOWpM3TgFl3TUd0mLQJFOmkblZ7GPnWA8nK79V66SSzlqtDZQMddwVMQ', 'euw1', 57, 66, 93, 8, 33, 87, 0, 9),
(6, '2024-05-02 14:02:15', 'QyCW2nJpKz6WoUID94R0qwW1hYKFwDlgGthN_dyk5Hb_Mc2pcPAorEqnFjpAwAW00CHpMRAG4LXnqg', 'euw1', 86, 99, 93, 73, 82, 82, 100, 5),
(14, '2024-05-02 15:38:51', 'n75kKnFXvMBMw4-9BdzQo9e8RPckQN5Sd3zR29-igJ9Jz5YA_4JZ3nCXbPqIVyMln-134Di1sn1gyA', 'euw1', 79, 86, 63, 100, 69, 80, 0, 5),
(15, '2024-05-02 19:29:29', 'qs3wwTsLrJUlR8mXs3B-yiGCr-F7X6zzPlJiJavPtkHfz6cQ1TRO2vc-MKKPSq911GDIuvl9OARI5g', 'euw1', 66, 77, 72, 60, 73, 49, 0, 5),
(16, '2024-05-02 19:31:10', 'qs3wwTsLrJUlR8mXs3B-yiGCr-F7X6zzPlJiJavPtkHfz6cQ1TRO2vc-MKKPSq911GDIuvl9OARI5g', 'euw1', 63, 77, 72, 60, 59, 49, 0, 5),
(17, '2024-05-02 19:31:26', 'qs3wwTsLrJUlR8mXs3B-yiGCr-F7X6zzPlJiJavPtkHfz6cQ1TRO2vc-MKKPSq911GDIuvl9OARI5g', 'euw1', 59, 77, 72, 60, 37, 49, 0, 5),
(18, '2024-05-02 19:31:31', 'qs3wwTsLrJUlR8mXs3B-yiGCr-F7X6zzPlJiJavPtkHfz6cQ1TRO2vc-MKKPSq911GDIuvl9OARI5g', 'euw1', 59, 77, 72, 60, 37, 49, 0, 5),
(19, '2024-05-02 20:15:33', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 74, 67, 39, 100, 100, 65, 40, 21),
(20, '2024-05-02 20:29:15', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 74, 67, 39, 100, 100, 65, 40, 5),
(21, '2024-05-02 20:33:22', 'n75kKnFXvMBMw4-9BdzQo9e8RPckQN5Sd3zR29-igJ9Jz5YA_4JZ3nCXbPqIVyMln-134Di1sn1gyA', 'euw1', 77, 86, 63, 100, 55, 80, 0, 21),
(22, '2024-05-02 20:35:04', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 56, 60, 38, 30, 77, 73, 0, 5),
(23, '2024-05-02 20:35:30', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 56, 60, 38, 30, 77, 73, 0, 9),
(24, '2024-05-02 20:38:32', 'QyCW2nJpKz6WoUID94R0qwW1hYKFwDlgGthN_dyk5Hb_Mc2pcPAorEqnFjpAwAW00CHpMRAG4LXnqg', 'euw1', 80, 90, 89, 71, 73, 78, 67, 9),
(25, '2024-05-02 20:38:58', 'n75kKnFXvMBMw4-9BdzQo9e8RPckQN5Sd3zR29-igJ9Jz5YA_4JZ3nCXbPqIVyMln-134Di1sn1gyA', 'euw1', 77, 86, 63, 100, 55, 80, 0, 22),
(26, '2024-05-02 20:39:27', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 72, 64, 38, 100, 79, 79, 20, 22),
(27, '2024-05-03 17:09:37', 'p2OfrgzosmPE2f612FFBC35zlpvAU6GTJYerJfnF6gtPunCd6Zh9QxPMho74GNscUqcoug09dz3yJw', 'euw1', 39, 59, 30, 33, 18, 55, 40, 5),
(28, '2024-05-03 17:14:24', 'p2OfrgzosmPE2f612FFBC35zlpvAU6GTJYerJfnF6gtPunCd6Zh9QxPMho74GNscUqcoug09dz3yJw', 'euw1', 43, 63, 49, 23, 20, 60, 0, 5),
(29, '2024-05-03 17:17:06', 'p2OfrgzosmPE2f612FFBC35zlpvAU6GTJYerJfnF6gtPunCd6Zh9QxPMho74GNscUqcoug09dz3yJw', 'euw1', 37, 59, 30, 33, 18, 43, 40, 5),
(30, '2024-05-12 23:10:56', 'gjaMJdgXUsT8gC6Bzka9wi4xcQnITVON1M70A1UT70IU95Wos0SAHTHEaokoOsC26AiIA4SxC6QLcQ', 'euw1', 73, 75, 49, 59, 100, 84, 40, 5),
(31, '2024-05-15 10:29:26', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 78, 69, 51, 100, 87, 83, 67, 5),
(32, '2024-05-15 15:04:47', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 86, 100, 93, 73, 97, 67, 100, 5),
(33, '2024-05-15 16:06:00', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 79, 73, 45, 100, 100, 78, 100, 9),
(34, '2024-05-15 16:09:19', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 79, 73, 45, 100, 100, 78, 100, 9),
(35, '2024-05-15 16:17:58', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 77, 71, 51, 100, 84, 80, 50, 9),
(36, '2024-05-15 16:18:35', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 79, 73, 45, 100, 100, 78, 100, 10),
(37, '2024-05-15 16:18:52', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 79, 73, 45, 100, 100, 78, 100, 10),
(38, '2024-05-15 16:22:50', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 79, 73, 45, 100, 100, 78, 100, 10),
(39, '2024-05-16 10:12:24', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 72, 66, 43, 100, 80, 70, 50, 5),
(40, '2024-05-16 11:48:46', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 79, 73, 45, 100, 100, 78, 100, 5),
(41, '2024-05-16 11:49:16', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 71, 68, 37, 100, 92, 58, 36, 5),
(42, '2024-05-16 11:58:26', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 79, 73, 45, 100, 100, 78, 100, 5),
(43, '2024-05-16 11:58:43', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 72, 77, 50, 100, 75, 60, 0, 5),
(44, '2024-05-16 11:59:14', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 79, 73, 45, 100, 100, 78, 100, 5),
(45, '2024-05-16 12:24:16', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 79, 73, 45, 100, 100, 78, 100, 5),
(46, '2024-05-16 12:24:31', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 79, 73, 45, 100, 100, 78, 100, 5),
(47, '2024-05-16 12:24:37', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 79, 73, 45, 100, 100, 78, 100, 5),
(48, '2024-05-21 22:01:47', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 61, 63, 29, 75, 75, 62, 0, 5),
(49, '2024-05-22 00:31:05', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 61, 63, 29, 75, 75, 62, 0, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `savedposts`
--

CREATE TABLE `savedposts` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `savedposts`
--

INSERT INTO `savedposts` (`user_id`, `post_id`) VALUES
(5, 17),
(5, 18),
(5, 88),
(9, 16),
(9, 17),
(9, 18),
(10, 16),
(10, 17),
(10, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_name`) VALUES
(1, 'Builds'),
(2, 'Matchups'),
(3, 'Role'),
(4, 'Tips'),
(5, 'Question'),
(6, 'ProPlay'),
(7, 'Pathing'),
(8, 'Top'),
(9, 'Mid'),
(10, 'Bottom'),
(11, 'Jungle'),
(12, 'Support'),
(13, 'Skins');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tagsposts`
--

CREATE TABLE `tagsposts` (
  `tag_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tagsposts`
--

INSERT INTO `tagsposts` (`tag_id`, `post_id`) VALUES
(1, 16),
(1, 18),
(2, 18),
(2, 88),
(3, 18),
(4, 17),
(5, 88),
(6, 16),
(12, 88);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `permissions` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(500) NOT NULL,
  `profile_image` varchar(50) NOT NULL,
  `first_role` int(11) DEFAULT NULL,
  `second_role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `creation_date`, `permissions`, `username`, `password`, `profile_image`, `first_role`, `second_role`) VALUES
(5, '2024-04-19 10:19:54', 1, 'admin', '$2y$10$04DaSD/IlPOFA6mw5zvdquVE0IkToNVJpwjHk3J3Dc9HSeVee27d.', 'img/users_images/664520b58f1f7.png', NULL, NULL),
(9, '2024-04-19 19:25:26', 0, 'test1', 'test1', 'img/users_images/662a418447376.png', NULL, NULL),
(10, '2024-04-19 19:27:37', 0, 'test2', 'test2', 'img/users_images/6622aabec2dbf.png', NULL, NULL),
(21, '2024-05-02 20:15:19', 0, 'test3', 'test3', 'img/profile.png', NULL, NULL),
(22, '2024-05-02 20:38:46', 0, 'test4', 'test4', 'img/profile.png', NULL, NULL),
(23, '2024-05-15 16:23:12', 0, 'prueba', 'prueba', 'img/profile.png', NULL, NULL),
(25, '2024-05-15 17:01:19', 0, 'gon', '$2y$10$NPzPJ.6g51847K8gh0fEIOHjgDFb3Q43qLjRsnUEPLlzbVfrMYyVW', 'img/profile.png', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `FK_user_id_comments` (`user_id`),
  ADD KEY `FK_post_id_comments` (`post_id`);

--
-- Indices de la tabla `likedcomments`
--
ALTER TABLE `likedcomments`
  ADD PRIMARY KEY (`user_id`,`comment_id`),
  ADD KEY `FK_comment_id_likedcomments` (`comment_id`);

--
-- Indices de la tabla `likedposts`
--
ALTER TABLE `likedposts`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `FK_post_id_likedposts` (`post_id`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `FK_user_id_messages` (`sender_id`),
  ADD KEY `FK_user_id_messages2` (`receiver_id`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `FK_user_id_posts` (`user_id`);

--
-- Indices de la tabla `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `FK_user_id_records` (`user_id`);

--
-- Indices de la tabla `savedposts`
--
ALTER TABLE `savedposts`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `FK_post_id_savedposts` (`post_id`);

--
-- Indices de la tabla `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indices de la tabla `tagsposts`
--
ALTER TABLE `tagsposts`
  ADD PRIMARY KEY (`tag_id`,`post_id`),
  ADD KEY `FK_post_id_tagsposts` (`post_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `records`
--
ALTER TABLE `records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_post_id_comments` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
  ADD CONSTRAINT `FK_user_id_comments` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Filtros para la tabla `likedcomments`
--
ALTER TABLE `likedcomments`
  ADD CONSTRAINT `FK_comment_id_likedcomments` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`),
  ADD CONSTRAINT `FK_user_id_likedcomments` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Filtros para la tabla `likedposts`
--
ALTER TABLE `likedposts`
  ADD CONSTRAINT `FK_post_id_likedposts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
  ADD CONSTRAINT `FK_user_id_likedposts` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `FK_user_id_messages` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `FK_user_id_messages2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`);

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_user_id_posts` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Filtros para la tabla `records`
--
ALTER TABLE `records`
  ADD CONSTRAINT `FK_user_id_records` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Filtros para la tabla `savedposts`
--
ALTER TABLE `savedposts`
  ADD CONSTRAINT `FK_post_id_savedposts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
  ADD CONSTRAINT `FK_user_id_savedposts` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Filtros para la tabla `tagsposts`
--
ALTER TABLE `tagsposts`
  ADD CONSTRAINT `FK_post_id_tagsposts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
  ADD CONSTRAINT `FK_tag_id_tagsposts` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
