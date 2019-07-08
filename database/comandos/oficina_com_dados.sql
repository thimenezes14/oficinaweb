-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11-Nov-2018 às 16:43
-- Versão do servidor: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oficina`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_comandas`
--

CREATE TABLE `tb_comandas` (
  `numero` decimal(6,0) UNSIGNED ZEROFILL NOT NULL,
  `dt_cmd` date NOT NULL,
  `valor` decimal(7,2) NOT NULL,
  `descr` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `status_cmd` char(1) COLLATE latin1_general_cs NOT NULL,
  `dt_reg` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Extraindo dados da tabela `tb_comandas`
--

INSERT INTO `tb_comandas` (`numero`, `dt_cmd`, `valor`, `descr`, `status_cmd`, `dt_reg`) VALUES
('058405', '2018-11-11', '70.00', 'Jogo de velas de ignição', 'C', '2018-11-11'),
('123456', '2018-11-11', '200.00', 'Peças para S10 - Rodrigo', 'C', '2018-11-11'),
('134502', '2018-11-11', '103.50', 'Repositório de estoque', 'C', '2018-11-11'),
('504552', '2018-11-11', '40.00', 'Tampa do reservatório - Saveiro', 'P', '2018-11-11'),
('604510', '2018-11-11', '450.75', 'Kit de suspensão - VW Kombi', 'P', '2018-11-11'),
('604754', '2018-11-11', '74.22', 'Amortecedores para Corolla', 'P', '2018-11-11'),
('777048', '2018-11-11', '50.00', 'Jogo de pastilhas de freio - Honda Fit', 'C', '2018-11-11'),
('850485', '2018-11-11', '250.00', 'Kit de revisão - Fiesta', 'C', '2018-11-11'),
('857480', '2018-11-11', '1000.00', 'Pneus aro 15', 'P', '2018-11-11'),
('870800', '2018-11-11', '80.00', 'Jogo de cabos de ignição ', 'P', '2018-11-11'),
('897005', '2018-11-11', '473.00', 'Kit de correias, polias e tensores', 'B', '2018-11-11'),
('965405', '2018-11-11', '123.45', 'Óleo para motores 5W30', 'B', '2018-11-11'),
('978805', '2018-11-11', '32.50', 'Óleo de câmbio tipo 80', 'P', '2018-11-11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `usuario_id` int(4) NOT NULL,
  `usuario_login` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `usuario_nome` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `usuario_senha` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `usuario_status` char(1) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`usuario_id`, `usuario_login`, `usuario_nome`, `usuario_senha`, `usuario_status`) VALUES
(1, 'thiago', 'Thiago Menezes', 'tsm99', 'A'),
(2, 'ratinho', 'Rosivaldo Menezes', 'rato76', 'A'),
(3, 'ditynha', 'Edite Francelina', 'dity80', 'I'),
(4, 'agatha', 'Agatha Menezes', 'nenem2014', 'I');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_comandas`
--
ALTER TABLE `tb_comandas`
  ADD PRIMARY KEY (`numero`,`dt_cmd`);

--
-- Indexes for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `uni_usuario` (`usuario_login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `usuario_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
