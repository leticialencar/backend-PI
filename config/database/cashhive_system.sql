-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14/05/2025 às 00:14
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
-- Estrutura para tabela `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL,
  `nome_cargo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria_receita`
--

CREATE TABLE `categoria_receita` (
  `id_categoria` int(11) NOT NULL,
  `nome_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `despesa_agua`
--

CREATE TABLE `despesa_agua` (
  `id_despesa_agua` int(11) NOT NULL,
  `data_conta` date NOT NULL,
  `data_pagamento` date NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `despesa_energia`
--

CREATE TABLE `despesa_energia` (
  `id_despesa_ener` int(11) NOT NULL,
  `data_conta` date NOT NULL,
  `data_pagamento` date NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `despesa_funcionario`
--

CREATE TABLE `despesa_funcionario` (
  `id_despesa_func` int(11) NOT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `nome_despesa` varchar(255) NOT NULL,
  `data_pagamento` date NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `data_nasc` date NOT NULL,
  `total_despesa` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `despesa_internet`
--

CREATE TABLE `despesa_internet` (
  `id_despesa_internet` int(11) NOT NULL,
  `data_conta` date NOT NULL,
  `data_pagamento` date NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `validade` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `despesa_variados`
--

CREATE TABLE `despesa_variados` (
  `id_despesa_variados` int(11) NOT NULL,
  `data_conta` date NOT NULL,
  `data_pagamento` date NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estrutura para tabela `pgto_receita`
--

CREATE TABLE `pgto_receita` (
  `id_pgto_receita` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `receita`
--

CREATE TABLE `receita` (
  `id_venda` int(11) NOT NULL,
  `data_venda` date NOT NULL,
  `nome_cliente` varchar(100) NOT NULL,
  `nome_produto` varchar(100) NOT NULL,
  `qtd_produto` int(11) NOT NULL,
  `val_unitario` decimal(10,2) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `total_receita` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `tipo_usuario` enum('admin','comum') DEFAULT 'comum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome_usuario`, `cpf_usuario`, `cnpj_usuario`, `senha_usuario`, `email_usuario`, `data_adicao`, `tipo_usuario`) VALUES
(1, 'Administrador', NULL, '12.345.678/0001-00', 'admin', 'maria.silvalencars@gmail.com', '2025-04-30', 'admin'),
(2, 'Leticia', '12345678900', NULL, 'teste123', 'maria.silvalencars@gmail.com', '2025-05-11', 'comum');

--
-- Índices para tabelas despejadas
--

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
-- Índices de tabela `despesa_agua`
--
ALTER TABLE `despesa_agua`
  ADD PRIMARY KEY (`id_despesa_agua`);

--
-- Índices de tabela `despesa_energia`
--
ALTER TABLE `despesa_energia`
  ADD PRIMARY KEY (`id_despesa_ener`);

--
-- Índices de tabela `despesa_funcionario`
--
ALTER TABLE `despesa_funcionario`
  ADD PRIMARY KEY (`id_despesa_func`),
  ADD KEY `id_cargo` (`id_cargo`);

--
-- Índices de tabela `despesa_internet`
--
ALTER TABLE `despesa_internet`
  ADD PRIMARY KEY (`id_despesa_internet`);

--
-- Índices de tabela `despesa_produto`
--
ALTER TABLE `despesa_produto`
  ADD PRIMARY KEY (`id_despesa_prod`);

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
-- Índices de tabela `pgto_receita`
--
ALTER TABLE `pgto_receita`
  ADD PRIMARY KEY (`id_pgto_receita`);

--
-- Índices de tabela `receita`
--
ALTER TABLE `receita`
  ADD PRIMARY KEY (`id_venda`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Índices de tabela `telefone`
--
ALTER TABLE `telefone`
  ADD PRIMARY KEY (`id_telefone`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categoria_receita`
--
ALTER TABLE `categoria_receita`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `despesa_agua`
--
ALTER TABLE `despesa_agua`
  MODIFY `id_despesa_agua` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `despesa_energia`
--
ALTER TABLE `despesa_energia`
  MODIFY `id_despesa_ener` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `despesa_funcionario`
--
ALTER TABLE `despesa_funcionario`
  MODIFY `id_despesa_func` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `despesa_internet`
--
ALTER TABLE `despesa_internet`
  MODIFY `id_despesa_internet` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `despesa_produto`
--
ALTER TABLE `despesa_produto`
  MODIFY `id_despesa_prod` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `despesa_variados`
--
ALTER TABLE `despesa_variados`
  MODIFY `id_despesa_variados` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `pgto_receita`
--
ALTER TABLE `pgto_receita`
  MODIFY `id_pgto_receita` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `receita`
--
ALTER TABLE `receita`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `telefone`
--
ALTER TABLE `telefone`
  MODIFY `id_telefone` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `despesa_funcionario`
--
ALTER TABLE `despesa_funcionario`
  ADD CONSTRAINT `despesa_funcionario_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`);

--
-- Restrições para tabelas `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `receita`
--
ALTER TABLE `receita`
  ADD CONSTRAINT `receita_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_receita` (`id_categoria`);

--
-- Restrições para tabelas `telefone`
--
ALTER TABLE `telefone`
  ADD CONSTRAINT `telefone_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
