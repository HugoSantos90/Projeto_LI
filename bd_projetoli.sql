-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Dez-2025 às 17:40
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_projetoli`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `equipas`
--

CREATE TABLE `equipas` (
  `id_equipa` int(11) NOT NULL,
  `nome_equipa` varchar(100) NOT NULL,
  `escudo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `equipas`
--

INSERT INTO `equipas` (`id_equipa`, `nome_equipa`, `escudo`) VALUES
(1, 'benfica', NULL),
(2, 'Porto', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogos`
--

CREATE TABLE `jogos` (
  `id_jogo` int(11) NOT NULL,
  `id_liga` int(11) NOT NULL,
  `equipa_casa` int(11) NOT NULL,
  `equipa_fora` int(11) NOT NULL,
  `golos_casa` int(11) DEFAULT 0,
  `golos_fora` int(11) DEFAULT 0,
  `data_jogo` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `jogos`
--

INSERT INTO `jogos` (`id_jogo`, `id_liga`, `equipa_casa`, `equipa_fora`, `golos_casa`, `golos_fora`, `data_jogo`) VALUES
(1, 1, 1, 2, 0, 0, '2025-12-11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ligas`
--

CREATE TABLE `ligas` (
  `id_liga` int(11) NOT NULL,
  `nome_liga` varchar(100) NOT NULL,
  `epoca` int(11) NOT NULL,
  `id_utilizador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `ligas`
--

INSERT INTO `ligas` (`id_liga`, `nome_liga`, `epoca`, `id_utilizador`) VALUES
(1, 'Liga teste', 2025, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ligas_equipas`
--

CREATE TABLE `ligas_equipas` (
  `id_liga_equipas` int(11) NOT NULL,
  `id_liga` int(11) NOT NULL,
  `id_equipa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `ligas_equipas`
--

INSERT INTO `ligas_equipas` (`id_liga_equipas`, `id_liga`, `id_equipa`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `id_utilizador` int(11) NOT NULL,
  `nome_utilizador` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `palavra_passe` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`id_utilizador`, `nome_utilizador`, `email`, `palavra_passe`) VALUES
(1, 'admin', 'admin', 'admin');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `equipas`
--
ALTER TABLE `equipas`
  ADD PRIMARY KEY (`id_equipa`);

--
-- Índices para tabela `jogos`
--
ALTER TABLE `jogos`
  ADD PRIMARY KEY (`id_jogo`),
  ADD KEY `id_liga` (`id_liga`),
  ADD KEY `equipa_casa` (`equipa_casa`),
  ADD KEY `equipa_fora` (`equipa_fora`);

--
-- Índices para tabela `ligas`
--
ALTER TABLE `ligas`
  ADD PRIMARY KEY (`id_liga`),
  ADD KEY `id_utilizador` (`id_utilizador`);

--
-- Índices para tabela `ligas_equipas`
--
ALTER TABLE `ligas_equipas`
  ADD PRIMARY KEY (`id_liga_equipas`),
  ADD KEY `id_liga` (`id_liga`),
  ADD KEY `id_equipa` (`id_equipa`);

--
-- Índices para tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`id_utilizador`),
  ADD UNIQUE KEY `nome_utilizador` (`nome_utilizador`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `equipas`
--
ALTER TABLE `equipas`
  MODIFY `id_equipa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `jogos`
--
ALTER TABLE `jogos`
  MODIFY `id_jogo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `ligas`
--
ALTER TABLE `ligas`
  MODIFY `id_liga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `ligas_equipas`
--
ALTER TABLE `ligas_equipas`
  MODIFY `id_liga_equipas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id_utilizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `jogos`
--
ALTER TABLE `jogos`
  ADD CONSTRAINT `jogos_ibfk_1` FOREIGN KEY (`id_liga`) REFERENCES `ligas` (`id_liga`) ON DELETE CASCADE,
  ADD CONSTRAINT `jogos_ibfk_2` FOREIGN KEY (`equipa_casa`) REFERENCES `equipas` (`id_equipa`) ON DELETE CASCADE,
  ADD CONSTRAINT `jogos_ibfk_3` FOREIGN KEY (`equipa_fora`) REFERENCES `equipas` (`id_equipa`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `ligas`
--
ALTER TABLE `ligas`
  ADD CONSTRAINT `ligas_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id_utilizador`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `ligas_equipas`
--
ALTER TABLE `ligas_equipas`
  ADD CONSTRAINT `ligas_equipas_ibfk_1` FOREIGN KEY (`id_liga`) REFERENCES `ligas` (`id_liga`) ON DELETE CASCADE,
  ADD CONSTRAINT `ligas_equipas_ibfk_2` FOREIGN KEY (`id_equipa`) REFERENCES `equipas` (`id_equipa`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
