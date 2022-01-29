-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29-Jan-2022 às 15:42
-- Versão do servidor: 10.4.21-MariaDB
-- versão do PHP: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `app_mvc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `testimonies`
--

CREATE TABLE `testimonies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `testimonies`
--

INSERT INTO `testimonies` (`id`, `name`, `message`, `date`) VALUES
(1, 'Luigi', 'dcdcdc', '2022-01-18 20:24:14'),
(2, 'Anônimo', 'Luigi trabalha na Made', '2022-01-19 16:26:07'),
(3, 'Me', 'TESTE TESTE TESTE TESTE', '2022-01-19 16:53:36'),
(4, 'Eu', 'Olá Mundo', '2022-01-19 16:53:56'),
(5, 'DEVLR', 'DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR ', '2022-01-19 16:54:19'),
(8, 'DEVLR', 'DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR \r\n', '2022-01-19 16:54:43'),
(9, 'DEVLR', 'DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR DEVLR \r\n', '2022-01-19 16:54:43'),
(10, 'WDEV', 'O novo WDEV está me ensinando MVC em PHP', '2022-01-26 10:38:14'),
(12, 'Cadastrando depoimento', 'Meu novo depoimento cadastrado pelo painel administrativo', '2022-01-26 14:49:31'),
(13, 'Pessoa que veio do React', 'Olá API', '2022-01-29 16:02:04'),
(14, 'Pessoa que veio do React', 'Olá API', '2022-01-29 16:04:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Luigi Raynel', 'luigiraynel21@gmail.com', '$2y$10$e6fQOyKt9KQsY7kKXA1BuOXiwjHsiR4a7NTRXN1WImBxryHmbot4S'),
(2, 'Luigi Marcolino', 'lumarcolino_ext@tozzinifreire.com.br', '$2y$10$BaR6Fz.g0tzFJMJ3arKWgO5eKQ2/9h.OdDMTYpAdQIIsGPA2EDQCC'),
(3, 'DEVLR', 'devluigiraynel@gmail.com', '$2y$10$yTdArVqdJP2Gymv0zGeRIuUzu/2jVdaR2SWrOrzpWKrST7j4XPRKO');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `testimonies`
--
ALTER TABLE `testimonies`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `testimonies`
--
ALTER TABLE `testimonies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
