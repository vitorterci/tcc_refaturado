-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21/09/2026 às 13:04
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
-- Banco de dados: `tcc`
--
CREATE DATABASE IF NOT EXISTS `tcc` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `tcc`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tipo_feedback` enum('sugestao','reclamacao','elogio','duvida') NOT NULL DEFAULT 'sugestao',
  `mensagem` text NOT NULL,
  `avaliacao` int(11) NOT NULL DEFAULT 5,
  `status` enum('pendente','novo','lido','respondido') NOT NULL DEFAULT 'pendente',
  `data_envio` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `generos`
--

DROP TABLE IF EXISTS `generos`;
CREATE TABLE `generos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `generos`
--

INSERT INTO `generos` (`id`, `nome`, `slug`, `data_cadastro`) VALUES
(1, 'Action RPG', 'action-rpg', '2026-09-18 18:23:04'),
(2, 'Action Adventure', 'action-adventure', '2026-09-18 18:23:04'),
(3, 'CRPG', 'crpg', '2026-09-18 18:23:04'),
(4, 'Metroidvania', 'metroidvania', '2026-09-18 18:23:04'),
(5, 'Roguelike', 'roguelike', '2026-09-18 18:23:04'),
(6, 'Platformer', 'platformer', '2026-09-18 18:23:04'),
(7, 'Simulation', 'simulation', '2026-09-18 18:23:04'),
(8, 'Sandbox', 'sandbox', '2026-09-18 18:23:04'),
(9, 'Survival Horror', 'survival-horror', '2026-09-18 18:23:04'),
(10, 'JRPG', 'jrpg', '2026-09-18 18:23:04'),
(11, 'Run and Gun', 'run-and-gun', '2026-09-18 18:23:04'),
(12, 'Co-op Adventure', 'co-op-adventure', '2026-09-18 18:23:04'),
(13, 'Soulslike', 'soulslike', '2026-09-18 18:23:04'),
(14, 'FPS', 'fps', '2026-09-18 18:23:04'),
(15, 'Estratégia', 'estrategia', '2026-09-18 18:23:04');

-- --------------------------------------------------------

--
-- Estrutura para tabela `jogos`
--

DROP TABLE IF EXISTS `jogos`;
CREATE TABLE `jogos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(150) NOT NULL,
  `slug` varchar(180) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `plataforma` varchar(255) DEFAULT NULL,
  `genero` varchar(255) DEFAULT NULL,
  `ano` int(11) DEFAULT NULL,
  `etaria` varchar(10) DEFAULT NULL,
  `status` enum('ativo','inativo') NOT NULL DEFAULT 'ativo',
  `avaliacao_gamplay` decimal(3,1) NOT NULL DEFAULT 0.0,
  `avaliacao_graficos` decimal(3,1) NOT NULL DEFAULT 0.0,
  `avaliacao_historia` decimal(3,1) NOT NULL DEFAULT 0.0,
  `data_lancamento` date DEFAULT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `jogo_genero`
--

DROP TABLE IF EXISTS `jogo_genero`;
CREATE TABLE `jogo_genero` (
  `jogo_id` int(10) UNSIGNED NOT NULL,
  `genero_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `jogo_plataforma`
--

