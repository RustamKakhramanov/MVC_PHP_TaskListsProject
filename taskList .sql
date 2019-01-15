-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 15 2019 г., 03:21
-- Версия сервера: 5.7.20
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `taskList`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `body` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `email`, `status`, `body`, `image`) VALUES
(19, 4, 'asd@mail.com', 1, ' Статья́ — это жанр журналистики, в котором автор ставит задачу проанализировать общественные ситуации, процессы, явления, прежде всего с точки зрения закономерностей, лежащих в их основе. ', '0d7d77ae62cbec3c2f70fbbf1b7afbcf_task.jpeg'),
(20, 2, 'uzer@mail.com', 1, ' Статья́ — это жанр журналистики, в котором автор ставит задачу проанализировать общественные ситуации, процессы, явления, прежде всего с точки зрения закономерностей, лежащих в их основе. ', '8d446b39ab942b76925115ee195b5d2d_task.jpeg'),
(21, 1, 'asd@mail.com', 2, 'Такому жанру как статья присуща ширина практических обобщений, глубокий анализ фактов и явлений, четкая социальная направленность.', '6e8a21041ca99c055416c99ef5216b4f_task.jpeg'),
(26, 1, 'asd@mail.com', 2, 'Кроме того, Bootstrap также включает .mx-autoкласс для горизонтального центрирования контента на уровне блоков фиксированной ширины, то есть контента', '6d77283eba7d0ce6bef1f5d82fac7cbf_task.jpeg'),
(27, 1, 'asd@mail.com', 2, 'Такому жанру как статья присуща ширина практических обобщений, глубокий анализ фактов и явлений, четкая социальная направленность.', '833cf152e81043c2adf6f0e8126b3db8_task.jpeg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '10'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$argon2i$v=19$m=1024,t=2,p=2$RXZxT09ZSUp0RTN3RUw2Mw$9g0ft5JUW8o730kXdez77HPrItB33EwmdtMh3CuBXQ8', 9),
(2, 'andy', '$argon2i$v=19$m=1024,t=2,p=2$cHJ4Q1ZrYnBXdmpFTkd1eQ$O19A9xZ52iej0fZJ4q8eSXWECBEN3SI2e24x9+BjTCc', 10),
(3, 'alexey', '$argon2i$v=19$m=1024,t=2,p=2$UllIYlkwbTF0bUZMdldXeQ$KbHilEy+Th0ewDw3VCxxkKK6rMxtR2gJUYwBD73W41Y', 1),
(4, 'alexey1', '$2y$10$7ydve8VqRe8fd8KlSnKVquNu3oC.kQoZPdtyDAnIAqhML2T.yUKaO', 10),
(5, 'dasdasdas', '$argon2i$v=19$m=1024,t=2,p=2$RXZxT09ZSUp0RTN3RUw2Mw$9g0ft5JUW8o730kXdez77HPrItB33EwmdtMh3CuBXQ8', 10);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
