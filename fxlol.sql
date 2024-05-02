-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-05-2024 a las 20:24:40
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
(29, '2024-04-19 19:27:09', 'Nice post! Im test1', 9, 16),
(30, '2024-04-19 19:27:24', 'This is my post, im test1', 9, 17),
(31, '2024-04-19 19:29:09', 'Im test2, this comment should be deleted when im gone', 10, 16),
(32, '2024-04-19 19:29:29', 'Im test2, this shouldnt be here', 10, 17),
(33, '2024-04-19 19:29:47', 'Im test 2, this post is about to blow up!', 10, 18),
(34, '2024-04-19 19:30:19', 'I am about to blow up!', 9, 18),
(35, '2024-04-19 19:30:55', 'We\'ll miss you', 5, 17),
(36, '2024-04-19 19:31:14', 'I dont feel so well', 5, 18),
(43, '2024-04-20 12:46:43', 'hi', NULL, 18),
(73, '2024-04-21 22:15:44', 'Nice post!', 5, 16);

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
(5, 29),
(5, 30),
(5, 32),
(5, 33),
(5, 34),
(5, 35),
(5, 36),
(5, 43),
(9, 29),
(9, 30),
(9, 31),
(9, 32),
(9, 33),
(9, 34),
(9, 35),
(9, 36),
(10, 29),
(10, 30),
(10, 31),
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
(5, 18),
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
(87, 'Your comment \"hola\" in the post \"HELLO HOW ARE YOU\" was deleted. This comment was deleted because the post which contained it was deleted', 0, '2024-04-22 18:22:43', 5, 5),
(88, 'I deleted your post \"HELLO HOW ARE YOU\"', 1, '2024-04-22 18:22:43', 5, 5),
(89, 'I deleted your post \"<<<\"', 1, '2024-04-25 13:16:47', 5, 5);

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
(18, '2024-04-19 19:28:34', 'Post to test the whole delete feature', 'This is a test to see if the user, post and whole interactions get deleted', 10);

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
(19, '2024-05-02 20:15:33', 'bukjieuzqQ9WSG-pWPVG_DDZykdAsTSvFm--_QQ0-ISfQcal649Gg-nBupQHcxG8UL0bjfbm2rYg7g', 'euw1', 74, 67, 39, 100, 100, 65, 40, 21);

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
(5, 16),
(5, 18),
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
(3, 18),
(4, 17),
(6, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `permissions` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `profile_image` varchar(50) NOT NULL,
  `first_role` int(11) DEFAULT NULL,
  `second_role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `creation_date`, `permissions`, `username`, `password`, `profile_image`, `first_role`, `second_role`) VALUES
(5, '2024-04-19 10:19:54', 1, 'admin', 'admin', 'img/users_images/6622603c3df97.png', NULL, NULL),
(9, '2024-04-19 19:25:26', 0, 'test1', 'test1', 'img/users_images/662a418447376.png', NULL, NULL),
(10, '2024-04-19 19:27:37', 0, 'test2', 'test2', 'img/users_images/6622aabec2dbf.png', NULL, NULL),
(21, '2024-05-02 20:15:19', 0, 'test3', 'test3', 'img/profile.png', NULL, NULL);

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
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `records`
--
ALTER TABLE `records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
