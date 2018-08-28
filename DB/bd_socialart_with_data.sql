-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 20-Set-2017 às 23:59
-- Versão do servidor: 10.1.22-MariaDB
-- PHP Version: 7.0.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socialart`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `adress`
--

CREATE TABLE `adress` (
  `adressid` int(11) NOT NULL,
  `user_userid` int(11) NOT NULL,
  `fullname` varchar(500) COLLATE utf8_general_mysql500_ci NOT NULL,
  `street` varchar(350) COLLATE utf8_general_mysql500_ci NOT NULL,
  `zip` varchar(12) COLLATE utf8_general_mysql500_ci NOT NULL,
  `city` varchar(200) COLLATE utf8_general_mysql500_ci NOT NULL,
  `Distrito` varchar(250) COLLATE utf8_general_mysql500_ci NOT NULL,
  `country` varchar(200) COLLATE utf8_general_mysql500_ci NOT NULL,
  `Principal` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'N',
  `deleted` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `adress`
--

INSERT INTO `adress` (`adressid`, `user_userid`, `fullname`, `street`, `zip`, `city`, `Distrito`, `country`, `Principal`, `deleted`) VALUES
(8, 38, 'Diana Sofia Alves Marques', 'Rua General Humberto Delgado Nº 3 Lj1', '2140-126', 'Chamusca', 'Santarém', 'Portugal', 'Y', 'N'),
(13, 1, 'Nuno M. Silva Marques', 'Rua do fU', '2140-345', 'Chamusca', 'Santarém', 'Portugal', 'Y', 'N'),
(14, 39, '', 'aa', 'm', 'mm', 'Santarém', 'Portugal', 'N', 'N'),
(20, 38, 'Diana S. Alves Pereira Marques', 'Rua António Bento BL 4 2º Dt', '2140-126', 'Chamusca', '', 'Portugal', 'N', 'N'),
(22, 1, 'Nuno Marques', 'Rua General Humberto Delgado N.º3 Loja 2', '2140-126', 'Chamusca', '', 'Portugal', 'N', 'N'),
(28, 40, '', 'Rua General Humberto Delgado N.º3 Loja 2', '2140-126', 'Chamusca', '', 'Portugal', 'N', 'N'),
(30, 42, '', 'Quinta de Santa Maria', '2140-126', 'Chamusca', '', 'Portugal', 'N', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinhocompra`
--

