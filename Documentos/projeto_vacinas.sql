-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 03-Set-2018 às 18:22
-- Versão do servidor: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projeto_vacinas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `doses`
--

DROP TABLE IF EXISTS `doses`;
CREATE TABLE IF NOT EXISTS `doses` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `local` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `numerodose` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validade` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doses_id_user_foreign` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `doses`
--

INSERT INTO `doses` (`id`, `nome`, `local`, `id_user`, `numerodose`, `validade`, `created_at`, `updated_at`) VALUES
(1, 'Gripe A', 'Posto BPS', 1, 'primeira dose', '2019-02-01', NULL, NULL),
(2, 'HPV ', 'Posto BPS', 1, 'Segunda Dose', '2019-02-01', NULL, NULL),
(3, 'caxumba', 'morro chic', 2, 'primeira', '2020-05-15', NULL, NULL),
(4, 'Gripe a', 'BPS unifei', 3, 'dose unica', '2019-07-20', NULL, NULL),
(5, 'teste', 'teste', 1, '1', '2019-02-02', '2018-08-22 16:26:22', '2018-08-22 16:26:22'),
(6, 'teste', 'teste', 1, '1', '2019-02-02', '2018-08-22 16:27:16', '2018-08-22 16:27:16'),
(7, 'gripe a', 'bps', 4, '1', '2019-05-30', '2018-08-24 01:58:33', '2018-08-24 01:58:33'),
(8, 'teste', 'qualquer', 3, '1', '2018-08-16', NULL, NULL),
(9, 'gripe', 'bps', 4, '2', '2020-03-06', '2018-08-31 20:01:03', '2018-08-31 20:01:03'),
(10, 'gripe', 'bps', 3, '2', '2020-03-06', '2018-08-31 20:03:19', '2018-08-31 20:03:19'),
(31, 'teste', 'bps', 3, '3', '2020-03-03', '2018-08-31 20:36:19', '2018-08-31 20:36:19'),
(34, 'dose', 'bps', 3, '2', '2020-02-02', '2018-08-31 20:50:20', '2018-08-31 20:50:20'),
(35, 'fabio', 'bps', 4, '1', '2019-08-17', '2018-08-31 21:15:55', '2018-08-31 21:15:55'),
(36, 'fabio', 'bps', 4, '1', '2019-08-17', '2018-08-31 21:17:53', '2018-08-31 21:17:53'),
(37, 'fabio', 'bps', 3, '1', '2018-08-04', '2018-08-31 21:22:42', '2018-08-31 21:22:42'),
(39, 'devmedia', 'teste', 4, '1', '2018-08-07', '2018-08-31 21:23:40', '2018-08-31 21:23:40');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_08_20_151536_create_doses_table', 1),
(4, '2018_08_21_103345_create_roles_table', 2),
(5, '2018_08_21_103524_create_permissions_table', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('fabiorsao@gmail.com', '$2y$10$kWy6WX3vhuU0Ft9loAHfZudrNTxMxNvWR2jJTtPECHYd.5h9weaMe', '2018-08-24 19:40:31');

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES
(1, 'view_vacina', 'visualiza a carteira de vacinas', NULL, NULL),
(2, 'create_vacina', 'registra uma nova dose', NULL, NULL),
(3, 'delete_vacina', 'remove uma dose', NULL, NULL),
(4, 'edit_vacina', 'edita dados da dose', NULL, NULL),
(5, 'view_users', 'visualiza todos os usuários no sistemas', NULL, NULL),
(6, 'view_roles', 'visualiza todas as funções no sistema', NULL, NULL),
(7, 'view_permissions', 'visualiza todas as permissões no sistema', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE IF NOT EXISTS `permission_role` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_role_permission_id_foreign` (`permission_id`),
  KEY `permission_role_role_id_foreign` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`) VALUES
(1, 2, 1),
(2, 3, 1),
(3, 4, 1),
(4, 1, 2),
(5, 2, 3),
(6, 5, 1),
(7, 6, 1),
(8, 7, 1),
(9, 1, 2),
(10, 1, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES
(1, 'adm', 'Administrador do sistema', NULL, NULL),
(2, 'usuario', 'usuario comum', NULL, NULL),
(3, 'profissional_saude', 'Responsável pelo cadastramento de doses', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `role_user`
--

DROP TABLE IF EXISTS `role_user`;
CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_user_id_foreign` (`user_id`),
  KEY `role_user_role_id_foreign` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`) VALUES
(2, 2, 2),
(3, 3, 2),
(4, 1, 1),
(5, 4, 2),
(6, 5, 3),
(7, 7, 2),
(8, 10, 3),
(9, 0, 2),
(10, 0, 2),
(11, 13, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nascimento` date NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `nascimento`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Fabio Rodrigo Dos Santos Alves de Oliveira', 'fabiorsao@gmail.com', '$2y$10$FlWima8qZazhJNZcKBKMzu3P/2bf1U9ds9Eg.ba7.bab0EdWfbxIy', '1998-01-02', 'yzIsOUFtRxzTKwfj75nclT4dlMSq33dO9gx6cSZTZ9Xn0dRiha5XYjwmN3tJ', '2018-08-20 19:12:27', '2018-08-20 19:12:27'),
(2, 'jorge', 'jorge@jorge.com', '$2y$10$E9y9bA.1.SXSxNONhPe4du4bk./VeIK/CsmQEce6JycsaYaFXhrQO', '1998-01-06', '85vJX8TFbu8aKoHQb0HNpJMXyoBfIi9omXPOY244sB9wN51bGzbjD0Ppyt8H', '2018-08-21 12:53:07', '2018-08-21 12:53:07'),
(3, 'renata', 'renata@teste.com', '$2y$10$5GYnjzQ.p2zlM7w3Vod20eU5r43uukTKW1O5LHqBmAanNXF7wjph2', '1989-03-05', 'H09qEe0uov05jhrhhjYKB0kx4s6Cs58ofj0UFPTdOc3wNeWbDh0K7SDejjGW', '2018-08-21 21:49:42', '2018-08-21 21:49:42'),
(4, 'tata', 'tata@teste.com', '$2y$10$NOtaWQcZHc7yQmmE1j1Wc.8iqpdGdRBeYsaDsgLugt1uqHEl9pCnK', '1998-01-13', 'S822mNqMPSsKSgPgRTnLojVJX9eKzkpweYCsmpR5atAnJx6woBCb2E2pnkjq', '2018-08-24 01:53:17', '2018-08-24 01:53:17'),
(5, 'enfermeira', 'enfermeira@teste.com', '$2y$10$.8pv.tXoV72s3on9TPS3.uRvL1S8q8qVEWE.Iqj/jIT8BgZO8tWty', '1970-08-28', 'rpC1kwBrLQkKwkaP3OzBnqTdv2lSNpKuY5dC2MVt1KwHUp2WNWauPuVlPBya', '2018-08-28 13:33:42', '2018-08-28 13:33:42'),
(6, 'capivara', 'capivara@teste.com', '$2y$10$9Uheha5.j4ucg6ZbJtXPneaMkhBDqphd0aTCxBJL0HJLOB4Xf9sL2', '1999-02-03', 'rd24PDVSXUAQJdagK8GcFdWpfqPtkfPAMno3io5O4KNj5qpQNYCKLLoOTReg', '2018-08-28 15:30:53', '2018-08-28 15:30:53'),
(7, 'james', 'james@teste.com', '$2y$10$5o2LmTzTHB7bq1qG7rxfFO5vqk34ZZrddPAv1TQY49a71FMqphLcW', '2001-04-01', 'nzSw3s84IvilfYsZy0dTnCsko2INEfY38RcmoBGOgXQ7uZULK6oOrEDjwX7U', '2018-08-28 16:02:05', '2018-08-28 16:02:05'),
(9, 'novo', 'novo@novo.com', '$2y$10$DYhE.TwqZW3iTIJ.J7PG9OquR9Gpo9uwyHPlyUQij0e5s0okMbQi.', '2018-08-08', 'DjFnrHLkAN27jl4jt1ng7w70a3xBAZJ2iI01VRCesBLCsGO69cFwRhIi2U8s', '2018-08-30 14:13:23', '2018-08-30 14:13:23'),
(10, 'teste1', 'teste1@teste.com', '$2y$10$5uuRh15z9763D0u2yIIFN.LxDSCe9g2aNCtDRhJmSaI/9JnWkzLbi', '2018-08-01', 'tawevVsQ5NZZ6NsCgMDkLpnnXVoov70xP9RrIXR0NuXYZYZcHG21cYtmu15m', '2018-08-31 20:48:08', '2018-08-31 20:48:08'),
(12, 'benedito', 'guedes@gmail.com', '$2y$10$pwbn3SpuaIHBmKlzt846tuQfNbnk3YEB5jWJc2rUyecyLrapBTZsu', '1975-01-02', 'jZfRtWjhSiJigXknoZZDobTlB1lce9reMS9jrlVcWXabVREeDwyN3xpRrSoq', '2018-09-03 20:39:58', '2018-09-03 20:39:58'),
(13, 'xxxx', 'xxxx@teste.com', '$2y$10$9TPBCOSphNJ25i8Idc8Wp.N8cOjEPcxDqKWS9AC4p.nicfnquH4We', '1983-02-01', '8wJaoBzWrc29n82IkG7bVU2ThG9rl9NPFOwdhF66hllW2lkphohs2pmKglpL', '2018-09-03 20:41:54', '2018-09-03 20:41:54');

--
-- Acionadores `users`
--
DROP TRIGGER IF EXISTS `novousuario1`;
DELIMITER $$
CREATE TRIGGER `novousuario1` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    INSERT INTO role_user
    SET user_id = new.id,
     role_id =2; 
END
$$
DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
