-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 26, 2025 at 03:17 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kkard2`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `posterId` int(11) NOT NULL,
  `hide` tinyint(1) NOT NULL,
  `postedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `slug`, `content`, `posterId`, `hide`, `postedAt`) VALUES
(3, '/u/kkard2/', 'comment', 1, 0, '2025-01-25 10:37:21'),
(4, '/u/kkard2/', 'newer comment', 1, 0, '2025-01-25 10:44:29'),
(5, '/u/kkard2/', 'asdf  comment\r\n\r\nline break', 1, 0, '2025-01-25 10:46:30'),
(6, '/u/kkard2/', 'a', 1, 0, '2025-01-25 11:02:33'),
(7, '/u/kkard2/', 'my honest reactino\r\n\r\n```\r\nfoo = bar\r\n```\r\n\r\n<code>xss</code>', 1, 0, '2025-01-25 11:21:17'),
(8, '/u/kkard2/', 'my honest reactino\r\n\r\n```\r\nfoo = bar\r\n```\r\n\r\n<code>xss</code>', 1, 0, '2025-01-25 11:22:19'),
(9, '/u/kkard2/', 'Lorem ipsum odor amet, consectetuer adipiscing elit. Convallis convallis turpis tincidunt euismod ultricies, lobortis enim cursus odio. Justo in neque dolor per volutpat potenti tincidunt potenti. Penatibus nostra blandit pulvinar dapibus consequat nec nunc. Praesent aenean potenti potenti ridiculus sodales dolor non parturient. Tristique duis sed felis massa nulla urna. Sagittis natoque laoreet velit eleifend parturient?\r\n\r\nPurus ipsum molestie suspendisse duis ridiculus aliquam quis. Morbi viverra eu lobortis varius suspendisse vestibulum tincidunt vulputate. Facilisi consectetur praesent tempor primis volutpat. Convallis mus aliquam orci euismod ac mi vestibulum diam potenti. Ullamcorper a class porttitor rhoncus rhoncus volutpat auctor nibh. Fusce maecenas id; sapien ligula quis est. Vel dictumst hac quis morbi phasellus auctor diam.\r\n\r\nFermentum posuere conubia tempor aliquet ridiculus. Nunc tortor morbi integer hac quam arcu maecenas. Sem per dapibus proin varius nec mus. Bibendu', 1, 0, '2025-01-25 11:27:16'),
(10, '/u/kkard2/', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 1, 1, '2025-01-25 11:27:57'),
(11, '/u/kkard2/', 'a\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\na', 1, 0, '2025-01-25 11:31:23'),
(12, '/u/kkard2/', '.\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n\r\n\r\n..\r\n\r\n\r\n.\r\n', 1, 1, '2025-01-25 11:33:59'),
(13, '/u/kkard2/', 'comment', 1, 0, '2025-01-25 11:42:23'),
(14, '/u/kkard2/', '/u/kkard2 is definitely a user', 3, 0, '2025-01-25 11:48:27'),
(15, '/u/kkard2/', 'responding to /c/14; i agree, /u/kkard2 is a user', 1, 0, '2025-01-25 13:04:52'),
(16, '/', 'i use vim btw', 1, 0, '2025-01-25 14:11:50'),
(17, '/software/2025/01/25/my-honest-reactore.html', 'activity', 1, 1, '2025-01-25 18:01:49'),
(18, '/blog/', 'see you in 6 months', 1, 0, '2025-01-25 18:14:54');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(128) NOT NULL,
  `userId` int(11) NOT NULL,
  `validUntil` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `parentId` int(11) DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL,
  `hide` tinyint(1) NOT NULL,
  `parentKey` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `passwordHash`, `parentId`, `bio`, `admin`, `hide`, `parentKey`) VALUES
(1, 'kkard2', '$2y$10$XU7VCY2VaUPL6najwMWP7Of5FCr2fHLPATQnHkNOMvGMTBMUN.xo6', NULL, 'test\r\nnew line\r\n\r\nmultiple new line\r\n\r\n\r\nnow wroks <br>', 1, 0, '9f1353993383e0d2124b52a736e6e4ff878f7d4092cefb7fe0905de683b8b633'),
(3, 'test1', '$2y$10$2llMA0yV6bs7Pfzj0Q6mlOD9iSQDCHBlhYV/NFbNfCAaiHhE6wete', 1, 'test bio?\r\n\r\ntest', 0, 0, 'c9c6b53de8defdaed5d65de2e1311cde933128a76ab6740a2ddec4e2de302e4b'),
(5, 'test2', '$2y$10$c1CDC7JZokOtZxKLpy2dM.AlIcwMRJjcpqFBn7RVDezzmLpGSM0jG', 3, NULL, 0, 0, NULL),
(6, 'test3', '$2y$10$RkkUytMl0C3aF5bsqak90uFY4SjG2DonKzWyMaq3uDbMp/cLgkckW', 1, NULL, 0, 1, NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posterId` (`posterId`);

--
-- Indeksy dla tabeli `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `parentId` (`parentId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`posterId`) REFERENCES `users` (`id`);

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`parentId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