CREATE TABLE `carrinhocompra` (
  `CarrinhoCompraID` int(11) NOT NULL,
  `Buyer_User_userID` int(11) NOT NULL,
  `dataAdicionado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `carrinhocompra`
--

INSERT INTO `carrinhocompra` (`CarrinhoCompraID`, `Buyer_User_userID`, `dataAdicionado`, `deleted`) VALUES
(1, 1, '2017-09-07 21:12:46', 'N'),
(2, 1, '2017-09-07 21:14:49', 'Y'),
(6, 38, '2017-09-07 23:03:10', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `CategoriaID` int(11) NOT NULL,
  `Categoria` varchar(300) COLLATE utf8_general_mysql500_ci NOT NULL,
  `dataAdicionada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` enum('Y','N') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`CategoriaID`, `Categoria`, `dataAdicionada`, `deleted`) VALUES
(1, 'Pintura', '2017-09-16 02:25:33', 'N'),
(2, 'Fotografia', '2017-09-16 02:25:33', 'N'),
(3, 'Escultura', '2017-09-16 02:25:33', 'N'),
(4, 'Artesanato', '2017-09-16 02:25:33', 'N'),
(5, 'Estilo-Livre', '2017-09-16 02:25:33', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomenda`
--

CREATE TABLE `encomenda` (
  `OrderID` int(11) NOT NULL,
  `CarrinhoCompras_CarrinhoCompraID` int(11) NOT NULL,
  `Morada_MoradaID` int(11) DEFAULT NULL,
  `email` varchar(250) COLLATE utf8_general_mysql500_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `street` varchar(250) COLLATE utf8_general_mysql500_ci NOT NULL,
  `zip` varchar(45) COLLATE utf8_general_mysql500_ci NOT NULL,
  `city` varchar(150) COLLATE utf8_general_mysql500_ci NOT NULL,
  `distrito` varchar(150) COLLATE utf8_general_mysql500_ci NOT NULL,
  `country` varchar(45) COLLATE utf8_general_mysql500_ci NOT NULL,
  `fullname` varchar(45) COLLATE utf8_general_mysql500_ci NOT NULL,
  `empresa` varchar(150) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `nif` varchar(45) COLLATE utf8_general_mysql500_ci NOT NULL,
  `Comment` varchar(4500) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `dataOrder` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `encomenda`
--

INSERT INTO `encomenda` (`OrderID`, `CarrinhoCompras_CarrinhoCompraID`, `Morada_MoradaID`, `email`, `phone`, `street`, `zip`, `city`, `distrito`, `country`, `fullname`, `empresa`, `nif`, `Comment`, `dataOrder`, `deleted`) VALUES
(34, 6, 8, 'diana.sapmarques@gmail.com', '913082924 ', 'Rua General Humberto Delgado Nº 3 Lj1', '2140-126', 'Chamusca', 'Santarém', 'Portugal', 'Diana Marques', '', '237238616', 'ssgfbsnhdjfhg', '2017-09-11 02:05:42', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estado`
--

CREATE TABLE `estado` (
  `EstadoID` int(11) NOT NULL,
  `Order_OrderID` int(11) NOT NULL,
  `Estado` varchar(200) COLLATE utf8_general_mysql500_ci NOT NULL,
  `dataModificacao` datetime NOT NULL,
  `dataCriacao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `estado`
--

INSERT INTO `estado` (`EstadoID`, `Order_OrderID`, `Estado`, `dataModificacao`, `dataCriacao`) VALUES
(26, 34, 'Em processamento', '0000-00-00 00:00:00', '2017-09-11 02:05:42');

-- --------------------------------------------------------

--
-- Estrutura da tabela `favoritos`
--

CREATE TABLE `favoritos` (
  `FavoritosID` int(11) NOT NULL,
  `User_userID` int(11) NOT NULL,
  `Produto_ProdutoID` int(11) NOT NULL,
  `dataAdicionado` datetime NOT NULL,
  `deleted` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `favoritos`
--

INSERT INTO `favoritos` (`FavoritosID`, `User_userID`, `Produto_ProdutoID`, `dataAdicionado`, `deleted`) VALUES
(1, 1, 125, '2017-09-01 23:38:40', 'N'),
(2, 1, 6, '2017-09-01 23:38:51', 'N'),
(3, 1, 41, '2017-09-01 23:43:42', 'N'),
(4, 1, 125, '2017-09-02 01:22:34', 'N'),
(5, 1, 152, '2017-09-07 22:36:08', 'N'),
(6, 38, 148, '2017-09-07 23:35:06', 'N'),
(7, 38, 127, '2017-09-10 22:22:56', 'N'),
(8, 1, 150, '2017-09-17 23:31:51', 'N'),
(9, 1, 148, '2017-09-17 23:52:01', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagem`
--

CREATE TABLE `imagem` (
  `imgID` int(11) NOT NULL,
  `ProdutoID` int(11) NOT NULL,
  `imgNome` varchar(1000) COLLATE utf8_general_mysql500_ci NOT NULL,
  `Size` int(11) NOT NULL,
  `dataAdicionado` datetime NOT NULL,
  `deleted` enum('Y','N') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `imagem`
--

INSERT INTO `imagem` (`imgID`, `ProdutoID`, `imgNome`, `Size`, `dataAdicionado`, `deleted`) VALUES
(2, 54, '$null/0aa21e9e9682776bd0244933ffcea677imglogo.jpeg', 17068, '2017-09-02 16:02:30', 'N'),
(3, 54, '$null/teste1.jpg', 17068, '0000-00-00 00:00:00', 'N'),
(4, 54, '$null/0aa21e9e9682776bd0244933ffcea677imglogo.jpeg', 17068, '2017-09-02 16:02:30', 'N'),
(86, 25, '$Nana/1a7d35eb9457b9dbd721de3d6a607863imglogo.jpeg', 1956739, '2017-09-02 18:33:17', 'N'),
(87, 148, '$Nana/357da9ddb7b82534963cb73a749fe1e8imglogo.jpeg', 1753100, '2017-09-02 18:36:45', 'N'),
(88, 148, '$Nana/a252397bc5d93dbad83733646c61c788imglogo.png', 2275890, '2017-09-02 18:47:24', 'N'),
(91, 130, '$loki/83001db04c0465de0f5f81102e35b211imglogo.png', 6727, '2017-09-03 21:53:35', 'N'),
(92, 127, '$loki/xxx.jpg', 8440, '2017-09-03 21:53:35', 'N'),
(93, 130, '$loki/d939a0b5222988c02f5647c8cb57e8f5imglogo.png', 7843, '2017-09-03 21:53:35', 'N'),
(94, 130, '$loki/83001db04c0465de0f5f81102e35b211imglogo.png', 6727, '2017-09-03 22:01:25', 'N'),
(95, 130, '$loki/b46ff991bf33dfa3315eb82fc5d74074imglogo.png', 8440, '2017-09-03 22:01:25', 'N'),
(96, 130, '$loki/d939a0b5222988c02f5647c8cb57e8f5imglogo.png', 7843, '2017-09-03 22:01:25', 'N'),
(97, 25, '$Nana/a252397bc5d93dbad83733646c61c788imglogo.png', 1863387, '2017-09-03 22:37:48', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagem`
--

CREATE TABLE `mensagem` (
  `MensagemID` int(11) NOT NULL,
  `SenderUser_userID` int(11) NOT NULL,
  `ReceiverUser_userID` int(11) NOT NULL,
  `Nome` varchar(150) COLLATE utf8_general_mysql500_ci NOT NULL,
  `Email` varchar(200) COLLATE utf8_general_mysql500_ci NOT NULL,
  `Contacto` varchar(45) COLLATE utf8_general_mysql500_ci NOT NULL,
  `New` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'Y',
  `Arquivada` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'N',
  `dataAdicionada` datetime NOT NULL,
  `deleted` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `mensagem`
--

INSERT INTO `mensagem` (`MensagemID`, `SenderUser_userID`, `ReceiverUser_userID`, `Nome`, `Email`, `Contacto`, `New`, `Arquivada`, `dataAdicionada`, `deleted`) VALUES
(1, 1, 38, 'Diana Marques', 'xtpa', '98465', 'N', 'N', '2017-09-04 04:02:00', 'N'),
(2, 1, 37, 'Nuno Marques', 'nuno_marques18@hotmail.com', '45678', 'N', 'N', '2017-09-05 23:45:32', 'N'),
(3, 1, 39, 'Helder Pestana', 'nuno_marques18@hotmail.com', '122324536457', 'N', 'N', '2017-09-05 23:46:51', 'N'),
(4, 1, 40, 'Mensagem a arquivar', 'nuno_marques18@hotmail.com', '122324536457', 'N', 'Y', '2017-09-05 23:47:29', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `idMensagens` int(11) NOT NULL,
  `Mensagem` varchar(4000) COLLATE utf8_general_mysql500_ci NOT NULL,
  `MensagemSenderID` int(11) NOT NULL,
  `MensagemReceiverID` int(11) NOT NULL,
  `Mensagem_MensagemID` int(11) NOT NULL,
  `dataAdicionada` datetime NOT NULL,
  `deleted` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`idMensagens`, `Mensagem`, `MensagemSenderID`, `MensagemReceiverID`, `Mensagem_MensagemID`, `dataAdicionada`, `deleted`) VALUES
(1, 'wrethyjukghoi', 1, 38, 1, '2017-09-05 23:05:16', 'Y'),
(2, 'zfdbxgcv n', 38, 1, 1, '2017-09-05 23:07:26', 'Y'),
(3, 'zfdbxgcv n', 1, 38, 1, '2017-09-05 23:08:30', 'Y'),
(4, 'zfdbxgcv n', 38, 1, 1, '2017-09-05 23:09:08', 'Y'),
(5, 'gsfb cnmfjdxhf ', 1, 38, 1, '2017-09-05 23:10:33', 'Y'),
(6, 'gsfb cnmfjdxhf ', 38, 1, 1, '2017-09-05 23:11:05', 'Y'),
(7, 'gsfb cnmfjdxhf ', 1, 38, 1, '2017-09-05 23:11:55', 'Y'),
(8, 'gsfb cnmfjdxhf ', 38, 1, 1, '2017-09-05 23:12:16', 'Y'),
(9, 'gsfb cnmfjdxhf ', 1, 38, 1, '2017-09-05 23:12:36', 'Y'),
(10, 'gsfb cnmfjdxhf ', 38, 1, 1, '2017-09-05 23:12:49', 'Y'),
(11, 'rdgxfhcjv', 1, 38, 1, '2017-09-05 23:29:23', 'Y'),
(12, 'qrwtsdyyh', 38, 1, 1, '2017-09-05 23:30:02', 'Y'),
(13, 'eqfwvgsd', 1, 38, 1, '2017-09-05 23:30:49', 'Y'),
(14, 'rewgsdtfyj', 1, 38, 1, '2017-09-05 23:31:31', 'Y'),
(15, 'wraegstydru', 1, 38, 1, '2017-09-05 23:32:34', 'Y'),
(16, 'aewfsdgdhgsf', 1, 38, 1, '2017-09-05 23:33:16', 'Y'),
(17, 'rtgrbehg treyhfyjgh', 1, 38, 1, '2017-09-05 23:34:26', 'Y'),
(18, 'sgrdhgcv', 1, 38, 1, '2017-09-05 23:35:59', 'Y'),
(19, 'tghssaha<beh', 1, 39, 3, '2017-09-05 23:46:51', 'N'),
(20, 'sfvdbx dgcfh', 1, 40, 4, '2017-09-05 23:47:29', 'Y'),
(21, 'sfvdbx dgcfh', 1, 40, 4, '2017-09-05 23:47:44', 'Y'),
(22, 'etghwryet', 1, 39, 3, '2017-09-09 03:06:12', 'N'),
(23, 'etghwryet', 1, 39, 3, '2017-09-09 03:06:21', 'N'),
(24, 'rtgwhrnethgfthethf', 1, 39, 3, '2017-09-09 03:10:05', 'N'),
(25, 'twterd', 1, 39, 3, '2017-09-09 03:10:45', 'N');

--
-- Acionadores `mensagens`
--
DELIMITER $$
CREATE TRIGGER `NewMessage` AFTER INSERT ON `mensagens` FOR EACH ROW UPDATE `mensagem` SET `New`= 'Y' 
WHERE `MensagemID` = NEW.Mensagem_MensagemID
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `idNotificacoes` int(11) NOT NULL,
  `Followed_userID` int(11) NOT NULL,
  `Follower_userID` int(11) NOT NULL,
  `Produto_ProdutoID` int(11) NOT NULL,
  `dataCriacao` datetime NOT NULL,
  `New` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'Y',
  `deleted` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `notificacoes`
--

INSERT INTO `notificacoes` (`idNotificacoes`, `Followed_userID`, `Follower_userID`, `Produto_ProdutoID`, `dataCriacao`, `New`, `deleted`) VALUES
(1, 38, 1, 150, '2017-09-04 01:58:16', 'N', 'N'),
(3, 38, 2, 152, '2017-09-04 02:17:13', 'Y', 'N'),
(7, 38, 1, 150, '2017-09-04 01:58:16', 'Y', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `permission`
--

CREATE TABLE `permission` (
  `permissionsid` int(11) NOT NULL,
  `permissions` varchar(200) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `permission`
--

INSERT INTO `permission` (`permissionsid`, `permissions`) VALUES
(1, 'Comprador');

-- --------------------------------------------------------

--
-- Estrutura da tabela `portes`
--

CREATE TABLE `portes` (
  `idPortes` int(11) NOT NULL,
  `PesoMin` float NOT NULL,
  `PesoMax` float NOT NULL,
  `Valor` float NOT NULL,
  `dataAtualizado` datetime NOT NULL,
  `deleted` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `portes`
--

INSERT INTO `portes` (`idPortes`, `PesoMin`, `PesoMax`, `Valor`, `dataAtualizado`, `deleted`) VALUES
(1, 0, 2, 8.15, '2017-09-06 04:06:07', 'N'),
(2, 2, 4, 10.4, '0000-00-00 00:00:00', 'N'),
(3, 4, 5, 11.4, '0000-00-00 00:00:00', 'N'),
(4, 5, 6, 15.5, '0000-00-00 00:00:00', 'N'),
(5, 6, 7, 17.65, '0000-00-00 00:00:00', 'N'),
(6, 7, 9, 19.8, '0000-00-00 00:00:00', 'N'),
(7, 9, 10, 20.1, '0000-00-00 00:00:00', 'Y');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `ProdutoID` int(11) NOT NULL,
  `NomeProduto` varchar(150) COLLATE utf8_general_mysql500_ci NOT NULL,
  `SmallDescription` varchar(2000) COLLATE utf8_general_mysql500_ci NOT NULL,
  `Preco` float NOT NULL,
  `Quantidade` int(11) NOT NULL DEFAULT '1',
  `Peso` float NOT NULL DEFAULT '0.1',
  `Autor` varchar(400) COLLATE utf8_general_mysql500_ci NOT NULL,
  `User_userID` varchar(150) COLLATE utf8_general_mysql500_ci NOT NULL,
  `Familia` varchar(150) COLLATE utf8_general_mysql500_ci NOT NULL,
  `visitas` int(11) NOT NULL,
  `dataAdicionado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`ProdutoID`, `NomeProduto`, `SmallDescription`, `Preco`, `Quantidade`, `Peso`, `Autor`, `User_userID`, `Familia`, `visitas`, `dataAdicionado`, `deleted`) VALUES
(5, 'Fotografia Paisagem', 'bjlnoon kkm o ni monoim ninmom inijiom kjoiimknoinlk', 8, 1, 0.1, '', '30', '2', 3, '2017-09-10 22:09:35', 'N'),
(6, 'Lenço nº  4', 'ofbkjln boil nuin oijl moij ji', 6, 1, 0.1, '', '38', '1', 1, '2017-09-10 22:09:35', 'N'),
(7, 'Pintura nº 5', 'fdgsndfhnfbf  fg nthbfbdggfb g bgfbfgbf dgbfgb fbfg bbg ', 8, 1, 0.1, '', '38', '1', 0, '2017-09-10 22:09:35', 'N'),
(8, 'Pintura nº 6', 'ukbbuib iubiubu boubu uobuiboubouuo biubuoboubou uboubou', 50, 1, 0.1, '', '38', '1', 0, '2017-09-10 22:09:35', 'N'),
(9, 'Pintura nº 7', 'fdgsndfhnfbf  fg nthbfbdggfb g bgfbfgbf dgbfgb fbfg bbg ', 0, 1, 0.1, '', '38', '1', 0, '2017-09-10 22:09:35', 'N'),
(10, 'Pintura nº 8', 'fdgsndfhnfbf  fg nthbfbdggfb g bgfbfgbf dgbfgb fbfg bbg ', 0, 1, 0.1, '', '38', '1', 0, '2017-09-10 22:09:35', 'N'),
(11, 'Pintura nº 9', 'fdgsndfhnfbf  fg nthbfbdggfb g bgfbfgbf dgbfgb fbfg bbg ', 0, 1, 0.1, '', '38', '1', 0, '2017-09-10 22:09:35', 'N'),
(12, 'Pintura nº 10', 'fdgsndfhnfbf  fg nthbfbdggfb g bgfbfgbf dgbfgb fbfg bbg ', 0, 1, 0.1, '', '38', '1', 0, '2017-09-10 22:09:35', 'N'),
(13, 'Pintura nº 11', 'fdgsndfhnfbf  fg nthbfbdggfb g bgfbfgbf dgbfgb fbfg bbg ', 0, 1, 0.1, '', '1', '1', 0, '2017-09-10 22:09:35', 'N'),
(14, 'Escultura de Busto do Super Homem', 'fdgsndfhnfbf  fg nthbfbdggfb g bgfbfgbf dgbfgb fbfg bbg ', 10000, 1, 1000, '', '1', '3', 1, '2017-09-10 22:09:35', 'N'),
(15, 'Cadeira em palhota 1', 'fdgsndfhnfbf  fg nthbfbdggfb g bgfbfgbf dgbfgb fbfg bbg ', 0, 1, 0.1, '', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(16, 'Cadeira nº 12', 'fdgsndfhnfbf  fg nthbfbdggfb g bgfbfgbf dgbfgb fbfg bbg ', 0, 1, 0.1, '', '38', '1', 0, '2017-09-10 22:09:35', 'N'),
(17, 'Pintura nº 13', 'bhiu oubiu on oin oi mpiomoinoi noinoinoin oinion', 10, 1, 0.1, '', '38', '1', 1, '2017-09-10 22:09:35', 'N'),
(18, 'Pintura nº 14', 'bhiu oubiu on oin oi mpiomoinoi noinoinoin oinion', 10, 1, 0.1, '', '38', '1', 0, '2017-09-10 22:09:35', 'N'),
(19, 'Pintura nº 15', 'bhiu oubiu on oin oi mpiomoinoi noinoinoin oinion', 10, 1, 0.1, '', '38', '1', 0, '2017-09-10 22:09:35', 'N'),
(20, 'Pintura nº 16', 'bhiu oubiu on oin oi mpiomoinoi noinoinoin oinion', 10, 1, 0.1, '', '38', '1', 0, '2017-09-10 22:09:35', 'N'),
(21, 'Pintura nº 17', 'bhiu oubiu on oin oi mpiomoinoi noinoinoin oinion', 10, 1, 0.1, '', '38', '1', 0, '2017-09-10 22:09:35', 'N'),
(22, 'Pintura nº 18', 'bhiu oubiu on oin oi mpiomoinoi noinoinoin oinion', 10, 1, 0.1, '', '38', '1', 0, '2017-09-10 22:09:35', 'N'),
(23, 'Pintura nº 19', 'bhiu oubiu on oin oi mpiomoinoi noinoinoin oinion', 10, 1, 0.1, '', '38', '1', 0, '2017-09-10 22:09:35', 'N'),
(24, 'Pintura nº 20', 'bhiu oubiu on oin oi mpiomoinoi noinoinoin oinion', 10, 1, 0.1, '', '38', '1', 1, '2017-09-10 22:09:35', 'N'),
(25, 'Pintura nº 21', 'bhiu oubiu on oin oi mpiomoinoi noinoinoin oinion', 10, 1, 0.1, '', '38', '1', 6, '2017-09-10 22:09:35', 'N'),
(26, 'Pintura nº 22', 'bhiu oubiu on oin oi mpiomoinoi noinoinoin oinion', 10, 1, 0.1, '', '1', '1', 0, '2017-09-10 22:09:35', 'N'),
(27, 'Pintura nº 23', 'bhiu oubiu on oin oi mpiomoinoi noinoinoin oinion', 10, 1, 0.1, '', '1', '1', 0, '2017-09-10 22:09:35', 'N'),
(28, 'Pintura nº 24', 'bhiu oubiu on oin oi mpiomoinoi noinoinoin oinion', 10, 1, 0.1, '', '1', '1', 0, '2017-09-10 22:09:35', 'N'),
(29, 'Pintura nº 25', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '1', '1', 0, '2017-09-10 22:09:35', 'N'),
(30, 'Pintura nº 26', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '1', '1', 0, '2017-09-10 22:09:35', 'N'),
(31, 'Pintura nº 27', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '1', '1', 0, '2017-09-10 22:09:35', 'N'),
(32, 'Pintura nº 28', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '1', '1', 0, '2017-09-10 22:09:35', 'N'),
(33, 'Pintura nº 29', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 1225, 1, 0.1, '', '1', '1', 0, '2017-09-10 22:09:35', 'N'),
(34, 'Pintura nº 30', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 26.35, 1, 0.1, '', '1', '1', 0, '2017-09-10 22:09:35', 'N'),
(35, 'Pintura nº 31', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '30', '1', 0, '2017-09-10 22:09:35', 'N'),
(36, 'Pintura nº 32', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '30', '1', 0, '2017-09-10 22:09:35', 'N'),
(37, 'Pintura nº 33', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '30', '1', 0, '2017-09-10 22:09:35', 'N'),
(38, 'Pintura nº 33', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '30', '1', 0, '2017-09-10 22:09:35', 'N'),
(39, 'Pintura nº 34', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '30', '1', 0, '2017-09-10 22:09:35', 'N'),
(40, 'Pintura nº 35', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '30', '1', 0, '2017-09-10 22:09:35', 'N'),
(41, 'Pintura nº 36', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '38', '1', 12, '2017-09-10 22:09:35', 'N'),
(42, 'Pintura nº 37', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '30', '1', 1, '2017-09-10 22:09:35', 'N'),
(43, 'Pintura nº 38', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '2', '1', 2, '2017-09-10 22:09:35', 'N'),
(44, 'Pintura nº 39', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '2', '1', 0, '2017-09-10 22:09:35', 'N'),
(45, 'Pintura nº 40', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '2', '1', 0, '2017-09-10 22:09:35', 'N'),
(46, 'Pintura nº 41', 'fbdgbdgbfg bfgbfgbfvgb fbfgbfgbgfb bfgbfg bfg bfg b fgb bfg b', 25, 1, 0.1, '', '2', '1', 0, '2017-09-10 22:09:35', 'N'),
(47, 'Pintura nº 42', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc', 25, 1, 0.1, '', '37', '1', 8, '2017-09-10 22:09:35', 'N'),
(49, 'Pintura', 'hgj,fhkg.h', 1, 1, 0, 'DM', '1', '3', 0, '2017-09-10 22:09:35', 'N'),
(50, 'Pintura', 'hgj,fhkg.h', 1, 1, 0, 'DM', '1', '3', 0, '2017-09-10 22:09:35', 'N'),
(51, 'Pintura', 'hgj,fhkg.h', 1, 1, 0, 'DM', '1', '3', 0, '2017-09-10 22:09:35', 'N'),
(52, 'Pintura', 'hgj,fhkg.h', 1, 1, 0, 'DM', '1', '3', 1, '2017-09-10 22:09:35', 'N'),
(54, 'Teste de introdução de imagens', 'Este é o primeiro artigo experimental com imagens!', 50, 150, 1000, 'Admin', '1', '2', 0, '2017-09-10 22:09:35', 'N'),
(55, 'Teste de introdução de imagens 2ª tentativa', 'Segunda tentativa de introdução de artigos com imagens.', 45, 145, 1500, 'Admin', '1', '2', 0, '2017-09-10 22:09:35', 'N'),
(56, 'Teste de introdução de imagens 3ª tentativa', 'Teste numero 3, ver data foto', 50, 55, 55, 'Admin', '1', '2', 0, '2017-09-10 22:09:35', 'N'),
(57, 'Teste de introdução de imagens 3ª tentativa', 'Teste numero 3, ver data', 50, 55, 55, 'Admin', '1', '2', 0, '2017-09-10 22:09:35', 'N'),
(63, 'Teste de introdução de imagens 5ª tentativa', 'Ver se elimina isto', 1.01, 2, 1.02, 'Admin', '1', '3', 0, '2017-09-10 22:09:35', 'N'),
(96, 'Teste de introdução de imagens 6ª tentativa', 'Ver se elimina 6ª tentativa', 1.02, 3, 1.02, 'Admin', '1', '3', 0, '2017-09-10 22:09:35', 'N'),
(97, 'Teste de introdução de imagens 6ª tentativa', 'Ver se elimina 6ª tentativa', 1.02, 3, 1.02, 'Admin', '1', '3', 0, '2017-09-10 22:09:35', 'N'),
(98, 'Teste de introdução de imagens 6ª tentativa', 'Ver se elimina 6ª tentativa', 1.02, 3, 1.02, 'Admin', '1', '3', 0, '2017-09-10 22:09:35', 'N'),
(99, 'Teste de introdução de imagens 7ª tentativa', 'etshdhmnvm', 1.01, 2, 1.01, 'Admin', '1', '3', 0, '2017-09-10 22:09:35', 'N'),
(100, 'Teste de introdução de imagens 8ª tentativa', 'thjydmghkjbn.kgkfymtjh', 1.01, 3, 1.03, 'Admin', '1', '2', 0, '2017-09-10 22:09:35', 'N'),
(101, 'Teste de introdução de imagens 8ª tentativa', 'thjydmghkjbn.kgkfymtjh', 1.01, 3, 1.03, 'Admin', '1', '2', 0, '2017-09-10 22:09:35', 'N'),
(102, 'Teste de introdução de imagens 8ª tentativa', 'thjydmghkjbn.kgkfymtjh', 1.01, 3, 1.03, 'Admin', '1', '2', 0, '2017-09-10 22:09:35', 'N'),
(103, 'Teste de introdução de imagens 8ª tentativa', 'thjydmghkjbn.kgkfymtjh', 1.01, 3, 1.03, 'Admin', '1', '2', 0, '2017-09-10 22:09:35', 'Y'),
(104, 'Teste de introdução de imagens 8ª tentativa', 'thjydmghkjbn.kgkfymtjh', 1.01, 3, 1.03, 'Admin', '1', '2', 0, '2017-09-10 22:09:35', 'Y'),
(105, 'Teste de introdução de imagens', 'eraghsndhfjhgmhf', 1.02, 3, 1.05, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(106, 'Teste de introdução de imagens', 'eraghsndhfjhgmhf', 1.02, 3, 1.05, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(107, 'Teste de introdução de imagens', 'eraghsndhfjhgmhf', 1.02, 3, 1.05, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(108, 'Teste de introdução de imagens', 'eraghsndhfjhgmhf', 1.02, 3, 1.05, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(109, 'Teste de introdução de imagens', 'dghdnhfghh', 1, 1, 1, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(110, 'Pintura', 'sdgfdhnfgh,j', 1, 1, 1, 'Admin', '1', '1', 0, '2017-09-10 22:09:35', 'N'),
(111, 'Teste de introdução de imagens 5ª tentativa', 'dgsgnfhgnhgfbdgn', 1, 1, 1, 'Admin', '1', '2', 0, '2017-09-10 22:09:35', 'N'),
(112, 'Pintura', 'dssfbdnfg fhghdgnc', 1, 1, 1, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(113, 'Pintura', 'dssfbdnfg fhghdgnc', 1, 1, 1, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(114, 'Teste de introdução de imagens', 'nhgfmh', 1, 1, 1, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(115, 'Teste de introdução de imagens', 'nhgfmh', 1, 1, 1, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(116, 'Teste de introdução de imagens', 'nhgfmh', 1, 1, 1, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(117, 'Teste de introdução de imagens', 'nhgfmh', 1, 1, 1, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(118, 'Teste de introdução de imagens', 'nhgfmh', 1, 1, 1, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(119, 'Teste de introdução de imagens', 'nhgfmh', 1, 1, 1, 'Admin', '1', '4', 1, '2017-09-10 22:09:35', 'N'),
(120, 'Teste de introdução de imagens', 'nhgfmh', 1, 1, 1, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(121, 'Teste de introdução de imagens', 'nhgfmh', 1, 1, 1, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(122, 'Teste de introdução de imagens', 'nhgfmh', 1, 1, 1, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(123, 'Teste de introdução de imagens', 'nhgfmh', 1, 1, 1, 'Admin', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(124, 'Teste de introdução de imagens 2ª tentativa', 'gffxhnmc ', 1, 1, 1, 'Admin', '1', '1', 0, '2017-09-10 22:09:35', 'N'),
(125, 'Teste de introdução de imagens 2ª tentativa', 'gffxhnmc ', 1, 1, 1, 'Admin', '30', '1', 50, '2017-09-10 22:09:35', 'N'),
(126, 'Pintura', 'dfbgnxfmcmvn', 1, 1, 1, 'DM', '1', '4', 0, '2017-09-10 22:09:35', 'N'),
(127, 'Teste de introdução de imagens 3ª tentativa', 'gdfhhvmbm', 1, 1, 1, 'Admin', '30', '1', 14, '2017-09-10 22:09:35', 'N'),
(130, 'Teste de introdução de imagens', 'fdbnmh,hjnk', 35, 3, 10, 'Admin', '1', '5', 0, '2017-09-10 22:09:35', 'N'),
(135, 'Teste de introdução de imagens 1111', 'fshnhnxfh f x hf  gzgfxhxf   fxfgxf gxfg xf', 1, 1, 1, 'Admin', '2', '2', 0, '2017-09-10 22:09:35', 'N'),
(138, 'snow', '', 1, 1, 1, 'Maria João Marques', '38', '4', 0, '2017-09-10 22:09:35', 'N'),
(139, '31', 'Bolo ', 35, 1, 2, 'Diana Marques', '38', '4', 0, '2017-09-10 22:09:35', 'N'),
(141, 'OUT', '', 50, 1, 100, 'Diana Marques', '38', '4', 0, '2017-09-10 22:09:35', 'N'),
(148, 'NATURA', '', 1, 1, 1, 'NANA´S', '38', '1', 54, '2017-09-10 22:09:35', 'N'),
(149, '122', '', 12.5, 1, 1, 'Diana Marques', '38', '5', 1, '2017-09-10 22:09:35', 'N'),
(150, 'XPTO', 'fgsdfngmhg', 12, 12, 0.1, 'NM', '38', '1', 1, '2017-09-10 22:09:35', 'N'),
(152, 'sdgfhm', 'fdsghg', 78, 1, 0.1, 'nm', '38', '1', 206, '2017-09-10 22:09:35', 'N');

--
-- Acionadores `produto`
--
DELIMITER $$
CREATE TRIGGER `Alert` AFTER INSERT ON `produto` FOR EACH ROW INSERT INTO `notificacoes`(
  `Followed_userID`, 
  `Produto_ProdutoID`, 
  `dataCriacao`,
  `Follower_userID`
   )
    SELECT NEW.User_userID, NEW.ProdutoID, now(), Follower_userID
    FROM  seguidores
    WHERE Followed_userID = NEW.User_userID
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtoscarrinho`
--

CREATE TABLE `produtoscarrinho` (
  `ProdutosCarrinhoID` int(11) NOT NULL,
  `CarrinhoCompras_CarrinhoCompraID` int(11) NOT NULL,
  `SellerID` int(11) NOT NULL,
  `Produto_ProdutoID` int(11) NOT NULL,
  `Quantidade` int(11) NOT NULL DEFAULT '1',
  `Preco` float NOT NULL,
  `dataAdicionado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `produtoscarrinho`
--

INSERT INTO `produtoscarrinho` (`ProdutosCarrinhoID`, `CarrinhoCompras_CarrinhoCompraID`, `SellerID`, `Produto_ProdutoID`, `Quantidade`, `Preco`, `dataAdicionado`, `deleted`) VALUES
(1, 2, 38, 152, 1, 78, '2017-09-07 22:30:48', 'N'),
(2, 2, 38, 152, 1, 78, '2017-09-07 22:34:33', 'N'),
(3, 2, 38, 152, 1, 78, '2017-09-07 22:35:34', 'N'),
(4, 2, 38, 152, 1, 78, '2017-09-07 22:36:01', 'Y'),
(5, 2, 30, 125, 1, 1, '2017-09-07 22:36:18', 'N'),
(7, 6, 37, 47, 1, 25, '2017-09-07 23:05:25', 'Y'),
(8, 6, 2, 43, 1, 1, '2017-09-07 23:07:33', 'N'),
(9, 6, 30, 127, 1, 78, '2017-09-07 23:23:39', 'N'),
(10, 6, 30, 127, 1, 78, '2017-09-07 23:23:43', 'N'),
(11, 6, 30, 127, 1, 78, '2017-09-07 23:24:33', 'N'),
(12, 6, 30, 127, 1, 78, '2017-09-07 23:25:52', 'N'),
(13, 6, 1, 124, 1, 1, '2017-09-07 23:28:58', 'N'),
(14, 6, 30, 127, 1, 1, '2017-09-07 23:29:02', 'N'),
(15, 6, 2, 43, 1, 25, '2017-09-07 23:29:09', 'N'),
(18, 6, 0, 14, 1, 10000, '2017-09-16 16:32:02', 'N'),
(21, 6, 0, 14, 1, 10000, '2017-09-16 16:34:41', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `seguidores`
--

CREATE TABLE `seguidores` (
  `SeguidoresID` int(11) NOT NULL,
  `Follower_userID` int(11) NOT NULL,
  `Followed_userID` varchar(500) COLLATE utf8_general_mysql500_ci NOT NULL,
  `dataAdicionado` datetime NOT NULL,
  `deleted` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `seguidores`
--

INSERT INTO `seguidores` (`SeguidoresID`, `Follower_userID`, `Followed_userID`, `dataAdicionado`, `deleted`) VALUES
(1, 1, '1', '2017-09-02 01:47:36', 'N'),
(2, 1, 'Nuno Marques', '2017-09-02 02:55:51', 'N'),
(4, 2, '38', '2017-09-02 17:08:10', 'N'),
(5, 1, 'Diana Pereira Ma...', '2017-09-06 17:55:54', 'N'),
(6, 1, '38', '2017-09-06 19:38:46', 'N'),
(9, 1, '30', '2017-09-18 00:04:16', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `username` varchar(300) COLLATE utf8_general_mysql500_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_general_mysql500_ci NOT NULL,
  `firstname` varchar(65) COLLATE utf8_general_mysql500_ci NOT NULL,
  `lastname` varchar(65) COLLATE utf8_general_mysql500_ci NOT NULL,
  `nif` varchar(12) COLLATE utf8_general_mysql500_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_general_mysql500_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `LastLogin` datetime NOT NULL,
  `description` varchar(1000) COLLATE utf8_general_mysql500_ci NOT NULL,
  `Empresa` varchar(250) COLLATE utf8_general_mysql500_ci NOT NULL,
  `Seller` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'N',
  `dataRegisto` datetime NOT NULL,
  `deleted` enum('N','Y') COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`userid`, `username`, `password`, `firstname`, `lastname`, `nif`, `email`, `phone`, `LastLogin`, `description`, `Empresa`, `Seller`, `dataRegisto`, `deleted`) VALUES
(1, 'loki', '666223b056c9ca2b3feff387820f99bf', 'Nuno', 'Marques', '22611824', 'nuno_marques18@hotmail.com', '917920517', '2017-09-20 00:01:53', 'Artista', '', 'N', '0000-00-00 00:00:00', 'N'),
(2, 'Marques', '666223b056c9ca2b3feff387820f99bf', 'Nuno', 'Marques', '', 'nuno_marques18@hotmail.com', '', '0000-00-00 00:00:00', '', '', 'N', '0000-00-00 00:00:00', 'N'),
(30, 'admin', '666223b056c9ca2b3feff387820f99bf', 'Maria de Fátima Costa', 'Marques', '', 'mariafatimamarques44@gmail.com', '', '0000-00-00 00:00:00', '', '', 'N', '0000-00-00 00:00:00', 'N'),
(37, 'DiMarques', '2640baebfd41c2624e80b526fade7cb8', 'Maria de Fátima Costa', 'Marques', '', 'mariafatimamarques44@gmail.com', '', '0000-00-00 00:00:00', '', '', 'N', '0000-00-00 00:00:00', 'N'),
(38, 'Nana', '721e5d6a0c486c84b50882c6c2a6d6d0', 'Diana', 'Marques', '237238616', 'diana.sapmarques@gmail.com', '913082924 ', '2017-09-18 23:36:58', 'Actual e bom gosto', '', 'Y', '0000-00-00 00:00:00', 'N'),
(39, 'mm', '24fbc7395697def146b2562e9931a4c9', 'aaa', 'aaa', '', 'aaa@eu.py', '', '0000-00-00 00:00:00', '', '', 'N', '0000-00-00 00:00:00', 'N'),
(40, 'efgd', 'cd486f408c62b3a56645b2ec7c65abae', 'Nuno', 'Marques', '', 'nuno_marques18@hotmail.com', '', '0000-00-00 00:00:00', '', '', 'Y', '2017-09-06 22:28:17', 'N'),
(42, 'Nuno', '666223b056c9ca2b3feff387820f99bf', 'Nuno', 'Marques', '', 'nuno_marques18@hotmail.com', '', '0000-00-00 00:00:00', '', '', 'N', '2017-09-11 01:00:02', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `userpermission`
--

CREATE TABLE `userpermission` (
  `userpermissionid` int(11) NOT NULL,
  `user_userid` int(11) NOT NULL,
  `permission_permissionid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Extraindo dados da tabela `userpermission`
--

INSERT INTO `userpermission` (`userpermissionid`, `user_userid`, `permission_permissionid`) VALUES
(1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adress`
--
ALTER TABLE `adress`
  ADD PRIMARY KEY (`adressid`),
  ADD KEY `fk_user_userid` (`user_userid`);

--
-- Indexes for table `carrinhocompra`
--
ALTER TABLE `carrinhocompra`
  ADD PRIMARY KEY (`CarrinhoCompraID`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`CategoriaID`);

--
-- Indexes for table `encomenda`
--
ALTER TABLE `encomenda`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`EstadoID`),
  ADD KEY `fk_order_orderID` (`Order_OrderID`);

--
-- Indexes for table `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`FavoritosID`);

--
-- Indexes for table `imagem`
--
ALTER TABLE `imagem`
  ADD PRIMARY KEY (`imgID`);

--
-- Indexes for table `mensagem`
--
ALTER TABLE `mensagem`
  ADD PRIMARY KEY (`MensagemID`);

--
-- Indexes for table `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`idMensagens`);

--
-- Indexes for table `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`idNotificacoes`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`permissionsid`);

--
-- Indexes for table `portes`
--
ALTER TABLE `portes`
  ADD PRIMARY KEY (`idPortes`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`ProdutoID`);

--
-- Indexes for table `produtoscarrinho`
--
ALTER TABLE `produtoscarrinho`
  ADD PRIMARY KEY (`ProdutosCarrinhoID`),
  ADD KEY `CarrinhoCompras_CarrinhoCompraID` (`CarrinhoCompras_CarrinhoCompraID`);

--
-- Indexes for table `seguidores`
--
ALTER TABLE `seguidores`
  ADD PRIMARY KEY (`SeguidoresID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `userpermission`
--
ALTER TABLE `userpermission`
  ADD PRIMARY KEY (`userpermissionid`),
  ADD KEY `FK_usersid` (`user_userid`),
  ADD KEY `FK_permission_id` (`permission_permissionid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adress`
--
ALTER TABLE `adress`
  MODIFY `adressid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `carrinhocompra`
--
ALTER TABLE `carrinhocompra`
  MODIFY `CarrinhoCompraID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `CategoriaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `encomenda`
--
ALTER TABLE `encomenda`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `estado`
--
ALTER TABLE `estado`
  MODIFY `EstadoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `FavoritosID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `imagem`
--
ALTER TABLE `imagem`
  MODIFY `imgID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
--
-- AUTO_INCREMENT for table `mensagem`
--
ALTER TABLE `mensagem`
  MODIFY `MensagemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `idMensagens` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `idNotificacoes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `permissionsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `portes`
--
ALTER TABLE `portes`
  MODIFY `idPortes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `ProdutoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;
--
-- AUTO_INCREMENT for table `produtoscarrinho`
--
ALTER TABLE `produtoscarrinho`
  MODIFY `ProdutosCarrinhoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `seguidores`
--
ALTER TABLE `seguidores`
  MODIFY `SeguidoresID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `userpermission`
--
ALTER TABLE `userpermission`
  MODIFY `userpermissionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `adress`
--
ALTER TABLE `adress`
  ADD CONSTRAINT `fk_user_userid` FOREIGN KEY (`user_userid`) REFERENCES `user` (`userid`);

--
-- Limitadores para a tabela `estado`
--
ALTER TABLE `estado`
  ADD CONSTRAINT `fk_order_orderID` FOREIGN KEY (`Order_OrderID`) REFERENCES `encomenda` (`OrderID`);

--
-- Limitadores para a tabela `produtoscarrinho`
--
ALTER TABLE `produtoscarrinho`
  ADD CONSTRAINT `produtoscarrinho_ibfk_1` FOREIGN KEY (`CarrinhoCompras_CarrinhoCompraID`) REFERENCES `carrinhocompra` (`CarrinhoCompraID`);

--
-- Limitadores para a tabela `userpermission`
--
ALTER TABLE `userpermission`
  ADD CONSTRAINT `FK_permission_id` FOREIGN KEY (`permission_permissionid`) REFERENCES `permission` (`permissionsid`),
  ADD CONSTRAINT `FK_usersid` FOREIGN KEY (`user_userid`) REFERENCES `user` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
