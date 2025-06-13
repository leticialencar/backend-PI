-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/06/2025 às 17:02
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cashhive_system`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `auditoria`
--

CREATE TABLE `auditoria` (
  `id_auditoria` int(11) NOT NULL,
  `tabela_afetada` varchar(100) DEFAULT NULL,
  `operacao` varchar(10) DEFAULT NULL,
  `data_operacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `chave_primaria` text DEFAULT NULL,
  `dados_anteriores` text DEFAULT NULL,
  `dados_novos` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `auditoria`
--

INSERT INTO `auditoria` (`id_auditoria`, `tabela_afetada`, `operacao`, `data_operacao`, `chave_primaria`, `dados_anteriores`, `dados_novos`) VALUES
(1, 'USUARIO', 'UPDATE', '2025-05-14 21:38:16', '1', NULL, NULL),
(2, 'USUARIO', 'UPDATE', '2025-05-14 21:40:18', '1', NULL, NULL),
(3, 'USUARIO', 'UPDATE', '2025-05-14 21:40:30', '1', NULL, NULL),
(4, 'USUARIO', 'UPDATE', '2025-05-14 22:12:54', '2', NULL, NULL),
(5, 'USUARIO', 'UPDATE', '2025-05-14 22:37:20', '2', NULL, NULL),
(6, 'USUARIO', 'UPDATE', '2025-05-25 00:21:08', '2', NULL, NULL),
(7, 'ENDERECO', 'INSERT', '2025-05-25 00:21:08', '3', NULL, 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(8, 'TELEFONE', 'INSERT', '2025-05-25 00:21:08', '1', NULL, 'ddd=88, numero=8817921'),
(9, 'USUARIO', 'UPDATE', '2025-05-25 00:21:23', '2', NULL, NULL),
(10, 'ENDERECO', 'UPDATE', '2025-05-25 00:21:23', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(11, 'TELEFONE', 'UPDATE', '2025-05-25 00:21:23', '1', 'ddd=88, numero=8817921', 'ddd=88, numero=8817921'),
(12, 'USUARIO', 'UPDATE', '2025-05-25 00:21:25', '2', NULL, NULL),
(13, 'ENDERECO', 'UPDATE', '2025-05-25 00:21:25', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(14, 'TELEFONE', 'UPDATE', '2025-05-25 00:21:25', '1', 'ddd=88, numero=8817921', 'ddd=88, numero=8817921'),
(15, 'USUARIO', 'UPDATE', '2025-05-25 00:21:26', '2', NULL, NULL),
(16, 'ENDERECO', 'UPDATE', '2025-05-25 00:21:26', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(17, 'TELEFONE', 'UPDATE', '2025-05-25 00:21:26', '1', 'ddd=88, numero=8817921', 'ddd=88, numero=8817921'),
(18, 'USUARIO', 'UPDATE', '2025-05-25 00:21:26', '2', NULL, NULL),
(19, 'ENDERECO', 'UPDATE', '2025-05-25 00:21:26', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(20, 'TELEFONE', 'UPDATE', '2025-05-25 00:21:26', '1', 'ddd=88, numero=8817921', 'ddd=88, numero=8817921'),
(21, 'USUARIO', 'UPDATE', '2025-05-25 00:21:26', '2', NULL, NULL),
(22, 'ENDERECO', 'UPDATE', '2025-05-25 00:21:26', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(23, 'TELEFONE', 'UPDATE', '2025-05-25 00:21:26', '1', 'ddd=88, numero=8817921', 'ddd=88, numero=8817921'),
(24, 'USUARIO', 'UPDATE', '2025-05-25 00:21:26', '2', NULL, NULL),
(25, 'ENDERECO', 'UPDATE', '2025-05-25 00:21:26', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(26, 'TELEFONE', 'UPDATE', '2025-05-25 00:21:26', '1', 'ddd=88, numero=8817921', 'ddd=88, numero=8817921'),
(27, 'USUARIO', 'UPDATE', '2025-05-25 00:21:32', '2', NULL, NULL),
(28, 'ENDERECO', 'UPDATE', '2025-05-25 00:21:32', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(29, 'TELEFONE', 'UPDATE', '2025-05-25 00:21:32', '1', 'ddd=88, numero=8817921', 'ddd=88, numero='),
(30, 'USUARIO', 'UPDATE', '2025-05-25 00:21:32', '2', NULL, NULL),
(31, 'ENDERECO', 'UPDATE', '2025-05-25 00:21:32', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(32, 'TELEFONE', 'UPDATE', '2025-05-25 00:21:32', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(33, 'USUARIO', 'UPDATE', '2025-05-25 00:29:20', '2', NULL, NULL),
(34, 'ENDERECO', 'UPDATE', '2025-05-25 00:29:20', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(35, 'TELEFONE', 'UPDATE', '2025-05-25 00:29:20', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(36, 'USUARIO', 'UPDATE', '2025-05-25 00:29:23', '2', NULL, NULL),
(37, 'ENDERECO', 'UPDATE', '2025-05-25 00:29:23', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(38, 'TELEFONE', 'UPDATE', '2025-05-25 00:29:23', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(39, 'USUARIO', 'UPDATE', '2025-05-25 00:29:28', '2', NULL, NULL),
(40, 'ENDERECO', 'UPDATE', '2025-05-25 00:29:28', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(41, 'TELEFONE', 'UPDATE', '2025-05-25 00:29:28', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(42, 'USUARIO', 'UPDATE', '2025-05-25 00:29:29', '2', NULL, NULL),
(43, 'ENDERECO', 'UPDATE', '2025-05-25 00:29:29', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(44, 'TELEFONE', 'UPDATE', '2025-05-25 00:29:29', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(45, 'USUARIO', 'UPDATE', '2025-05-25 00:29:35', '2', NULL, NULL),
(46, 'ENDERECO', 'UPDATE', '2025-05-25 00:29:35', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(47, 'TELEFONE', 'UPDATE', '2025-05-25 00:29:35', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(48, 'USUARIO', 'UPDATE', '2025-05-25 00:32:51', '2', NULL, NULL),
(49, 'ENDERECO', 'UPDATE', '2025-05-25 00:32:51', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(50, 'TELEFONE', 'UPDATE', '2025-05-25 00:32:51', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(51, 'USUARIO', 'UPDATE', '2025-05-25 00:32:51', '2', NULL, NULL),
(52, 'ENDERECO', 'UPDATE', '2025-05-25 00:32:51', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(53, 'TELEFONE', 'UPDATE', '2025-05-25 00:32:51', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(54, 'USUARIO', 'UPDATE', '2025-05-25 00:34:03', '2', NULL, NULL),
(55, 'ENDERECO', 'UPDATE', '2025-05-25 00:34:03', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(56, 'TELEFONE', 'UPDATE', '2025-05-25 00:34:03', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(57, 'USUARIO', 'UPDATE', '2025-05-25 00:34:03', '2', NULL, NULL),
(58, 'ENDERECO', 'UPDATE', '2025-05-25 00:34:03', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(59, 'TELEFONE', 'UPDATE', '2025-05-25 00:34:03', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(60, 'USUARIO', 'UPDATE', '2025-05-25 00:34:10', '2', NULL, NULL),
(61, 'ENDERECO', 'UPDATE', '2025-05-25 00:34:10', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(62, 'TELEFONE', 'UPDATE', '2025-05-25 00:34:10', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(63, 'USUARIO', 'UPDATE', '2025-05-25 00:34:10', '2', NULL, NULL),
(64, 'ENDERECO', 'UPDATE', '2025-05-25 00:34:10', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(65, 'TELEFONE', 'UPDATE', '2025-05-25 00:34:10', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(66, 'USUARIO', 'UPDATE', '2025-05-25 00:34:15', '2', NULL, NULL),
(67, 'ENDERECO', 'UPDATE', '2025-05-25 00:34:15', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(68, 'TELEFONE', 'UPDATE', '2025-05-25 00:34:15', '1', 'ddd=88, numero=', 'ddd=88, numero=988176921'),
(69, 'USUARIO', 'UPDATE', '2025-05-25 00:34:15', '2', NULL, NULL),
(70, 'ENDERECO', 'UPDATE', '2025-05-25 00:34:15', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(71, 'TELEFONE', 'UPDATE', '2025-05-25 00:34:15', '1', 'ddd=88, numero=988176921', 'ddd=88, numero=988176921'),
(72, 'USUARIO', 'UPDATE', '2025-05-25 00:37:31', '2', NULL, NULL),
(73, 'ENDERECO', 'UPDATE', '2025-05-25 00:37:31', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(74, 'TELEFONE', 'UPDATE', '2025-05-25 00:37:31', '1', 'ddd=88, numero=988176921', 'ddd=88, numero='),
(75, 'USUARIO', 'UPDATE', '2025-05-25 00:37:31', '2', NULL, NULL),
(76, 'ENDERECO', 'UPDATE', '2025-05-25 00:37:31', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(77, 'TELEFONE', 'UPDATE', '2025-05-25 00:37:31', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(78, 'USUARIO', 'UPDATE', '2025-05-25 00:37:31', '2', NULL, NULL),
(79, 'ENDERECO', 'UPDATE', '2025-05-25 00:37:31', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(80, 'TELEFONE', 'UPDATE', '2025-05-25 00:37:31', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(81, 'USUARIO', 'UPDATE', '2025-05-25 00:38:07', '2', NULL, NULL),
(82, 'ENDERECO', 'UPDATE', '2025-05-25 00:38:07', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(83, 'TELEFONE', 'UPDATE', '2025-05-25 00:38:07', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(84, 'USUARIO', 'UPDATE', '2025-05-25 00:38:07', '2', NULL, NULL),
(85, 'ENDERECO', 'UPDATE', '2025-05-25 00:38:07', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(86, 'TELEFONE', 'UPDATE', '2025-05-25 00:38:07', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(87, 'USUARIO', 'UPDATE', '2025-05-25 00:38:07', '2', NULL, NULL),
(88, 'ENDERECO', 'UPDATE', '2025-05-25 00:38:07', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(89, 'TELEFONE', 'UPDATE', '2025-05-25 00:38:07', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(90, 'USUARIO', 'UPDATE', '2025-05-25 00:39:45', '2', NULL, NULL),
(91, 'ENDERECO', 'UPDATE', '2025-05-25 00:39:45', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(92, 'TELEFONE', 'UPDATE', '2025-05-25 00:39:45', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(93, 'USUARIO', 'UPDATE', '2025-05-25 00:39:45', '2', NULL, NULL),
(94, 'ENDERECO', 'UPDATE', '2025-05-25 00:39:45', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(95, 'TELEFONE', 'UPDATE', '2025-05-25 00:39:45', '1', 'ddd=88, numero=', 'ddd=88, numero='),
(96, 'USUARIO', 'UPDATE', '2025-05-25 00:40:02', '2', NULL, NULL),
(97, 'ENDERECO', 'UPDATE', '2025-05-25 00:40:02', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(98, 'TELEFONE', 'UPDATE', '2025-05-25 00:40:02', '1', 'ddd=88, numero=', 'ddd=88, numero=988176921'),
(99, 'USUARIO', 'UPDATE', '2025-05-25 00:40:02', '2', NULL, NULL),
(100, 'ENDERECO', 'UPDATE', '2025-05-25 00:40:02', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(101, 'TELEFONE', 'UPDATE', '2025-05-25 00:40:02', '1', 'ddd=88, numero=988176921', 'ddd=88, numero=988176921'),
(102, 'USUARIO', 'UPDATE', '2025-05-25 02:01:09', '2', NULL, NULL),
(103, 'ENDERECO', 'UPDATE', '2025-05-25 02:01:09', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(104, 'TELEFONE', 'UPDATE', '2025-05-25 02:01:09', '1', 'ddd=88, numero=988176921', 'ddd=n, numero='),
(105, 'USUARIO', 'UPDATE', '2025-05-25 02:01:09', '2', NULL, NULL),
(106, 'ENDERECO', 'UPDATE', '2025-05-25 02:01:09', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(107, 'TELEFONE', 'UPDATE', '2025-05-25 02:01:09', '1', 'ddd=n, numero=', 'ddd=n, numero='),
(108, 'USUARIO', 'UPDATE', '2025-05-25 03:42:32', '2', NULL, NULL),
(109, 'USUARIO', 'UPDATE', '2025-05-25 04:26:09', '1', NULL, NULL),
(110, 'USUARIO', 'UPDATE', '2025-05-25 18:34:39', '1', NULL, 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(111, 'ENDERECO', 'INSERT', '2025-05-25 18:34:39', '4', NULL, 'rua=, bairro=, cidade=, estado='),
(112, 'TELEFONE', 'INSERT', '2025-05-25 18:34:39', '2', NULL, 'ddd=, numero='),
(113, 'USUARIO', 'UPDATE', '2025-05-25 18:34:39', '1', 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(114, 'ENDERECO', 'UPDATE', '2025-05-25 18:34:39', '4', 'rua=, bairro=, cidade=, estado=', 'rua=, bairro=, cidade=, estado='),
(115, 'TELEFONE', 'UPDATE', '2025-05-25 18:34:39', '2', 'ddd=, numero=', 'ddd=, numero='),
(116, 'USUARIO', 'UPDATE', '2025-05-25 18:35:13', '1', 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(117, 'ENDERECO', 'UPDATE', '2025-05-25 18:35:13', '4', 'rua=, bairro=, cidade=, estado=', 'rua=, bairro=, cidade=, estado='),
(118, 'TELEFONE', 'UPDATE', '2025-05-25 18:35:13', '2', 'ddd=, numero=', 'ddd=, numero='),
(119, 'USUARIO', 'UPDATE', '2025-05-25 18:35:13', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(120, 'ENDERECO', 'UPDATE', '2025-05-25 18:35:13', '4', 'rua=, bairro=, cidade=, estado=', 'rua=, bairro=, cidade=, estado='),
(121, 'TELEFONE', 'UPDATE', '2025-05-25 18:35:13', '2', 'ddd=, numero=', 'ddd=, numero='),
(122, 'USUARIO', 'UPDATE', '2025-05-25 18:38:06', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(123, 'ENDERECO', 'UPDATE', '2025-05-25 18:38:06', '4', 'rua=, bairro=, cidade=, estado=', 'rua=, bairro=, cidade=, estado='),
(124, 'TELEFONE', 'UPDATE', '2025-05-25 18:38:06', '2', 'ddd=, numero=', 'ddd=, numero='),
(125, 'USUARIO', 'UPDATE', '2025-05-25 18:38:06', '1', 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(126, 'ENDERECO', 'UPDATE', '2025-05-25 18:38:06', '4', 'rua=, bairro=, cidade=, estado=', 'rua=, bairro=, cidade=, estado='),
(127, 'TELEFONE', 'UPDATE', '2025-05-25 18:38:06', '2', 'ddd=, numero=', 'ddd=, numero='),
(128, 'USUARIO', 'UPDATE', '2025-05-25 18:58:49', '1', 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(129, 'ENDERECO', 'UPDATE', '2025-05-25 18:58:49', '4', 'rua=, bairro=, cidade=, estado=', 'rua=, bairro=, cidade=, estado='),
(130, 'TELEFONE', 'UPDATE', '2025-05-25 18:58:49', '2', 'ddd=, numero=', 'ddd=, numero='),
(131, 'USUARIO', 'UPDATE', '2025-05-25 18:58:49', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(132, 'ENDERECO', 'UPDATE', '2025-05-25 18:58:49', '4', 'rua=, bairro=, cidade=, estado=', 'rua=, bairro=, cidade=, estado='),
(133, 'TELEFONE', 'UPDATE', '2025-05-25 18:58:49', '2', 'ddd=, numero=', 'ddd=, numero='),
(134, 'USUARIO', 'UPDATE', '2025-05-25 18:59:19', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(135, 'ENDERECO', 'UPDATE', '2025-05-25 18:59:19', '4', 'rua=, bairro=, cidade=, estado=', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(136, 'TELEFONE', 'UPDATE', '2025-05-25 18:59:19', '2', 'ddd=, numero=', 'ddd=55, numero=988176921'),
(137, 'USUARIO', 'UPDATE', '2025-05-25 18:59:19', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(138, 'ENDERECO', 'UPDATE', '2025-05-25 18:59:19', '4', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(139, 'TELEFONE', 'UPDATE', '2025-05-25 18:59:19', '2', 'ddd=55, numero=988176921', 'ddd=55, numero=988176921'),
(140, 'CATEGORIA_RECEITA', 'INSERT', '2025-05-25 19:35:34', '1', NULL, 'categoria=Picolé'),
(141, 'CATEGORIA_RECEITA', 'INSERT', '2025-05-25 19:35:34', '2', NULL, 'categoria=Sorvete'),
(142, 'RECEITA', 'INSERT', '2025-05-25 19:48:56', '2', NULL, 'cliente=Ramon, produto=2, total=400.00'),
(143, 'RECEITA', 'INSERT', '2025-05-25 19:55:21', '3', NULL, 'cliente=Ramon, produto=1, total=400.00'),
(144, 'RECEITA', 'INSERT', '2025-05-25 19:58:48', '4', NULL, 'cliente=Letícia, produto=1, total=320.00'),
(145, 'RECEITA', 'INSERT', '2025-05-25 21:29:04', '5', NULL, 'cliente=Ramon, produto=1, total=1500.00'),
(146, 'RECEITA', 'INSERT', '2025-05-25 21:29:06', '6', NULL, 'cliente=Ramon, produto=1, total=1500.00'),
(147, 'RECEITA', 'INSERT', '2025-05-25 21:29:06', '7', NULL, 'cliente=Ramon, produto=1, total=1500.00'),
(148, 'RECEITA', 'INSERT', '2025-05-25 21:29:06', '8', NULL, 'cliente=Ramon, produto=1, total=1500.00'),
(149, 'RECEITA', 'INSERT', '2025-05-25 21:29:06', '9', NULL, 'cliente=Ramon, produto=1, total=1500.00'),
(150, 'RECEITA', 'INSERT', '2025-05-25 21:31:46', '10', NULL, 'cliente=Sla, produto=1, total=30.00'),
(151, 'RECEITA', 'INSERT', '2025-05-25 21:36:51', '11', NULL, 'cliente=Letícia, produto=1, total=225.00'),
(152, 'USUARIO', 'UPDATE', '2025-05-25 22:11:15', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(153, 'ENDERECO', 'UPDATE', '2025-05-25 22:11:15', '4', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE'),
(154, 'TELEFONE', 'UPDATE', '2025-05-25 22:11:15', '2', 'ddd=55, numero=988176921', 'ddd=55, numero=988176921'),
(155, 'USUARIO', 'UPDATE', '2025-05-25 22:11:15', '1', 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(156, 'ENDERECO', 'UPDATE', '2025-05-25 22:11:15', '4', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE'),
(157, 'TELEFONE', 'UPDATE', '2025-05-25 22:11:15', '2', 'ddd=55, numero=988176921', 'ddd=55, numero=988176921'),
(158, 'RECEITA', 'INSERT', '2025-05-25 22:14:54', '12', NULL, 'cliente=Brenda, produto=2, total=20.00'),
(159, 'USUARIO', 'UPDATE', '2025-05-25 22:17:56', '2', NULL, NULL),
(160, 'ENDERECO', 'UPDATE', '2025-05-25 22:17:56', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(161, 'TELEFONE', 'UPDATE', '2025-05-25 22:17:56', '1', 'ddd=n, numero=', 'ddd=88, numero=988176921'),
(162, 'USUARIO', 'UPDATE', '2025-05-25 22:17:56', '2', NULL, NULL),
(163, 'ENDERECO', 'UPDATE', '2025-05-25 22:17:56', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(164, 'TELEFONE', 'UPDATE', '2025-05-25 22:17:56', '1', 'ddd=88, numero=988176921', 'ddd=88, numero=988176921'),
(165, 'USUARIO', 'UPDATE', '2025-05-25 23:45:36', '1', 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(166, 'ENDERECO', 'UPDATE', '2025-05-25 23:45:36', '4', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE'),
(167, 'TELEFONE', 'UPDATE', '2025-05-25 23:45:36', '2', 'ddd=55, numero=988176921', 'ddd=55, numero=988176921'),
(168, 'USUARIO', 'UPDATE', '2025-05-25 23:45:37', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(169, 'ENDERECO', 'UPDATE', '2025-05-25 23:45:37', '4', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE'),
(170, 'TELEFONE', 'UPDATE', '2025-05-25 23:45:37', '2', 'ddd=55, numero=988176921', 'ddd=55, numero=988176921'),
(171, 'RECEITA', 'INSERT', '2025-05-27 02:34:39', '13', NULL, 'cliente=Ramon, produto=1, total=5000.00'),
(172, 'RECEITA', 'INSERT', '2025-05-27 02:50:10', '14', NULL, 'cliente=Sla, produto=1, total=1400.00'),
(173, 'RECEITA', 'INSERT', '2025-05-27 02:52:03', '15', NULL, 'cliente=Sla, produto=1, total=200.00'),
(174, 'RECEITA', 'INSERT', '2025-05-27 02:54:43', '16', NULL, 'cliente=Brenda, produto=2, total=40.00'),
(175, 'RECEITA', 'INSERT', '2025-05-27 02:57:22', '17', NULL, 'cliente=Sla, produto=2, total=128.00'),
(176, 'CARGO', 'INSERT', '2025-05-28 22:43:03', '1', NULL, 'cargo=Gerente'),
(177, 'CARGO', 'INSERT', '2025-05-28 22:43:03', '2', NULL, 'cargo=Vendedor'),
(178, 'CARGO', 'INSERT', '2025-05-28 22:43:03', '3', NULL, 'cargo=Caixa'),
(179, 'USUARIO', 'UPDATE', '2025-05-29 21:57:20', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(180, 'ENDERECO', 'UPDATE', '2025-05-29 21:57:20', '4', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE'),
(181, 'TELEFONE', 'UPDATE', '2025-05-29 21:57:20', '2', 'ddd=55, numero=988176921', 'ddd=55, numero=988176921'),
(182, 'USUARIO', 'UPDATE', '2025-05-31 02:50:44', '2', NULL, NULL),
(183, 'ENDERECO', 'UPDATE', '2025-05-31 02:50:44', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(184, 'TELEFONE', 'UPDATE', '2025-05-31 02:50:44', '1', 'ddd=88, numero=988176921', 'ddd=88, numero=988176921'),
(185, 'USUARIO', 'UPDATE', '2025-05-31 02:50:44', '2', NULL, NULL),
(186, 'ENDERECO', 'UPDATE', '2025-05-31 02:50:44', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(187, 'TELEFONE', 'UPDATE', '2025-05-31 02:50:44', '1', 'ddd=88, numero=988176921', 'ddd=88, numero=988176921'),
(188, 'USUARIO', 'UPDATE', '2025-05-31 02:50:49', '2', NULL, NULL),
(189, 'ENDERECO', 'UPDATE', '2025-05-31 02:50:49', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(190, 'TELEFONE', 'UPDATE', '2025-05-31 02:50:49', '1', 'ddd=88, numero=988176921', 'ddd=88, numero=988176921'),
(191, 'USUARIO', 'UPDATE', '2025-05-31 02:50:49', '2', NULL, NULL),
(192, 'ENDERECO', 'UPDATE', '2025-05-31 02:50:49', '3', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua José Francisco do Nascimento, bairro=Betolândia, cidade=Juazeiro do Norte, estado=CE'),
(193, 'TELEFONE', 'UPDATE', '2025-05-31 02:50:49', '1', 'ddd=88, numero=988176921', 'ddd=88, numero=988176921'),
(194, 'DESPESA_VARIADOS', 'INSERT', '2025-06-01 20:39:14', '1', NULL, 'descricao=ACABOU NO ESTOQUE, valor=-120.00'),
(195, 'DESPESA_VARIADOS', 'INSERT', '2025-06-01 20:43:18', '2', NULL, 'descricao=ACABOU NO ESTOQUE, valor=8.00'),
(196, 'DESPESA_VARIADOS', 'INSERT', '2025-06-01 20:45:15', '3', NULL, 'descricao=MERENDA DA TARDE, valor=7.00'),
(197, 'DESPESA_VARIADOS', 'INSERT', '2025-06-01 20:49:11', '4', NULL, 'descricao=MERENDA DA TARDE, valor=5.00'),
(198, 'DESPESA_VARIADOS', 'INSERT', '2025-06-01 23:04:11', '5', NULL, 'descricao=MERENDA DA TARDE, valor=8.00'),
(199, 'CARGO', 'UPDATE', '2025-06-02 00:50:55', '1', 'cargo=Gerente', 'cargo=Gerente'),
(200, 'CARGO', 'UPDATE', '2025-06-02 00:50:55', '2', 'cargo=Vendedor', 'cargo=Vendedor'),
(201, 'CARGO', 'UPDATE', '2025-06-02 00:50:55', '3', 'cargo=Caixa', 'cargo=Caixa'),
(202, 'USUARIO', 'UPDATE', '2025-06-02 01:05:53', '2', NULL, NULL),
(203, 'USUARIO', 'UPDATE', '2025-06-02 01:06:07', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(204, 'USUARIO', 'UPDATE', '2025-06-02 22:42:45', '2', NULL, NULL),
(205, 'USUARIO', 'UPDATE', '2025-06-02 23:31:18', '2', NULL, NULL),
(206, 'USUARIO', 'UPDATE', '2025-06-02 23:31:36', '2', NULL, NULL),
(207, 'USUARIO', 'UPDATE', '2025-06-02 23:32:36', '2', NULL, NULL),
(208, 'USUARIO', 'UPDATE', '2025-06-02 23:32:43', '2', NULL, NULL),
(209, 'USUARIO', 'UPDATE', '2025-06-02 23:33:20', '2', NULL, NULL),
(210, 'USUARIO', 'UPDATE', '2025-06-02 23:33:26', '2', NULL, NULL),
(211, 'USUARIO', 'UPDATE', '2025-06-02 23:34:33', '2', NULL, NULL),
(212, 'USUARIO', 'UPDATE', '2025-06-02 23:34:37', '2', NULL, NULL),
(213, 'USUARIO', 'UPDATE', '2025-06-02 23:42:35', '2', NULL, NULL),
(214, 'USUARIO', 'UPDATE', '2025-06-02 23:42:42', '2', NULL, NULL),
(215, 'USUARIO', 'UPDATE', '2025-06-02 23:42:49', '2', NULL, NULL),
(216, 'USUARIO', 'UPDATE', '2025-06-02 23:43:27', '2', NULL, NULL),
(217, 'USUARIO', 'UPDATE', '2025-06-02 23:43:35', '2', NULL, NULL),
(218, 'USUARIO', 'UPDATE', '2025-06-02 23:46:23', '2', NULL, NULL),
(219, 'USUARIO', 'UPDATE', '2025-06-02 23:46:32', '2', NULL, NULL),
(220, 'USUARIO', 'UPDATE', '2025-06-02 23:46:39', '2', NULL, NULL),
(221, 'USUARIO', 'UPDATE', '2025-06-02 23:52:22', '2', NULL, NULL),
(222, 'USUARIO', 'UPDATE', '2025-06-02 23:52:31', '2', NULL, NULL),
(223, 'USUARIO', 'UPDATE', '2025-06-02 23:55:42', '2', NULL, NULL),
(224, 'USUARIO', 'UPDATE', '2025-06-02 23:55:47', '2', NULL, NULL),
(225, 'DESPESA_PRODUTO', 'INSERT', '2025-06-03 01:19:22', '1', NULL, 'produto=, qtd=0, total=0.00'),
(226, 'DESPESA_PRODUTO', 'INSERT', '2025-06-03 01:19:22', '2', NULL, 'produto=, qtd=0, total=0.00'),
(227, 'DESPESA_PRODUTO', 'INSERT', '2025-06-03 01:19:22', '3', NULL, 'produto=, qtd=0, total=0.00'),
(228, 'USUARIO', 'UPDATE', '2025-06-04 00:43:14', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(229, 'USUARIO', 'UPDATE', '2025-06-04 00:46:04', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(230, 'USUARIO', 'UPDATE', '2025-06-04 00:58:23', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(231, 'USUARIO', 'UPDATE', '2025-06-04 00:59:28', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(232, 'USUARIO', 'UPDATE', '2025-06-04 01:12:44', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(233, 'USUARIO', 'UPDATE', '2025-06-04 01:13:14', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(234, 'USUARIO', 'UPDATE', '2025-06-04 21:59:01', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(235, 'ENDERECO', 'UPDATE', '2025-06-04 21:59:01', '4', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE'),
(236, 'TELEFONE', 'UPDATE', '2025-06-04 21:59:01', '2', 'ddd=55, numero=988176921', 'ddd=55, numero=988176921'),
(237, 'USUARIO', 'UPDATE', '2025-06-04 21:59:01', '1', 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(238, 'ENDERECO', 'UPDATE', '2025-06-04 21:59:01', '4', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE'),
(239, 'TELEFONE', 'UPDATE', '2025-06-04 21:59:01', '2', 'ddd=55, numero=988176921', 'ddd=55, numero=988176921'),
(240, 'USUARIO', 'UPDATE', '2025-06-04 21:59:44', '1', 'nome=Adm, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(241, 'ENDERECO', 'UPDATE', '2025-06-04 21:59:44', '4', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE'),
(242, 'TELEFONE', 'UPDATE', '2025-06-04 21:59:44', '2', 'ddd=55, numero=988176921', 'ddd=55, numero=988176921'),
(243, 'USUARIO', 'UPDATE', '2025-06-04 21:59:44', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(244, 'ENDERECO', 'UPDATE', '2025-06-04 21:59:44', '4', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE'),
(245, 'TELEFONE', 'UPDATE', '2025-06-04 21:59:44', '2', 'ddd=55, numero=988176921', 'ddd=55, numero=988176921'),
(246, 'RECEITA', 'INSERT', '2025-06-04 22:27:38', '18', NULL, 'cliente=Beatriz, produto=1, total=50.00'),
(247, 'USUARIO', 'UPDATE', '2025-06-04 22:38:28', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(248, 'USUARIO', 'UPDATE', '2025-06-04 22:39:14', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(249, 'USUARIO', 'UPDATE', '2025-06-04 22:41:17', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(250, 'USUARIO', 'UPDATE', '2025-06-04 22:44:27', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(251, 'USUARIO', 'UPDATE', '2025-06-05 00:12:14', '1', 'nome=Administrador, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(252, 'ENDERECO', 'UPDATE', '2025-06-05 00:12:14', '4', 'rua=Rua Coronel Fausto Guimarães, bairro=Pirajá, cidade=Juazeiro do Norte, estado=CE', 'rua=Rua Coelho Alves, bairro=Novo Crato, cidade=Crato, estado=CE'),
(253, 'TELEFONE', 'UPDATE', '2025-06-05 00:12:14', '2', 'ddd=55, numero=988176921', 'ddd=55, numero=988176921'),
(254, 'USUARIO', 'UPDATE', '2025-06-05 00:12:14', '1', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(255, 'ENDERECO', 'UPDATE', '2025-06-05 00:12:14', '4', 'rua=Rua Coelho Alves, bairro=Novo Crato, cidade=Crato, estado=CE', 'rua=Rua Coelho Alves, bairro=Novo Crato, cidade=Crato, estado=CE'),
(256, 'TELEFONE', 'UPDATE', '2025-06-05 00:12:14', '2', 'ddd=55, numero=988176921', 'ddd=55, numero=988176921'),
(257, 'USUARIO', 'UPDATE', '2025-06-05 00:12:44', '2', NULL, NULL),
(258, 'USUARIO', 'UPDATE', '2025-06-05 00:12:53', '2', NULL, NULL),
(259, 'USUARIO', 'UPDATE', '2025-06-05 00:17:41', '1', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(260, 'USUARIO', 'UPDATE', '2025-06-05 00:19:01', '1', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(261, 'RECEITA', 'INSERT', '2025-06-05 00:20:29', '19', NULL, 'cliente=Ramon, produto=2, total=500.00'),
(262, 'RECEITA', 'INSERT', '2025-06-07 17:58:51', '20', NULL, 'cliente=Gojo, produto=1, total=75.00'),
(263, 'USUARIO', 'UPDATE', '2025-06-07 20:40:32', '1', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(264, 'USUARIO', 'UPDATE', '2025-06-07 20:43:37', '1', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(265, 'USUARIO', 'UPDATE', '2025-06-07 20:55:33', '1', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(266, 'USUARIO', 'UPDATE', '2025-06-07 20:56:31', '1', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(267, 'USUARIO', 'UPDATE', '2025-06-08 20:29:38', '1', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(268, 'USUARIO', 'UPDATE', '2025-06-08 20:34:34', '1', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(269, 'USUARIO', 'UPDATE', '2025-06-08 20:35:30', '1', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(270, 'USUARIO', 'UPDATE', '2025-06-08 20:42:03', '1', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(271, 'USUARIO', 'UPDATE', '2025-06-08 20:42:38', '1', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com', 'nome=Ramon, cpf=, cnpj=12345678000100, email=leticiaalencar520@gmail.com'),
(272, 'USUARIO', 'INSERT', '2025-06-08 23:12:09', '3', NULL, 'nome=Ramon Picolé, cpf=87748279012, cnpj=, email=upload.assets@gmail.com'),
(273, 'USUARIO', 'INSERT', '2025-06-08 23:18:54', '4', NULL, 'nome=Neuvillette Fontaine, cpf=65929430098, cnpj=, email=maria.silva6411@aluno.ce.gov.br'),
(274, 'USUARIO', 'UPDATE', '2025-06-11 04:12:33', '3', 'nome=Ramon Picolé, cpf=87748279012, cnpj=, email=upload.assets@gmail.com', 'nome=Tadeu Picolé, cpf=87748279012, cnpj=, email=upload.assets@gmail.com'),
(275, 'USUARIO', 'UPDATE', '2025-06-11 04:12:33', '3', 'nome=Tadeu Picolé, cpf=87748279012, cnpj=, email=upload.assets@gmail.com', 'nome=Tadeu Picolé, cpf=87748279012, cnpj=, email=upload.assets@gmail.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL,
  `nome_cargo` varchar(100) NOT NULL,
  `nivel_permissao` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `nome_cargo`, `nivel_permissao`) VALUES
(1, 'Gerente', 3),
(2, 'Vendedor', 2),
(3, 'Caixa', 1);

--
-- Acionadores `cargo`
--
DELIMITER $$
CREATE TRIGGER `trg_cargo_delete` AFTER DELETE ON `cargo` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_anteriores)
  VALUES ('CARGO', 'DELETE', OLD.id_cargo,
    CONCAT('cargo=', OLD.nome_cargo));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_cargo_insert` AFTER INSERT ON `cargo` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_novos)
  VALUES ('CARGO', 'INSERT', NEW.id_cargo,
    CONCAT('cargo=', NEW.nome_cargo));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_cargo_update` AFTER UPDATE ON `cargo` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_anteriores, dados_novos)
  VALUES ('CARGO', 'UPDATE', NEW.id_cargo,
    CONCAT('cargo=', OLD.nome_cargo),
    CONCAT('cargo=', NEW.nome_cargo));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria_receita`
--

CREATE TABLE `categoria_receita` (
  `id_categoria` int(11) NOT NULL,
  `nome_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categoria_receita`
--

INSERT INTO `categoria_receita` (`id_categoria`, `nome_categoria`) VALUES
(1, 'Picolé'),
(2, 'Sorvete');

--
-- Acionadores `categoria_receita`
--
DELIMITER $$
CREATE TRIGGER `trg_categoria_receita_delete` AFTER DELETE ON `categoria_receita` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_anteriores)
  VALUES ('CATEGORIA_RECEITA', 'DELETE', OLD.id_categoria,
    CONCAT('categoria=', OLD.nome_categoria));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_categoria_receita_insert` AFTER INSERT ON `categoria_receita` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_novos)
  VALUES ('CATEGORIA_RECEITA', 'INSERT', NEW.id_categoria,
    CONCAT('categoria=', NEW.nome_categoria));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_categoria_receita_update` AFTER UPDATE ON `categoria_receita` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_anteriores, dados_novos)
  VALUES ('CATEGORIA_RECEITA', 'UPDATE', NEW.id_categoria,
    CONCAT('categoria=', OLD.nome_categoria),
    CONCAT('categoria=', NEW.nome_categoria));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `despesas_fixas`
--

CREATE TABLE `despesas_fixas` (
  `id_despesa` int(11) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `data_conta` date NOT NULL,
  `data_pagamento` date NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `id_forma_pagamento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `despesas_fixas`
--

INSERT INTO `despesas_fixas` (`id_despesa`, `categoria`, `data_conta`, `data_pagamento`, `descricao`, `valor`, `id_forma_pagamento`) VALUES
(1, 'Água', '2025-06-05', '2025-05-28', 'teste 4', 120.00, 5),
(2, 'Água', '2025-06-05', '2025-05-28', 'teste 4', 120.00, 5),
(3, 'Internet', '2025-06-05', '2025-05-28', 'teste 5', 80.00, 5),
(4, 'Energia', '2025-06-07', '2025-05-31', 'teste', 130.00, 2),
(5, 'Internet', '2025-07-05', '2025-05-31', 'SEI LA', 50.00, 4),
(6, 'Energia', '2025-06-01', '2025-06-01', 'nao sei', 50.00, 4),
(7, 'Água', '2025-07-31', '2025-06-01', 'cagece', 60.00, 4),
(8, 'Água', '2025-07-10', '2025-06-25', 'teste 500', 120.00, 6),
(9, 'Água', '2025-06-19', '2025-06-13', 'nao sei', 200.00, 5),
(10, 'Internet', '2025-06-05', '2025-06-04', 'pago', 120.00, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `despesa_produto`
--

CREATE TABLE `despesa_produto` (
  `id_despesa_prod` int(11) NOT NULL,
  `data_compra` date NOT NULL,
  `nome_produto` varchar(100) NOT NULL,
  `qtd_produto` int(11) NOT NULL,
  `val_unitario` decimal(10,2) NOT NULL,
  `total_despesa` decimal(10,2) NOT NULL,
  `validade` date DEFAULT NULL,
  `id_fornecedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `despesa_produto`
--

INSERT INTO `despesa_produto` (`id_despesa_prod`, `data_compra`, `nome_produto`, `qtd_produto`, `val_unitario`, `total_despesa`, `validade`, `id_fornecedor`) VALUES
(1, '2025-06-02', 'Sorvete Napolitano', 12, 15.00, 180.00, '2025-06-02', 3),
(2, '2025-06-02', 'Sorvete de Flocos', 8, 10.00, 80.00, '2025-06-27', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `despesa_variados`
--

CREATE TABLE `despesa_variados` (
  `id_despesa_variados` int(11) NOT NULL,
  `data_conta` date NOT NULL,
  `data_pagamento` date NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `variado` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `despesa_variados`
--

INSERT INTO `despesa_variados` (`id_despesa_variados`, `data_conta`, `data_pagamento`, `descricao`, `valor`, `variado`) VALUES
(1, '2025-06-18', '2025-06-18', 'ACABOU NO ESTOQUE', -120.00, 'ÁGUA SANITARIA'),
(2, '2025-06-01', '2025-06-01', 'ACABOU NO ESTOQUE', 8.00, 'DETERGENTE'),
(3, '2025-06-01', '2025-06-01', 'MERENDA DA TARDE', 7.00, 'PAO'),
(4, '2025-06-13', '2025-06-13', 'MERENDA DA TARDE', 5.00, 'TAPIOCA'),
(5, '2025-06-12', '2025-06-12', 'MERENDA DA TARDE', 8.00, 'BISCOITO');

--
-- Acionadores `despesa_variados`
--
DELIMITER $$
CREATE TRIGGER `trg_despesa_variados_delete` AFTER DELETE ON `despesa_variados` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_anteriores)
  VALUES ('DESPESA_VARIADOS', 'DELETE', OLD.id_despesa_variados,
    CONCAT('descricao=', OLD.descricao, ', valor=', OLD.valor));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_despesa_variados_insert` AFTER INSERT ON `despesa_variados` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_novos)
  VALUES ('DESPESA_VARIADOS', 'INSERT', NEW.id_despesa_variados,
    CONCAT('descricao=', NEW.descricao, ', valor=', NEW.valor));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_despesa_variados_update` AFTER UPDATE ON `despesa_variados` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_anteriores, dados_novos)
  VALUES ('DESPESA_VARIADOS', 'UPDATE', NEW.id_despesa_variados,
    CONCAT('descricao=', OLD.descricao, ', valor=', OLD.valor),
    CONCAT('descricao=', NEW.descricao, ', valor=', NEW.valor));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco`
--

CREATE TABLE `endereco` (
  `id_endereco` int(11) NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `rua` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `endereco`
--

INSERT INTO `endereco` (`id_endereco`, `cep`, `rua`, `bairro`, `cidade`, `estado`, `id_usuario`) VALUES
(3, '63036310', 'Rua José Francisco do Nascimento', 'Betolândia', 'Juazeiro do Norte', 'CE', 2),
(4, '63113320', 'Rua Coelho Alves', 'Novo Crato', 'Crato', 'CE', 1);

--
-- Acionadores `endereco`
--
DELIMITER $$
CREATE TRIGGER `trg_endereco_delete` AFTER DELETE ON `endereco` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_anteriores)
  VALUES ('ENDERECO', 'DELETE', OLD.id_endereco,
    CONCAT('rua=', OLD.rua, ', bairro=', OLD.bairro, ', cidade=', OLD.cidade, ', estado=', OLD.estado));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_endereco_insert` AFTER INSERT ON `endereco` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_novos)
  VALUES ('ENDERECO', 'INSERT', NEW.id_endereco,
    CONCAT('rua=', NEW.rua, ', bairro=', NEW.bairro, ', cidade=', NEW.cidade, ', estado=', NEW.estado));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_endereco_update` AFTER UPDATE ON `endereco` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_anteriores, dados_novos)
  VALUES ('ENDERECO', 'UPDATE', NEW.id_endereco,
    CONCAT('rua=', OLD.rua, ', bairro=', OLD.bairro, ', cidade=', OLD.cidade, ', estado=', OLD.estado),
    CONCAT('rua=', NEW.rua, ', bairro=', NEW.bairro, ', cidade=', NEW.cidade, ', estado=', NEW.estado));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco_funcionario`
--

CREATE TABLE `endereco_funcionario` (
  `id_endereco_funcionario` int(11) NOT NULL,
  `cep_funcionario` varchar(10) DEFAULT NULL,
  `rua_funcionario` varchar(255) DEFAULT NULL,
  `numero_funcionario` varchar(10) DEFAULT NULL,
  `bairro_funcionario` varchar(255) DEFAULT NULL,
  `cidade_funcionario` varchar(255) DEFAULT NULL,
  `estado_funcionario` varchar(2) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `endereco_funcionario`
--

INSERT INTO `endereco_funcionario` (`id_endereco_funcionario`, `cep_funcionario`, `rua_funcionario`, `numero_funcionario`, `bairro_funcionario`, `cidade_funcionario`, `estado_funcionario`, `id_funcionario`) VALUES
(1, '63036310', 'Juazeiro do Norte', NULL, 'Betolândia', '', '', 1),
(2, '63036310', 'Juazeiro do Norte', NULL, 'Betolândia', '', '', 3),
(3, '63113320', 'Crato', NULL, 'Novo Crato', '', '', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `formas_pagamento`
--

CREATE TABLE `formas_pagamento` (
  `id_forma_pagamento` int(11) NOT NULL,
  `descricao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `formas_pagamento`
--

INSERT INTO `formas_pagamento` (`id_forma_pagamento`, `descricao`) VALUES
(1, 'Dinheiro'),
(2, 'Cartão de Crédito'),
(3, 'Cartão de Débito'),
(4, 'Transferência Bancária'),
(5, 'Boleto Bancário'),
(6, 'PIX');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fornecedor`
--

INSERT INTO `fornecedor` (`id`, `nome`) VALUES
(1, 'Kibon'),
(2, 'Nestlé'),
(3, 'Mareni');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `id_funcionario` int(11) NOT NULL,
  `nome_funcionario` varchar(100) NOT NULL,
  `cpf_funcionario` varchar(14) NOT NULL,
  `rg_funcionario` varchar(20) NOT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `data_admissao` date NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`id_funcionario`, `nome_funcionario`, `cpf_funcionario`, `rg_funcionario`, `id_cargo`, `data_admissao`, `salario`, `ativo`) VALUES
(1, 'Maria Letícia Alencar da Silva', '12345678900', '464184150', 1, '2025-06-08', 1538.36, 1),
(3, 'Ramon do Picolé Mareni', '28182543029', '194151438', 2, '2025-06-08', 1725.00, 0),
(4, 'Neuvillette Pinheiro da Silva de Fontaine', '89806021037', '239172103', 1, '2025-06-08', 3500.00, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL,
  `nome_produto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `nome_produto`) VALUES
(1, 'Kibon'),
(2, 'Nestlé'),
(3, 'Mareni');

-- --------------------------------------------------------

--
-- Estrutura para tabela `receita`
--

CREATE TABLE `receita` (
  `id_receita` int(11) NOT NULL,
  `data_venda` date NOT NULL,
  `nome_cliente` varchar(100) DEFAULT NULL,
  `nome_produto` varchar(100) DEFAULT NULL,
  `qtd_produto` int(11) NOT NULL,
  `val_unitario` decimal(10,2) NOT NULL,
  `total_receita` decimal(10,2) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_sabor` int(11) NOT NULL,
  `id_forma_pagamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `receita`
--

INSERT INTO `receita` (`id_receita`, `data_venda`, `nome_cliente`, `nome_produto`, `qtd_produto`, `val_unitario`, `total_receita`, `id_categoria`, `id_sabor`, `id_forma_pagamento`) VALUES
(1, '2025-06-07', 'Gojo', 'Kibon', 120, 12.00, 1440.00, 1, 1, 2),
(2, '2025-06-07', 'Letícia', 'Nestlé', 15, 8.00, 120.00, 2, 2, 1),
(3, '2025-06-07', 'Letícia', 'Nestlé', 120, 18.00, 2160.00, 1, 3, 4),
(4, '2025-06-07', 'Geto', 'Kibon', 15, 12.00, 180.00, 2, 2, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `sabor_produto`
--

CREATE TABLE `sabor_produto` (
  `id_sabor` int(11) NOT NULL,
  `nome_sabor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `sabor_produto`
--

INSERT INTO `sabor_produto` (`id_sabor`, `nome_sabor`) VALUES
(1, 'Morango'),
(2, 'Chocolate'),
(3, 'Napolitano'),
(4, 'Maracujá');

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefone`
--

CREATE TABLE `telefone` (
  `id_telefone` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `num_telefone` varchar(9) NOT NULL,
  `ddd` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `telefone`
--

INSERT INTO `telefone` (`id_telefone`, `id_usuario`, `num_telefone`, `ddd`) VALUES
(1, 2, '988176921', '88'),
(2, 1, '988176921', '55');

--
-- Acionadores `telefone`
--
DELIMITER $$
CREATE TRIGGER `trg_telefone_delete` AFTER DELETE ON `telefone` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_anteriores)
  VALUES ('TELEFONE', 'DELETE', OLD.id_telefone,
    CONCAT('ddd=', OLD.ddd, ', numero=', OLD.num_telefone));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_telefone_insert` AFTER INSERT ON `telefone` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_novos)
  VALUES ('TELEFONE', 'INSERT', NEW.id_telefone,
    CONCAT('ddd=', NEW.ddd, ', numero=', NEW.num_telefone));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_telefone_update` AFTER UPDATE ON `telefone` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_anteriores, dados_novos)
  VALUES ('TELEFONE', 'UPDATE', NEW.id_telefone,
    CONCAT('ddd=', OLD.ddd, ', numero=', OLD.num_telefone),
    CONCAT('ddd=', NEW.ddd, ', numero=', NEW.num_telefone));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefone_funcionario`
--

CREATE TABLE `telefone_funcionario` (
  `id_telefone_funcionario` int(11) NOT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `num_telefone_funcionario` varchar(9) NOT NULL,
  `ddd_funcionario` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `telefone_funcionario`
--

INSERT INTO `telefone_funcionario` (`id_telefone_funcionario`, `id_funcionario`, `num_telefone_funcionario`, `ddd_funcionario`) VALUES
(1, 1, '', '88'),
(2, 3, '', '88'),
(3, 4, '', '88');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome_usuario` varchar(100) NOT NULL,
  `cpf_usuario` varchar(14) DEFAULT NULL,
  `cnpj_usuario` varchar(18) DEFAULT NULL,
  `senha_usuario` varchar(255) NOT NULL,
  `email_usuario` varchar(320) NOT NULL,
  `data_adicao` date NOT NULL,
  `tipo_usuario` enum('admin','comum') DEFAULT 'comum',
  `id_cargo` int(11) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome_usuario`, `cpf_usuario`, `cnpj_usuario`, `senha_usuario`, `email_usuario`, `data_adicao`, `tipo_usuario`, `id_cargo`, `ativo`) VALUES
(1, 'Ramon', '', '12345678000100', '$2y$10$pv7WufO18ivzRsnJT3j1TuaB3UdIAupPA.UXcdSnW3DwLQEaKolU6', 'leticiaalencar520@gmail.com', '2025-04-30', 'admin', 3, 1),
(2, 'Leticia', '12345678900', NULL, '$2y$12$QxGVmhn4ZZkEBIwkgnB7k.OiSqKEtVXOE3elnVhyXYhfkSgJgLjQO', 'maria.silvalencars@gmail.com', '2025-05-11', 'comum', 2, 0),
(3, 'Tadeu Picolé', '87748279012', '', '$2y$10$leOAZvIlEu/WUZvOS4hrPummCHtPTx1uIGlBZS4off3XX031020cC', 'upload.assets@gmail.com', '2025-06-08', '', 1, 1),
(4, 'Neuvillette Fontaine', '65929430098', '', '$2y$10$znpYpObFktZkUGF2whbiIuXwQg3w9ZuVMwKDF.21HQoMIV1mbB37m', 'maria.silva6411@aluno.ce.gov.br', '2025-06-08', '', 3, 1);

--
-- Acionadores `usuario`
--
DELIMITER $$
CREATE TRIGGER `trg_usuario_delete` AFTER DELETE ON `usuario` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_anteriores)
  VALUES ('USUARIO', 'DELETE', OLD.id_usuario,
    CONCAT('nome=', OLD.nome_usuario, ', cpf=', OLD.cpf_usuario, ', cnpj=', OLD.cnpj_usuario, ', email=', OLD.email_usuario));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_usuario_insert` AFTER INSERT ON `usuario` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_novos)
  VALUES ('USUARIO', 'INSERT', NEW.id_usuario,
    CONCAT('nome=', NEW.nome_usuario, ', cpf=', NEW.cpf_usuario, ', cnpj=', NEW.cnpj_usuario, ', email=', NEW.email_usuario));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_usuario_update` AFTER UPDATE ON `usuario` FOR EACH ROW BEGIN
  INSERT INTO AUDITORIA (tabela_afetada, operacao, chave_primaria, dados_anteriores, dados_novos)
  VALUES ('USUARIO', 'UPDATE', NEW.id_usuario,
    CONCAT('nome=', OLD.nome_usuario, ', cpf=', OLD.cpf_usuario, ', cnpj=', OLD.cnpj_usuario, ', email=', OLD.email_usuario),
    CONCAT('nome=', NEW.nome_usuario, ', cpf=', NEW.cpf_usuario, ', cnpj=', NEW.cnpj_usuario, ', email=', NEW.email_usuario));
END
$$
DELIMITER ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`id_auditoria`);

--
-- Índices de tabela `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Índices de tabela `categoria_receita`
--
ALTER TABLE `categoria_receita`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices de tabela `despesas_fixas`
--
ALTER TABLE `despesas_fixas`
  ADD PRIMARY KEY (`id_despesa`),
  ADD KEY `id_forma_pagamento` (`id_forma_pagamento`);

--
-- Índices de tabela `despesa_produto`
--
ALTER TABLE `despesa_produto`
  ADD PRIMARY KEY (`id_despesa_prod`),
  ADD KEY `fk_fornecedor` (`id_fornecedor`);

--
-- Índices de tabela `despesa_variados`
--
ALTER TABLE `despesa_variados`
  ADD PRIMARY KEY (`id_despesa_variados`);

--
-- Índices de tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id_endereco`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `endereco_funcionario`
--
ALTER TABLE `endereco_funcionario`
  ADD PRIMARY KEY (`id_endereco_funcionario`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Índices de tabela `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
  ADD PRIMARY KEY (`id_forma_pagamento`);

--
-- Índices de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id_funcionario`),
  ADD UNIQUE KEY `cpf_funcionario` (`cpf_funcionario`),
  ADD KEY `id_cargo` (`id_cargo`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`);

--
-- Índices de tabela `receita`
--
ALTER TABLE `receita`
  ADD PRIMARY KEY (`id_receita`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_sabor` (`id_sabor`),
  ADD KEY `id_forma_pagamento` (`id_forma_pagamento`);

--
-- Índices de tabela `sabor_produto`
--
ALTER TABLE `sabor_produto`
  ADD PRIMARY KEY (`id_sabor`);

--
-- Índices de tabela `telefone`
--
ALTER TABLE `telefone`
  ADD PRIMARY KEY (`id_telefone`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `telefone_funcionario`
--
ALTER TABLE `telefone_funcionario`
  ADD PRIMARY KEY (`id_telefone_funcionario`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_cargo` (`id_cargo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `id_auditoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=276;

--
-- AUTO_INCREMENT de tabela `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `categoria_receita`
--
ALTER TABLE `categoria_receita`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `despesas_fixas`
--
ALTER TABLE `despesas_fixas`
  MODIFY `id_despesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `despesa_produto`
--
ALTER TABLE `despesa_produto`
  MODIFY `id_despesa_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `despesa_variados`
--
ALTER TABLE `despesa_variados`
  MODIFY `id_despesa_variados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `endereco_funcionario`
--
ALTER TABLE `endereco_funcionario`
  MODIFY `id_endereco_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
  MODIFY `id_forma_pagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `receita`
--
ALTER TABLE `receita`
  MODIFY `id_receita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `sabor_produto`
--
ALTER TABLE `sabor_produto`
  MODIFY `id_sabor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `telefone`
--
ALTER TABLE `telefone`
  MODIFY `id_telefone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `telefone_funcionario`
--
ALTER TABLE `telefone_funcionario`
  MODIFY `id_telefone_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `despesas_fixas`
--
ALTER TABLE `despesas_fixas`
  ADD CONSTRAINT `despesas_fixas_ibfk_1` FOREIGN KEY (`id_forma_pagamento`) REFERENCES `formas_pagamento` (`id_forma_pagamento`);

--
-- Restrições para tabelas `despesa_produto`
--
ALTER TABLE `despesa_produto`
  ADD CONSTRAINT `fk_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id`);

--
-- Restrições para tabelas `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `endereco_funcionario`
--
ALTER TABLE `endereco_funcionario`
  ADD CONSTRAINT `endereco_funcionario_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Restrições para tabelas `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`);

--
-- Restrições para tabelas `receita`
--
ALTER TABLE `receita`
  ADD CONSTRAINT `receita_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_receita` (`id_categoria`),
  ADD CONSTRAINT `receita_ibfk_2` FOREIGN KEY (`id_sabor`) REFERENCES `sabor_produto` (`id_sabor`),
  ADD CONSTRAINT `receita_ibfk_3` FOREIGN KEY (`id_forma_pagamento`) REFERENCES `formas_pagamento` (`id_forma_pagamento`);

--
-- Restrições para tabelas `telefone`
--
ALTER TABLE `telefone`
  ADD CONSTRAINT `telefone_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `telefone_funcionario`
--
ALTER TABLE `telefone_funcionario`
  ADD CONSTRAINT `telefone_funcionario_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