DROP TABLE IF EXISTS `jogo_plataforma`;
CREATE TABLE `jogo_plataforma` (
  `jogo_id` int(10) UNSIGNED NOT NULL,
  `plataforma_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `plataformas`
--

DROP TABLE IF EXISTS `plataformas`;
CREATE TABLE `plataformas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `plataformas`
--

INSERT INTO `plataformas` (`id`, `nome`, `slug`, `data_cadastro`) VALUES
(1, 'PC', 'pc', '2026-09-18 18:23:04'),
(2, 'PS5', 'ps5', '2026-09-18 18:23:04'),
(3, 'PS4', 'ps4', '2026-09-18 18:23:04'),
(4, 'Xbox Series', 'xbox-series', '2026-09-18 18:23:04'),
(5, 'Xbox One', 'xbox-one', '2026-09-18 18:23:04'),
(6, 'Nintendo Switch', 'nintendo-switch', '2026-09-18 18:23:04'),
(7, 'Mobile', 'mobile', '2026-09-18 18:23:04');

-- --------------------------------------------------------

--
-- Estrutura para tabela `precos`
--

DROP TABLE IF EXISTS `precos`;
CREATE TABLE `precos` (
  `id` int(10) UNSIGNED NOT NULL,
  `jogo_id` int(10) UNSIGNED NOT NULL,
  `loja` varchar(100) NOT NULL,
  `plataforma` varchar(100) DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL DEFAULT 0.00,
  `preco_antigo` decimal(10,2) DEFAULT NULL,
  `desconto` decimal(5,2) NOT NULL DEFAULT 0.00,
  `desconto_percentual` decimal(5,2) NOT NULL DEFAULT 0.00,
  `moeda` char(3) NOT NULL DEFAULT 'BRL',
  `disponibilidade` enum('disponivel','indisponivel') NOT NULL DEFAULT 'disponivel',
  `url` varchar(255) DEFAULT NULL,
  `url_oferta` varchar(500) DEFAULT NULL,
  `disponivel` tinyint(1) NOT NULL DEFAULT 1,
  `data_atualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `role` enum('usuario','admin') NOT NULL DEFAULT 'usuario',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `preferencias_cor` varchar(20) DEFAULT NULL,
  `preferencias_animacoes` tinyint(1) NOT NULL DEFAULT 0,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `email`, `senha`, `role`, `ativo`, `foto_perfil`, `preferencias_cor`, `preferencias_animacoes`, `data_cadastro`, `data_atualizacao`) VALUES
(1, '1', '1', '123@gmail.com', '$2y$10$Zbji9u8VFowXIm3aVA0SgOo6NtqIZeL/ZqbPW7FEyu9Vjw9W6n9IK', 'admin', 1, 'uploads/perfil/usuario_1_1db960969bab959c38dad325.png', NULL, 0, '2026-09-18 16:13:20', '2026-09-18 16:26:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_jogos`
--

DROP TABLE IF EXISTS `usuario_jogos`;
CREATE TABLE `usuario_jogos` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `jogo_id` int(10) UNSIGNED NOT NULL,
  `status` enum('possuo','jogando','zerado','abandonado') DEFAULT 'possuo',
  `data_adicionado` datetime DEFAULT current_timestamp(),
  `data_atualizacao` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_lista`
--

DROP TABLE IF EXISTS `usuario_lista`;
CREATE TABLE `usuario_lista` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `jogo_id` int(10) UNSIGNED NOT NULL,
  `notificar_promocao` tinyint(1) DEFAULT 1,
  `notificar_preco` tinyint(1) DEFAULT 1,
  `preco_alvo` decimal(10,2) DEFAULT NULL,
  `desconto_minimo` decimal(5,2) DEFAULT NULL,
  `data_adicionado` datetime DEFAULT current_timestamp(),
  `data_atualizacao` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_preferencias`
--

DROP TABLE IF EXISTS `usuario_preferencias`;
CREATE TABLE `usuario_preferencias` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `desconto_minimo` decimal(5,2) DEFAULT 0.00,
  `preco_maximo` decimal(10,2) DEFAULT NULL,
  `notificar_promocoes` tinyint(1) DEFAULT 1,
  `notificar_queda_preco` tinyint(1) DEFAULT 1,
  `plataformas_interesse` text DEFAULT NULL,
  `generos_interesse` text DEFAULT NULL,
  `lojas_interesse` text DEFAULT NULL,
  `data_atualizacao` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `idx_feedback_status` (`status`);

--
-- Índices de tabela `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_generos_slug` (`slug`);

--
-- Índices de tabela `jogos`
--
ALTER TABLE `jogos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_slug` (`slug`),
  ADD KEY `idx_jogos_status` (`status`);

--
-- Índices de tabela `jogo_genero`
--
ALTER TABLE `jogo_genero`
  ADD PRIMARY KEY (`jogo_id`,`genero_id`),
  ADD KEY `idx_jg_genero` (`genero_id`);

--
-- Índices de tabela `jogo_plataforma`
--
ALTER TABLE `jogo_plataforma`
  ADD PRIMARY KEY (`jogo_id`,`plataforma_id`),
  ADD KEY `idx_jp_plataforma` (`plataforma_id`);

--
-- Índices de tabela `plataformas`
--
ALTER TABLE `plataformas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_plataformas_slug` (`slug`);

--
-- Índices de tabela `precos`
--
ALTER TABLE `precos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_precos_jogo` (`jogo_id`),
  ADD KEY `idx_precos_disponibilidade` (`disponibilidade`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_usuario` (`usuario`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Índices de tabela `usuario_jogos`
--
ALTER TABLE `usuario_jogos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_usuario_jogo` (`usuario_id`,`jogo_id`),
  ADD KEY `jogo_id` (`jogo_id`);

--
-- Índices de tabela `usuario_lista`
--
ALTER TABLE `usuario_lista`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_usuario_lista` (`usuario_id`,`jogo_id`),
  ADD KEY `jogo_id` (`jogo_id`);

--
-- Índices de tabela `usuario_preferencias`
--
ALTER TABLE `usuario_preferencias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_usuario_preferencias` (`usuario_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `jogos`
--
ALTER TABLE `jogos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `plataformas`
--
ALTER TABLE `plataformas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `precos`
--
ALTER TABLE `precos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuario_jogos`
--
ALTER TABLE `usuario_jogos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_lista`
--
ALTER TABLE `usuario_lista`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_preferencias`
--
ALTER TABLE `usuario_preferencias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `jogo_genero`
--
ALTER TABLE `jogo_genero`
  ADD CONSTRAINT `fk_jg_genero` FOREIGN KEY (`genero_id`) REFERENCES `generos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_jg_jogo` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `jogo_plataforma`
--
ALTER TABLE `jogo_plataforma`
  ADD CONSTRAINT `fk_jp_jogo` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_jp_plataforma` FOREIGN KEY (`plataforma_id`) REFERENCES `plataformas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `precos`
--
ALTER TABLE `precos`
  ADD CONSTRAINT `precos_ibfk_1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuario_jogos`
--
ALTER TABLE `usuario_jogos`
  ADD CONSTRAINT `usuario_jogos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuario_jogos_ibfk_2` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuario_lista`
--
ALTER TABLE `usuario_lista`
  ADD CONSTRAINT `usuario_lista_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuario_lista_ibfk_2` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuario_preferencias`
--
ALTER TABLE `usuario_preferencias`
  ADD CONSTRAINT `usuario_preferencias_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
USE tcc;

INSERT INTO jogos
(
    nome,
    slug,
    descricao,
    img,
    categoria,
    plataforma,
    genero,
    ano,
    etaria,
    status,
    avaliacao_gamplay,
    avaliacao_graficos,
    avaliacao_historia,
    data_lancamento
)
VALUES

(
    'Alan Wake 2',
    'alan-wake-2',
    'Survival horror narrativo da Remedy Entertainment que acompanha o escritor Alan Wake e a agente do FBI Saga Anderson em uma investigação sobrenatural.',
    'games/alan-wake-2.webp',
    'Survival Horror',
    'PC, PS5, Xbox Series',
    'Survival Horror',
    2023,
    '18',
    'ativo',
    0.0, 0.0, 0.0,
    '2023-10-27'
),

(
    'Baldur''s Gate 3',
    'baldurs-gate-3',
    'RPG baseado no universo de Dungeons & Dragons, com exploração, combate por turnos, escolhas narrativas e grande liberdade de criação de personagens.',
    'games/baldurs-gate-3.webp',
    'CRPG',
    'PC, PS5, Xbox Series',
    'CRPG',
    2023,
    '14',
    'ativo',
    0.0, 0.0, 0.0,
    '2023-08-03'
),

(
    'Bloodborne',
    'bloodborne',
    'Action RPG ambientado na cidade gótica de Yharnam, onde o jogador assume o papel de um Caçador durante uma misteriosa noite de caça.',
    'games/bloodborne.webp',
    'Action RPG',
    'PS4',
    'Action RPG',
    2015,
    '16',
    'ativo',
    0.0, 0.0, 0.0,
    '2015-03-24'
),

(
    'Celeste',
    'celeste',
    'Plataforma de precisão que acompanha Madeline durante sua escalada da Montanha Celeste, combinando desafios de movimentação com uma narrativa pessoal.',
    'games/celeste.webp',
    'Platformer',
    'PC, PS4, Xbox One, Switch',
    'Platformer',
    2018,
    '10',
    'ativo',
    0.0, 0.0, 0.0,
    '2018-01-25'
),

(
    'Cuphead',
    'cuphead',
    'Run and gun inspirado em animações dos anos 1930, conhecido por batalhas contra chefes, visual desenhado à mão e trilha sonora de jazz.',
    'games/cuphead.webp',
    'Run and Gun',
    'PC, PS4, Xbox One, Switch',
    'Run and Gun',
    2017,
    'L',
    'ativo',
    0.0, 0.0, 0.0,
    '2017-09-29'
),

(
    'Cyberpunk 2077',
    'cyberpunk-2077',
    'RPG de ação em mundo aberto ambientado em Night City, onde o mercenário V busca construir sua própria história em uma sociedade dominada por tecnologia e megacorporações.',
    'games/cyberpunk-2077.webp',
    'Action RPG',
    'PC, PS5, Xbox Series, PS4, Xbox One',
    'Action RPG',
    2020,
    '18',
    'ativo',
    0.0, 0.0, 0.0,
    '2020-12-10'
),

(
    'Dark Souls III',
    'dark-souls-3',
    'Action RPG da FromSoftware ambientado no decadente reino de Lothric, com combate desafiador, exploração e narrativa construída através do mundo do jogo.',
    'games/dark-souls-3.webp',
    'Action RPG',
    'PC, PS4, Xbox One',
    'Soulslike',
    2016,
    '16',
    'ativo',
    0.0, 0.0, 0.0,
    '2016-03-24'
),

(
    'Elden Ring',
    'elden-ring',
    'Action RPG de mundo aberto desenvolvido pela FromSoftware, ambientado nas Terras Intermédias e focado em exploração, combate e construção livre de personagem.',
    'games/elden-ring.webp',
    'Action RPG',
    'PC, PS4, PS5, Xbox One, Xbox Series',
    'Soulslike',
    2022,
    '16',
    'ativo',
    0.0, 0.0, 0.0,
    '2022-02-25'
),

(
    'Final Fantasy XVI',
    'final-fantasy-xvi',
    'RPG de ação da série Final Fantasy ambientado em Valisthea, acompanhando Clive Rosfield em uma história marcada pelos Dominantes e pelos Eikons.',
    'games/final-fantasy-xvi.webp',
    'Action RPG',
    'PS5, PC',
    'Action RPG',
    2023,
    '16',
    'ativo',
    0.0, 0.0, 0.0,
    '2023-06-22'
),

(
    'Ghost of Tsushima',
    'ghost-of-tsushima',
    'Aventura de ação em mundo aberto ambientada na ilha de Tsushima durante a invasão mongol, combinando combate com espada, arco e furtividade.',
    'games/ghost-of-tsushima.webp',
    'Action Adventure',
    'PS4, PS5, PC',
    'Action Adventure',
    2020,
    '16',
    'ativo',
    0.0, 0.0, 0.0,
    '2020-07-17'
),

(
    'God of War Ragnarök',
    'god-of-war-ragnarok',
    'Aventura de ação que acompanha Kratos e Atreus durante os acontecimentos que antecedem o Ragnarök nos Nove Reinos da mitologia nórdica.',
    'games/god-of-war-ragnarok.webp',
    'Action Adventure',
    'PS4, PS5, PC',
    'Action Adventure',
    2022,
    '18',
    'ativo',
    0.0, 0.0, 0.0,
    '2022-11-09'
),

(
    'Grand Theft Auto V',
    'gta-v',
    'Jogo de ação em mundo aberto ambientado em Los Santos, acompanhando três protagonistas envolvidos em crimes, perseguições e grandes golpes.',
    'games/gta-v.webp',
    'Sandbox',
    'PC, PS4, PS5, Xbox One, Xbox Series',
    'Sandbox',
    2013,
    '18',
    'ativo',
    0.0, 0.0, 0.0,
    '2013-09-17'
),

(
    'Hades',
    'hades',
    'Roguelike de ação da Supergiant Games no qual Zagreus tenta escapar do submundo enfrentando inimigos e chefes enquanto descobre novas partes da história.',
    'games/hades.webp',
    'Roguelike',
    'PC, PS4, PS5, Xbox One, Xbox Series, Switch',
    'Roguelike',
    2020,
    '12',
    'ativo',
    0.0, 0.0, 0.0,
    '2020-09-17'
),

(
    'Hollow Knight',
    'hollow-knight',
    'Metroidvania de ação ambientado no reino subterrâneo de Hallownest, combinando exploração, combate, chefes e descoberta de habilidades.',
    'games/hollow-knight.webp',
    'Metroidvania',
    'PC, PS4, Xbox One, Switch',
    'Metroidvania',
    2017,
    '10',
    'ativo',
    0.0, 0.0, 0.0,
    '2017-02-24'
),

(
    'Horizon Forbidden West',
    'horizon-forbidden-west',
    'Aventura de ação em mundo aberto que acompanha Aloy em uma jornada por uma região pós-apocalíptica dominada por máquinas.',
    'games/horizon-forbidden-west.webp',
    'Action Adventure',
    'PS4, PS5, PC',
    'Action Adventure',
    2022,
    '14',
    'ativo',
    0.0, 0.0, 0.0,
    '2022-02-18'
),

(
    'It Takes Two',
    'it-takes-two',
    'Aventura cooperativa criada especificamente para dois jogadores, combinando plataforma, quebra-cabeças, ação e diferentes mecânicas ao longo da jornada.',
    'games/it-takes-two.webp',
    'Co-op Adventure',
    'PC, PS4, PS5, Xbox One, Xbox Series, Switch',
    'Co-op Adventure',
    2021,
    '10',
    'ativo',
    0.0, 0.0, 0.0,
    '2021-03-25'
),

(
    'Minecraft',
    'minecraft',
    'Jogo sandbox baseado em exploração, coleta de recursos, construção e sobrevivência em mundos gerados proceduralmente.',
    'games/minecraft.webp',
    'Sandbox',
    'PC, PS4, PS5, Xbox One, Xbox Series, Switch, Mobile',
    'Sandbox',
    2011,
    'L',
    'ativo',
    0.0, 0.0, 0.0,
    '2011-11-18'
),

(
    'NieR: Automata',
    'nier-automata',
    'RPG de ação ambientado em uma Terra devastada por máquinas, acompanhando os androides 2B, 9S e A2.',
    'games/nier-automata.webp',
    'Action RPG',
    'PC, PS4, Xbox One',
    'Action RPG',
    2017,
    '14',
    'ativo',
    0.0, 0.0, 0.0,
    '2017-02-23'
),

(
    'Ori and the Will of the Wisps',
    'ori-and-the-will-of-the-wisps',
    'Aventura de plataforma e exploração em estilo Metroidvania, com combate, habilidades de movimentação e um mundo interconectado.',
    'games/ori-and-the-will-of-the-wisps.webp',
    'Metroidvania',
    'PC, Xbox One, Xbox Series, Switch',
    'Metroidvania',
    2020,
    'L',
    'ativo',
    0.0, 0.0, 0.0,
    '2020-03-11'
),

(
    'Persona 5 Royal',
    'persona-5-royal',
    'JRPG que combina vida escolar, relacionamentos e exploração de masmorras, acompanhando os Phantom Thieves em uma história sobrenatural.',
    'games/persona-5-royal.webp',
    'JRPG',
    'PS4, PS5, Xbox One, Xbox Series, Switch, PC',
    'JRPG',
    2019,
    '16',
    'ativo',
    0.0, 0.0, 0.0,
    '2019-10-31'
),

(
    'Red Dead Redemption 2',
    'red-dead-redemption-2',
    'Aventura de ação em mundo aberto ambientada no Velho Oeste, acompanhando Arthur Morgan e a gangue Van der Linde.',
    'games/red-dead-redemption-2.webp',
    'Action Adventure',
    'PC, PS4, Xbox One',
    'Action Adventure',
    2018,
    '18',
    'ativo',
    0.0, 0.0, 0.0,
    '2018-10-26'
),

(
    'Resident Evil 4',
    'resident-evil-4-remake',
    'Remake do survival horror de ação em que Leon S. Kennedy é enviado para uma região rural da Europa em uma missão para resgatar Ashley Graham.',
    'games/resident-evil-4-remake.webp',
    'Survival Horror',
    'PC, PS4, PS5, Xbox Series',
    'Survival Horror',
    2023,
    '18',
    'ativo',
    0.0, 0.0, 0.0,
    '2023-03-24'
),

(
    'Sekiro: Shadows Die Twice',
    'sekiro',
    'Action RPG de ação desenvolvido pela FromSoftware, centrado em combate com espada, furtividade e habilidades de um shinobi.',
    'games/sekiro.webp',
    'Action RPG',
    'PC, PS4, Xbox One',
    'Soulslike',
    2019,
    '16',
    'ativo',
    0.0, 0.0, 0.0,
    '2019-03-22'
),

(
    'Marvel''s Spider-Man 2',
    'spider-man-2',
    'Aventura de ação em mundo aberto que coloca Peter Parker e Miles Morales contra novas ameaças em Nova York.',
    'games/spider-man-2.webp',
    'Action Adventure',
    'PS5, PC',
    'Action Adventure',
    2023,
    '12',
    'ativo',
    0.0, 0.0, 0.0,
    '2023-10-20'
),

(
    'Stardew Valley',
    'stardew-valley',
    'Simulação de fazenda com exploração, agricultura, pesca, criação de animais, relacionamentos e descoberta de uma comunidade rural.',
    'games/stardew-valley.webp',
    'Simulation',
    'PC, PS4, Xbox One, Switch, Mobile',
    'Simulation',
    2016,
    'L',
    'ativo',
    0.0, 0.0, 0.0,
    '2016-02-26'
),

(
    'Starfield',
    'starfield',
    'RPG espacial da Bethesda ambientado em um universo futurista de exploração, descoberta, combate espacial e personalização de personagens.',
    'games/starfield.webp',
    'CRPG',
    'PC, Xbox Series',
    'CRPG',
    2023,
    '16',
    'ativo',
    0.0, 0.0, 0.0,
    '2023-09-06'
),

(
    'Terraria',
    'terraria',
    'Sandbox de aventura em 2D focado em exploração, mineração, construção, criação de equipamentos e combate contra inimigos e chefes.',
    'games/terraria.webp',
    'Sandbox',
    'PC, PS4, Xbox One, Switch, Mobile',
    'Sandbox',
    2011,
    '12',
    'ativo',
    0.0, 0.0, 0.0,
    '2011-05-16'
),

(
    'The Last of Us Part II',
    'the-last-of-us-part-ii',
    'Aventura de ação narrativa ambientada em um mundo pós-apocalíptico, acompanhando Ellie em uma jornada marcada por conflitos e sobrevivência.',
    'games/the-last-of-us-part-ii.webp',
    'Action Adventure',
    'PS4, PS5',
    'Action Adventure',
    2020,
    '18',
    'ativo',
    0.0, 0.0, 0.0,
    '2020-06-19'
),

(
    'The Legend of Zelda: Tears of the Kingdom',
    'the-legend-of-zelda-totk',
    'Aventura de ação em mundo aberto que expande Hyrule para ilhas celestes e regiões subterrâneas, com novas habilidades de exploração e construção.',
    'games/the-legend-of-zelda-totk.webp',
    'Action Adventure',
    'Nintendo Switch',
    'Action Adventure',
    2023,
    '10',
    'ativo',
    0.0, 0.0, 0.0,
    '2023-05-12'
),

(
    'The Witcher 3: Wild Hunt',
    'the-witcher-3',
    'RPG de mundo aberto baseado na série literária de Andrzej Sapkowski, acompanhando Geralt de Rívia em uma busca por Ciri.',
    'games/the-witcher-3.webp',
    'Action RPG',
    'PC, PS4, PS5, Xbox One, Xbox Series, Switch',
    'Action RPG',
    2015,
    '16',
    'ativo',
    0.0, 0.0, 0.0,
    '2015-05-19'
)

ON DUPLICATE KEY UPDATE
    nome = VALUES(nome),
    descricao = VALUES(descricao),
    img = VALUES(img),
    categoria = VALUES(categoria),
    plataforma = VALUES(plataforma),
    genero = VALUES(genero),
    ano = VALUES(ano),
    etaria = VALUES(etaria),
    status = VALUES(status),
    data_lancamento = VALUES(data_lancamento);
