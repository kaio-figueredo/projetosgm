-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/06/2026 às 13:37
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
-- Banco de dados: `sgm_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `ambientes`
--

CREATE TABLE `ambientes` (
  `id_ambiente` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `id_bloco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `ambientes`
--

INSERT INTO `ambientes` (`id_ambiente`, `nome`, `id_bloco`) VALUES
(3, 'Linha 4', 3),
(5, 'TESTEEEE', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `blocos`
--

CREATE TABLE `blocos` (
  `id_bloco` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `blocos`
--

INSERT INTO `blocos` (`id_bloco`, `nome`, `descricao`) VALUES
(2, 'Produção', NULL),
(3, 'Bloco Administrativo 34', 'vsdvjs bdkvjsd vjksnvljsnbkldxl');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamados`
--

CREATE TABLE `chamados` (
  `id_chamado` int(11) NOT NULL,
  `descricao_problema` text NOT NULL,
  `data_abertura` datetime DEFAULT current_timestamp(),
  `status` enum('aberto','agendado','em_execucao','concluido','fechado','cancelado') DEFAULT 'aberto',
  `prioridade` enum('baixa','media','alta','urgente') DEFAULT 'baixa',
  `data_previsao_conclusao` date DEFAULT NULL,
  `solucao_tecnica` text DEFAULT NULL,
  `tempo_gasto_minutos` int(11) DEFAULT NULL,
  `data_fechamento` datetime DEFAULT NULL,
  `id_solicitante` int(11) NOT NULL,
  `id_tecnico` int(11) DEFAULT NULL,
  `id_ambiente` int(11) NOT NULL,
  `id_tipo_servico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `chamados`
--

INSERT INTO `chamados` (`id_chamado`, `descricao_problema`, `data_abertura`, `status`, `prioridade`, `data_previsao_conclusao`, `solucao_tecnica`, `tempo_gasto_minutos`, `data_fechamento`, `id_solicitante`, `id_tecnico`, `id_ambiente`, `id_tipo_servico`) VALUES
(1, 'ghergevebebbdfbdfbd', '2026-05-13 08:06:51', 'em_execucao', 'urgente', '2026-10-25', NULL, NULL, NULL, 3, 2, 3, 3),
(2, 'ggsbdbdbdbbfd', '2026-05-29 07:46:56', 'concluido', 'alta', '6258-09-04', NULL, NULL, NULL, 3, 2, 3, 3),
(3, 'mtmghngnhgngh', '2026-05-29 08:02:22', 'concluido', 'media', '5005-05-25', NULL, NULL, NULL, 3, 2, 5, 3),
(4, 'Problema no cano ', '2026-06-17 07:48:26', 'aberto', 'baixa', NULL, NULL, NULL, NULL, 3, NULL, 5, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamados_anexos`
--

CREATE TABLE `chamados_anexos` (
  `id_anexo` int(11) NOT NULL,
  `caminho_arquivo` varchar(255) NOT NULL,
  `tipo_anexo` enum('abertura','conclusao') NOT NULL,
  `data_upload` datetime DEFAULT current_timestamp(),
  `id_chamado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `chamados_anexos`
--

INSERT INTO `chamados_anexos` (`id_anexo`, `caminho_arquivo`, `tipo_anexo`, `data_upload`, `id_chamado`) VALUES
(1, 'assets/uploads/abertura_6a045b4b3554b.jpg', 'abertura', '2026-05-13 08:06:51', 1),
(2, 'assets/uploads/chamado_2_6a196ea08ed7b.jpg', 'abertura', '2026-05-29 07:46:56', 2),
(3, 'assets/uploads/chamado_3_6a19723e02e4b.jpg', 'abertura', '2026-05-29 08:02:22', 3),
(4, 'assets/uploads/chamado_4_6a327b7abe597.jpg', 'abertura', '2026-06-17 07:48:26', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamados_comentarios`
--

CREATE TABLE `chamados_comentarios` (
  `id_comentario` int(11) NOT NULL,
  `texto` text NOT NULL,
  `data_envio` datetime DEFAULT current_timestamp(),
  `id_chamado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipos_servico`
--

CREATE TABLE `tipos_servico` (
  `id_tipo` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tipos_servico`
--

INSERT INTO `tipos_servico` (`id_tipo`, `nome`, `descricao`) VALUES
(3, 'TESTEEEEE2', 'OIEEE'),
(6, 'TESTEEEEEEEEEE', 'vsbsfbdfbd'),
(10, 'TESTEEEE', 'bdfbdbsbfdb');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `perfil` enum('solicitante','tecnico','gestor') NOT NULL DEFAULT 'solicitante',
  `ativo` tinyint(1) DEFAULT 1,
  `data_criacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `senha_hash`, `perfil`, `ativo`, `data_criacao`) VALUES
(1, 'Admin Gestor', 'admin@sgm.com', '$2y$10$OWj1KJGo9RJzCHaPsY40fOifXqDfA7pYlj/1nAe5b7bpQaKhPjxCK', 'gestor', 1, '2026-05-13 07:49:02'),
(2, 'João Técnico', 'tecnico@sgm.com', '$2y$10$OWj1KJGo9RJzCHaPsY40fOifXqDfA7pYlj/1nAe5b7bpQaKhPjxCK', 'tecnico', 1, '2026-05-13 07:49:02'),
(3, 'Maria Solicitante', 'usuario@sgm.com', '$2y$10$OWj1KJGo9RJzCHaPsY40fOifXqDfA7pYlj/1nAe5b7bpQaKhPjxCK', 'solicitante', 1, '2026-05-13 07:49:02'),
(4, 'Lanna Andrade', 'lanna@sgm.com', '$2y$10$y1mAzDyi9KaihDbbysVQ0OcynZxWfiTNScT.vVmJLBEBryWa/9Fm6', 'solicitante', 1, '2026-05-13 08:45:41'),
(6, 'Kaio Gabriel ', 'test@sgm.com', '$2y$10$7bJ8iart2vQlepWbmqRRkuoz6GKEdtZo2sk3nx1hS.XubWajJFmDC', 'solicitante', 1, '2026-05-13 08:52:14'),
(10, 'Lanna Andrade', 'llanna@email.com', '$2y$10$uc6HAfOQfXXbhN6h.a56.ePi/j12ywHyTWQXbNJBgTGaRGRi71//W', 'gestor', 1, '2026-05-13 10:44:53'),
(11, 'Gilmara', 'gilmara@sgm.com', '$2y$10$nXz1l3bkfYJ3IaPli8Kn7uMUkHXKsM/z3eFiv7D0zgVUHcCd7KzFm', 'solicitante', 1, '2026-06-17 07:53:32'),
(12, 'Nilo', 'nilo@sgm.com', '$2y$10$zEYFPWs3l/ZcHBSLoK4A5e2ZcyfZ.TFG1BddgxPusycUnzuSVb60G', 'solicitante', 1, '2026-06-17 07:54:40'),
(13, 'Murilo', 'murilo@sgm.com', '$2y$10$v0gLxLrxfNVjyMTapRNIz.fabBz4CrinMfhv/oKEWa0VG/SBDH/de', 'tecnico', 1, '2026-06-17 07:56:42');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `ambientes`
--
ALTER TABLE `ambientes`
  ADD PRIMARY KEY (`id_ambiente`),
  ADD KEY `fk_ambientes_blocos` (`id_bloco`);

--
-- Índices de tabela `blocos`
--
ALTER TABLE `blocos`
  ADD PRIMARY KEY (`id_bloco`);

--
-- Índices de tabela `chamados`
--
ALTER TABLE `chamados`
  ADD PRIMARY KEY (`id_chamado`),
  ADD KEY `fk_chamados_solicitante` (`id_solicitante`),
  ADD KEY `fk_chamados_tecnico` (`id_tecnico`),
  ADD KEY `fk_chamados_ambiente` (`id_ambiente`),
  ADD KEY `fk_chamados_tipo` (`id_tipo_servico`);

--
-- Índices de tabela `chamados_anexos`
--
ALTER TABLE `chamados_anexos`
  ADD PRIMARY KEY (`id_anexo`),
  ADD KEY `fk_anexos_chamados` (`id_chamado`);

--
-- Índices de tabela `chamados_comentarios`
--
ALTER TABLE `chamados_comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `fk_comentarios_chamado` (`id_chamado`),
  ADD KEY `fk_comentarios_usuario` (`id_usuario`);

--
-- Índices de tabela `tipos_servico`
--
ALTER TABLE `tipos_servico`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `idx_email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `ambientes`
--
ALTER TABLE `ambientes`
  MODIFY `id_ambiente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `blocos`
--
ALTER TABLE `blocos`
  MODIFY `id_bloco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `chamados`
--
ALTER TABLE `chamados`
  MODIFY `id_chamado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `chamados_anexos`
--
ALTER TABLE `chamados_anexos`
  MODIFY `id_anexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `chamados_comentarios`
--
ALTER TABLE `chamados_comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tipos_servico`
--
ALTER TABLE `tipos_servico`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `ambientes`
--
ALTER TABLE `ambientes`
  ADD CONSTRAINT `fk_ambientes_blocos` FOREIGN KEY (`id_bloco`) REFERENCES `blocos` (`id_bloco`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `chamados`
--
ALTER TABLE `chamados`
  ADD CONSTRAINT `fk_chamados_ambiente` FOREIGN KEY (`id_ambiente`) REFERENCES `ambientes` (`id_ambiente`),
  ADD CONSTRAINT `fk_chamados_solicitante` FOREIGN KEY (`id_solicitante`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `fk_chamados_tecnico` FOREIGN KEY (`id_tecnico`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_chamados_tipo` FOREIGN KEY (`id_tipo_servico`) REFERENCES `tipos_servico` (`id_tipo`);

--
-- Restrições para tabelas `chamados_anexos`
--
ALTER TABLE `chamados_anexos`
  ADD CONSTRAINT `fk_anexos_chamados` FOREIGN KEY (`id_chamado`) REFERENCES `chamados` (`id_chamado`) ON DELETE CASCADE;

--
-- Restrições para tabelas `chamados_comentarios`
--
ALTER TABLE `chamados_comentarios`
  ADD CONSTRAINT `fk_comentarios_chamado` FOREIGN KEY (`id_chamado`) REFERENCES `chamados` (`id_chamado`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comentarios_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
