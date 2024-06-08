-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-06-2024 a las 20:22:48
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
(87, '2024-06-08 18:18:45', 'I think it is definitely strong than it used to be as well! However, I dont think it is going to have as much impact as you might think.', 36, 92),
(88, '2024-06-08 19:57:21', 'No it does not, it is strictly based on your opponents mmr', 36, 98),
(89, '2024-06-08 19:58:06', 'Nice insight! Will take it into account', 36, 97),
(90, '2024-06-08 19:59:02', 'Hey im looking for one too! Good luck', 37, 100),
(91, '2024-06-08 19:59:37', 'Yeah I just noticed too. It\'s weird how little they advertise it sometimes', 37, 93),
(92, '2024-06-08 20:00:01', 'Why would you ever want to know that XD', 37, 95),
(93, '2024-06-08 20:00:54', 'There is not much to it, just play consistently and you will be out in no time. Ill check one of your games and contact you later', 38, 99),
(94, '2024-06-08 20:02:43', 'I feel you, it seems like it is the most wanted role. However as you rank up the players start diversifying into more roles', 38, 96),
(95, '2024-06-08 20:04:17', 'I dont think you are looking into it correctly. The omnivamp is not really that important as the speed effect', 38, 94),
(96, '2024-06-08 20:05:12', 'Hey nice guide! I will try it in ranked to see if it actually works', 39, 91),
(97, '2024-06-08 20:05:39', 'I need help too! Im stuck in iron xd', 39, 99),
(98, '2024-06-08 20:09:44', '???', 39, 98),
(99, '2024-06-08 20:12:28', 'I have been using it lately and it feels kind of weak. The concept is nice, it just doesnt fit into the game as it is right now imo', 40, 97),
(100, '2024-06-08 20:12:48', 'Yeah, whats up with that?', 40, 93),
(101, '2024-06-08 20:13:06', 'You dont LOL', 40, 96),
(102, '2024-06-08 20:15:20', 'I think you can have better results with press the attack, but I see your point', 41, 91),
(103, '2024-06-08 20:15:53', 'Backing from the other side of the map with nashor recall does the trick', 41, 95);

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
(38, 90),
(38, 94),
(38, 95),
(39, 88),
(39, 93),
(39, 96),
(39, 97),
(39, 98),
(40, 91),
(40, 99),
(40, 100),
(41, 102),
(41, 103);

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
(36, 97),
(37, 93),
(37, 100),
(38, 94),
(38, 96),
(38, 99),
(38, 100),
(39, 91),
(39, 95),
(39, 96),
(39, 99),
(40, 93),
(40, 97),
(40, 99),
(40, 100),
(41, 91),
(41, 99);

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
(113, 'I deleted your post \"Diana jungle guide in patch 14.12\"', 0, '2024-06-08 18:09:00', 35, 35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post_date` datetime NOT NULL,
  `post_title` varchar(50) NOT NULL,
  `post_body` mediumtext NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`post_id`, `post_date`, `post_title`, `post_body`, `user_id`) VALUES
(89, '2024-06-08 17:23:19', 'First post of the web', 'Hello guys! This post is to celebrate the creation of the web and to conmemorate the ability to make posts. Comment here if you are as excited to create content and use the forum as I am!', 35),
(91, '2024-06-08 18:10:25', 'Diana jungle guide', 'Abilities\nPassive - Moonsilver Blade:\n\nDiana gains bonus attack speed after using an ability, and every third strike deals additional magic damage in an area.\nQ - Crescent Strike:\n\nDiana throws an arc-shaped projectile that deals magic damage to all enemies it passes through and explodes at the end of its path.\nW - Pale Cascade:\n\nDiana creates three orbiting spheres that explode on contact with enemies, dealing magic damage. She also gains a temporary shield.\nE - Lunar Rush:\n\nDiana dashes to an enemy, dealing magic damage. If the target is marked by her Q, the cooldown is reset.\nR - Moonfall:\n\nDiana pulls in and slows nearby enemies, then deals additional magic damage in an area around her if any enemies are marked by her Q.\nAbility Leveling Order\nLevel 1: Q - Crescent Strike\nLevel 2: W - Pale Cascade\nLevel 3: E - Lunar Rush\nMax first: Q - Crescent Strike\nMax second: W - Pale Cascade\nMax third: E - Lunar Rush\nR - Moonfall at levels 6, 11, and 16.\nStarting Items\nHailblade or Emberknife and Refillable Potion\nCore Items\nNashor\'s Tooth\nHextech Rocketbelt or Night Harvester (depending on whether you need more burst or mobility)\nZhonya\'s Hourglass\nSituational Items\nRabadon\'s Deathcap (for additional damage)\nBanshee\'s Veil (for survivability)\nMorellonomicon (to reduce enemy healing)\nRylai\'s Crystal Scepter (for slowing enemies)\nRunes\nPrecision\nConqueror\nTriumph\nLegend: Tenacity\nCoup de Grace\nDomination\nSudden Impact\nRavenous Hunter\nFragments\nAttack Speed\nAdaptive Force\nArmor or Magic Resist (depending on the enemy team composition)\nJungle Path\nStart: Red Buff\nNext: Wolves\nThen: Blue Buff\nThen: Gromp\nRift Scuttler\nKrugs\nAfter that, gank if there are opportunities or continue farming.\nTips\nClear camps quickly: Use your Q and W to efficiently clear camps.\nEarly gank: Diana has good gank potential at level 3 thanks to her E.\nMap vision: Place wards in the enemy jungle to anticipate their movements.\nObjectives: Utilize your burst potential to secure dragons and Rift Heralds.\nTeam Fight Strategy\nInitiate with your Q to mark enemies.\nDive onto enemies with your R to trigger the Q mark explosion.\nUse your W to protect yourself and deal continuous damage.\nE to pull and slow enemies, making it easier to land another Q.\nIn large fights, try to engage when the enemy team is scattered or has used key abilities.\nThis guide provides a solid foundation for playing Diana in the jungle. Adapt your strategy according to the game and practice to improve your performance. Good luck on Summoner\'s Rift!', 35),
(92, '2024-06-08 18:16:18', 'Is new Black Cleaver a must have on bruisers', 'I have noticed how they have been buffing BC for a few patches in a row and I\'m now wondering if it is becoming a must have item or even a first buy. Has anyone had the chance to try it out?', 35),
(93, '2024-06-08 19:29:08', 'Looks like LEC summer split starts today.', 'Came as a total surprise to me that summer split is starting! Haven\'t seen any tweets or threads about it yet.', 36),
(94, '2024-06-08 19:30:24', 'Riftmaker needs an adjustment', 'Something needs to be done to make Riftmaker more viable.\n\nThe item having its passive: Void Corruption have a full 5 second time out can sometimes make the effect not even seen in a fight.\n\nI think making the omnivamp readily available would be a big help to the item instead of it being backloaded, but the damage amp could be back loaded to still keep the theme of the item.\n\nThe item hp to ap passive is perfectly fine and fits ap juggernauts.\n\nImo if the company did this it would allow some more viable builds for ap bruisers that could shake up the rift.\n\nMaybe lower the omnivamp if it’s front loaded from 8% to 5 or 6% since it’s readily available.\n\nJust some suggestions for the item.', 37),
(95, '2024-06-08 19:33:09', 'What would be the absolute farthest distance that', 'I imagine something like Q3 flash ult into thresh lantern into Ryze ult then chaining an enemy blitz hook, Ali headbutt into skarner ult or something but I’m curious if anyone could theory craft something longer.', 38),
(96, '2024-06-08 19:34:59', 'How do you even main mid?', 'It feels like I get autofilled more than 50% of the games I pick mid as my first role. And if you do fill secondary role it\'s AAAALWAYS jungle or bot, I like those roles but like how and why is that a thing.\n\nI never understood the \"whining\" about autofill until I started to try out mid more.', 39),
(97, '2024-06-08 19:35:58', 'Cash Back\'s biggest flaw', 'With Future Market, you could ping items in the shop and the game would inform you of how much gold you needed. This calculation took FM in account, accurately telling you how much gold you needed while having that Rune. Which in turn, allowed you to make your early purchases with this rune.\n\nCash Back doesn\'t have this. It technically does \'accelerate\' your later purchases, but you rarely ever go \" Oh my god, I\'m so happy I had cash back. I could totally feel that 166 gold it gave me 5 minutes ago\". Cash Back provides you gold at one of the worst possible times: After making a purchase. Gold feel less valuable after you make a big purchase, because you already made a big purchase. That\'s kinda the thing you do with gold, you know?\n\nAnd if you spend that Cash Back gold on Pinks, you actually deny the \'acceleration\' idea towards your next big purchase. Which at that point, Cash Back would just be \"You get a few Pink Wards after the occasional purchase\".\n\nWhich I wonder how people would feel, if there was a Rune that straight up just grants you a Pink Ward after purchasing a Legendary item. For some players, that\'s largely what Cash Back ultimately does lol.', 40),
(98, '2024-06-08 19:42:06', 'Does surrendering make you lose you more LP', 'Serious question, I\'ve been wondering this for a good bit. Does it really affect the loss of LP or is only your MMR determining the amount you lose?\n\nI thought that not surrendering would prove that you have a better mentality, meaning you\'d rather keep going and try to fight back rather than throw the game. But does that actually make a difference? I have actually noticed that I would sometimes lose some more LP than usual when I pressed yes and successfully surrendered during a bad game. On the other hand I am thinking that letting them destroy the nexus instead of surrendering before it happens means you were unsuccessful in preventing the enemy team from entering your base and ending the game, making you a worse player. So is it true or not?', 41),
(99, '2024-06-08 19:45:25', 'Tips on getting out of bronze/silver', 'Tips on getting out of low elo\n\nHello everyone, I’ve seen a lot of videos and threads of people saying that getting out of bronze/silver is really easy, and some people do it on autopilot. As someone who has been top rank in every game I’ve played, I can’t wrap my mind around League. I think I have a good understanding of the fundamentals that should get me to at least gold, but I can’t seem to rank up since it feels like my team doesn’t even want to play. Anyways, I would appreciate it if someone could download one of my games and see if I could do some things better such as rotations/wave management.', 42),
(100, '2024-06-08 19:46:40', 'Any LCS summer split watch parties?', 'Hello! So I’m wondering if there are LCS watch parties happening for the summer split in the Bay Area (SJ, SF, etc.) or even Sacramento? I know last year there were a few being held at the guild house in San Jose, but looks like the only one being held this year is for Worlds in November. I wouldn’t be surprised if there isn’t anything for the regular season, but if there is anything going on for playoffs or the championships, I would love to know so I could possibly attend!', 36);

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
(54, '2024-06-08 14:04:07', 'SOlPe8-9-otkzB4vqp-3-xpAb7hoRgakW-DgDhuPsU0IAjsqX5Bm-pJYzpJljLJoKriDRCB_5_kICw', 'euw1', 80, 81, 66, 100, 87, 66, 80, 35);

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
(36, 97),
(38, 94),
(38, 99),
(39, 91),
(40, 97),
(41, 95);

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
(1, 91),
(1, 92),
(1, 94),
(3, 96),
(4, 99),
(5, 92),
(5, 95),
(5, 96),
(5, 98),
(6, 100),
(7, 91),
(9, 96),
(11, 91);

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
(35, '2024-06-08 14:01:56', 0, 'Electracegod', '$2y$10$yHiXVW9AtiPS09kHMGrzNOwAYgGC1gk0OHzwK8LCm9NPhqHEM5uuu', 'img/users_images/6664a02b59fdc.png', NULL, NULL),
(36, '2024-06-08 18:17:24', 0, 'JoanGamer', '$2y$10$wCT/FrbU3sTdLwvw9ZrJh.up8rpgLQrJxcNhTZjHTNdtuxTYW12dy', 'img/users_images/6664a0bf9565a.png', NULL, NULL),
(37, '2024-06-08 19:29:38', 0, 'EggyChickenEgg88', '$2y$10$J5ghqp0PKJHRZhRD5muaGeZt/paKTP7EP3OGdRJgg0fANseNrYDQ.', 'img/users_images/6664a0e1637cd.png', NULL, NULL),
(38, '2024-06-08 19:31:56', 0, 'GoldDong', '$2y$10$VcYMxsXBEh799tM/r84E6uxY8qB7sUGAMZFlLJ2uj5xec87twn7g2', 'img/users_images/6664a0fc33a6b.png', NULL, NULL),
(39, '2024-06-08 19:34:17', 0, 'dus_istrue', '$2y$10$aLAqL7zwaWnvkckNmKKc8eJwKfRMeJy28Me08UgN46vb/0pSqBA8G', 'img/profile.png', NULL, NULL),
(40, '2024-06-08 19:35:35', 0, 'Temporary-Platypus80', '$2y$10$UfLSCFyGCpA2JY4eQFbHhel8Z0XYnobAhxCmIr49GXGa2lPDYenOu', 'img/profile.png', NULL, NULL),
(41, '2024-06-08 19:41:47', 0, 'veryfishycatfood', '$2y$10$yK9RsUHAA6/utStJuxMxIuU/lVJpYk0XrqSRljzcrxF3eE.PN0Fb.', 'img/users_images/6664a00914055.png', NULL, NULL),
(42, '2024-06-08 19:44:23', 0, 'Financial-Editor', '$2y$10$iwkPM/0ID790sutjt8ky4OUz3N824EEVlhH9RXYjyRbL14VoHdiKK', 'img/profile.png', NULL, NULL);

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
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `records`
--
ALTER TABLE `records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
