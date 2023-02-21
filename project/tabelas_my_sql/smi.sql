-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04-Jul-2021 às 23:07
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `smi`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_role`
--

CREATE TABLE `auth_role` (
  `id` int(11) NOT NULL,
  `name_role` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `auth_role`
--

INSERT INTO `auth_role` (`id`, `name_role`) VALUES
(4, 'Administrator'),
(1, 'Guest'),
(3, 'Sympathizer'),
(2, 'User');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comment`
--

CREATE TABLE `comment` (
  `text` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `date_comment` date DEFAULT NULL,
  `class` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `comment`
--

INSERT INTO `comment` (`text`, `user_id`, `restaurant_id`, `date_comment`, `class`) VALUES
('muito bom!', 1, 6, '2021-07-04', 3),
('bom restaurante, recomendo.', 1, 8, '2021-07-04', 3),
('xdd', 1, 11, '2021-07-04', 4),
('ola', 2, 8, '2021-06-30', 2),
('miid', 2, 9, '2021-06-30', 4),
('SHIIIIIES', 3, 9, '2021-07-26', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` float(10,6) NOT NULL,
  `longitude` float(10,6) NOT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `location`
--

INSERT INTO `location` (`id`, `address`, `latitude`, `longitude`, `city`) VALUES
(1, 'Rua das Antas', 10.000000, 10.000000, 'Loures');

-- --------------------------------------------------------

--
-- Estrutura da tabela `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descrip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `menu`
--

INSERT INTO `menu` (`id`, `restaurant_id`, `name`, `price`, `descrip`) VALUES
(80, 5, 'burguer p', '1', 'miid'),
(81, 5, 'burguer m', '5', 'miid 2'),
(84, 6, 'frango', '10', 'bom'),
(86, 7, 'batata p', '2', 'bom'),
(87, 7, 'batata grande', '3', 'drena'),
(88, 7, 'sprite', '5', 'shit'),
(89, 8, 'pizza p', '10', 'oregaos, queijo'),
(90, 8, 'pizza m', '20', 'tomate, ananas'),
(123, 9, '1', '1', 'bom'),
(124, 10, 'cerveja', '5', 'bue da boa'),
(125, 10, 'absitno', '10', 'oh isto faz mal ao estomago'),
(126, 10, 'vinho', '1', 'meh'),
(127, 10, 'wiskey', '15', 'mel, mostarda, azeite'),
(128, 11, 'sardinha', '1', 'fresquinho'),
(129, 11, 'carapaus', '2', 'bom');

-- --------------------------------------------------------

--
-- Estrutura da tabela `restaurant`
--

CREATE TABLE `restaurant` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `location_id` int(11) NOT NULL,
  `public` tinyint(1) DEFAULT NULL,
  `opening_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `closing_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `restaurant`
--

INSERT INTO `restaurant` (`id`, `name`, `email`, `telephone`, `photo`, `location_id`, `public`, `opening_time`, `closing_time`, `description`) VALUES
(5, 'fifities', 'fif@email.com', '219999999', 'dudu/back3.jpg', 1, 0, '09:30', '20:30', 'Prazer e Diversão sem limites. Venha conhecer o nosso espaço e delicie-se... na nossa Companhia! 1'),
(6, 'duduChurrasco', 'churracos@email.com', '219999999', 'dudu/back3.jpg', 1, 1, '09:00', '10:00', 'Prazer e Diversão sem limites. Venha conhecer o nosso espaço e delicie-se... na nossa Companhia! 2'),
(7, 'cac', 'mac@email.com', '210000000', 'dudu/back3.jpg', 1, 1, '10:30', '23:00', 'Prazer e Diversão sem limites. Venha conhecer o nosso espaço e delicie-se... na nossa Companhia! 3'),
(8, 'PizzaPlace', 'pizza@email.com', '210000000', 'dudu/back6.jpg', 1, 1, '09:30', '23:30', 'Prazer e Diversão sem limites. Venha conhecer o nosso espaço e delicie-se... na nossa Companhia! 4'),
(9, 'Pedro Ferreira', 'pedrorodrigo1998@gmail.com', '967388648', 'dudu/back1.jpg', 1, 1, '11:01', '11:11', 'des                      '),
(10, 'amaral', 'email@email.com', '967388648', 'Chucky/back5.jpg', 1, 0, '09:30', '23:00', 'gnd merda nao venham'),
(11, 'peixeFresco', 'peixe@email.com', '210000000', 'Nuno/back4.jpg', 1, 1, '11:30', '23:00', 'peixe muito fresquinho');

-- --------------------------------------------------------

--
-- Estrutura da tabela `restaurant_location`
--

CREATE TABLE `restaurant_location` (
  `idRestaurant` int(11) NOT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` float(10,6) NOT NULL,
  `longitude` float(10,6) NOT NULL,
  `City` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `restaurant_location`
--

INSERT INTO `restaurant_location` (`idRestaurant`, `address`, `latitude`, `longitude`, `City`, `post_code`) VALUES
(5, 'R. Catarina Eufémia G98 ', 38.838917, -9.101075, 'Santa Iria de Azoia', '2690'),
(6, 'R. da Carochia 113', 38.809036, -9.190130, 'Ramada', '2620-206'),
(7, 'Praça António Nobre 6', 38.816048, -9.163443, 'Santo António dos Cavaleiros', '2660'),
(8, 'R. Prof. Luís de Albuquerque 12', 38.830101, -9.171956, 'Loures', '2670-447'),
(9, 'Rua madorna', 0.000000, 0.000000, 'Madorna', '238778'),
(10, 'R. José Marques Raso 1', 38.830681, -9.176016, 'Loures', '2670-413'),
(11, 'R. Rómulo de Carvalho 30', 38.820747, -9.165654, 'Santo António dos Cavaleiros', '2660');

-- --------------------------------------------------------

--
-- Estrutura da tabela `restaurant_pictures`
--

CREATE TABLE `restaurant_pictures` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `path_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `restaurant_pictures`
--

INSERT INTO `restaurant_pictures` (`id`, `restaurant_id`, `path_image`) VALUES
(69, 9, 'dudu/back1.jpg'),
(70, 9, 'dudu/back2.jpg'),
(71, 9, 'dudu/back3.jpg'),
(72, 9, 'dudu/back1.jpg'),
(73, 9, 'dudu/back2.jpg'),
(74, 9, 'dudu/back5.jpg'),
(75, 10, 'Chucky/back1.jpg'),
(76, 10, 'Chucky/back2.jpg'),
(77, 10, 'Chucky/back3.jpg'),
(78, 11, 'Nuno/back2.jpg'),
(79, 11, 'Nuno/back5.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `restaurant_type`
--

CREATE TABLE `restaurant_type` (
  `type_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `restaurant_type`
--

INSERT INTO `restaurant_type` (`type_id`, `restaurant_id`) VALUES
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(2, 11),
(3, 8),
(4, 8),
(5, 5),
(5, 6),
(5, 7),
(5, 9),
(7, 8),
(7, 10),
(7, 11),
(8, 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `topico`
--

CREATE TABLE `topico` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `name_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `type`
--

INSERT INTO `type` (`id`, `name_type`) VALUES
(5, 'BBQ'),
(7, 'Bebida'),
(1, 'Carne'),
(4, 'Massa'),
(2, 'Peixe'),
(3, 'Pizza'),
(8, 'Sushi'),
(11, 'Vegan');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_favorite_restaurant`
--

CREATE TABLE `user_favorite_restaurant` (
  `restaurant_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `user_favorite_restaurant`
--

INSERT INTO `user_favorite_restaurant` (`restaurant_id`, `user_id`) VALUES
(6, 1),
(7, 1),
(9, 1),
(10, 1),
(11, 1),
(9, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_table`
--

CREATE TABLE `user_table` (
  `userId` int(11) NOT NULL,
  `auth_role_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_hash` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `isBanned` tinyint(1) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `user_table`
--

INSERT INTO `user_table` (`userId`, `auth_role_id`, `name`, `nationality`, `birthdate`, `gender`, `email`, `user_hash`, `password`, `isBanned`, `isActive`) VALUES
(1, 4, 'Chucky', 'Portugal', '2021-06-13', 1, 'pedrorodrigo1998@gmail.com', 'b05aef36dfef34e845fa2648ade30c1b', 'Ppppppppppp', 0, 1),
(2, 4, 'dudu', 'Brasil', '1999-10-21', 1, 'pedroferreiranunzcrypto@gmail.com', '00f8d4370e6a604dd008344d96a79703', 'Pppppppp', 0, 1),
(3, 3, 'Nuno', 'Belarus', '1970-01-01 ', 1, 'chuckynuno1998@gmail.com', '4bdecc2706fb33e53da7e32b7c43c792', 'P12345678', 1, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `auth_role`
--
ALTER TABLE `auth_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_role` (`name_role`);

--
-- Índices para tabela `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`user_id`,`restaurant_id`),
  ADD UNIQUE KEY `text` (`text`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Índices para tabela `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `address` (`address`);

--
-- Índices para tabela `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Índices para tabela `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `location_id` (`location_id`);

--
-- Índices para tabela `restaurant_location`
--
ALTER TABLE `restaurant_location`
  ADD PRIMARY KEY (`idRestaurant`),
  ADD UNIQUE KEY `address` (`address`);

--
-- Índices para tabela `restaurant_pictures`
--
ALTER TABLE `restaurant_pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Índices para tabela `restaurant_type`
--
ALTER TABLE `restaurant_type`
  ADD PRIMARY KEY (`type_id`,`restaurant_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Índices para tabela `topico`
--
ALTER TABLE `topico`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_type` (`name_type`);

--
-- Índices para tabela `user_favorite_restaurant`
--
ALTER TABLE `user_favorite_restaurant`
  ADD PRIMARY KEY (`user_id`,`restaurant_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Índices para tabela `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `auth_role_id` (`auth_role_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `auth_role`
--
ALTER TABLE `auth_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT de tabela `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `restaurant_pictures`
--
ALTER TABLE `restaurant_pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de tabela `topico`
--
ALTER TABLE `topico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `user_table`
--
ALTER TABLE `user_table`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`userId`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `restaurant`
--
ALTER TABLE `restaurant`
  ADD CONSTRAINT `restaurant_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `restaurant_location`
--
ALTER TABLE `restaurant_location`
  ADD CONSTRAINT `restaurant_location_ibfk_1` FOREIGN KEY (`idRestaurant`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `restaurant_pictures`
--
ALTER TABLE `restaurant_pictures`
  ADD CONSTRAINT `restaurant_pictures_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `restaurant_type`
--
ALTER TABLE `restaurant_type`
  ADD CONSTRAINT `restaurant_type_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `restaurant_type_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `user_favorite_restaurant`
--
ALTER TABLE `user_favorite_restaurant`
  ADD CONSTRAINT `user_favorite_restaurant_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_favorite_restaurant_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`userId`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `user_table`
--
ALTER TABLE `user_table`
  ADD CONSTRAINT `user_table_ibfk_1` FOREIGN KEY (`auth_role_id`) REFERENCES `auth_role` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
