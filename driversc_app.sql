-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 25-Abr-2020 às 15:24
-- Versão do servidor: 5.6.47
-- versão do PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `driversc_app`
--

CREATE DATABASE IF NOT EXISTS `driversc_app`;
USE `driversc_app`;

-- CREATE USER 'driversc_api'@'localhost' IDENTIFIED BY '$oH#RwlwDHAf';
-- GRANT ALL ON `driversc_app`.* TO 'driversc_api'@'localhost';
-- FLUSH PRIVILEGES;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_controle`
--

CREATE TABLE `tb_acl_controle` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_menu` int(10) UNSIGNED NOT NULL,
  `route` varchar(255) NOT NULL,
  `controller` varchar(50) NOT NULL DEFAULT '',
  `action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_acl_controle`
--

INSERT INTO `tb_acl_controle` (`id`, `id_menu`, `route`, `controller`, `action`) VALUES
(1, 1, 'dashboard', 'home', ''),
(2, 1, 'account', 'login', ''),
(3, 1, 'configuracoes', 'configuracoes', ''),
(4, 1, 'menus', 'menus', ''),
(9, 1, 'categorias', 'categorias', ''),
(15, 1, 'routes', 'routes', ''),
(17, 1, 'checkout', 'checkout', ''),
(18, 1, 'modulos', 'modulos', ''),
(20, 1, 'galerias', 'galerias', ''),
(21, 1, 'videos', 'videos', ''),
(22, 1, 'paginas', 'paginas', ''),
(13, 3, 'banners', 'banners', ''),
(14, 4, 'planos', 'planos', ''),
(6, 5, 'comunicados', 'comunicados', ''),
(19, 6, 'faq', 'faq', ''),
(8, 7, 'quemsomos', 'quemsomos', ''),
(5, 8, 'usuarios', 'usuarios', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_grupo`
--

CREATE TABLE `tb_acl_grupo` (
  `id` int(10) UNSIGNED NOT NULL,
  `grupo` varchar(20) NOT NULL DEFAULT '',
  `descricao` varchar(1000) DEFAULT NULL,
  `modulo` varchar(20) NOT NULL DEFAULT 'admin',
  `nivel` tinyint(3) UNSIGNED NOT NULL DEFAULT '7',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_acl_grupo`
--

INSERT INTO `tb_acl_grupo` (`id`, `grupo`, `descricao`, `modulo`, `nivel`, `status`) VALUES
(1, 'Super Administrador', NULL, 'admin', 1, '1'),
(2, 'Administrador', NULL, 'admin', 2, '1'),
(3, 'Gerente', NULL, 'admin', 3, '1'),
(4, 'Vendedor', NULL, 'admin', 4, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_grupo_modulo`
--

CREATE TABLE `tb_acl_grupo_modulo` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_grupo` int(10) UNSIGNED NOT NULL,
  `id_modulo` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela para cadastro de módulos para cada grupo';

--
-- Extraindo dados da tabela `tb_acl_grupo_modulo`
--

INSERT INTO `tb_acl_grupo_modulo` (`id`, `id_grupo`, `id_modulo`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(4, 2, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acl_permissao`
--

CREATE TABLE `tb_acl_permissao` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_grupo` int(10) UNSIGNED NOT NULL,
  `id_controle` int(10) UNSIGNED NOT NULL,
  `listar` enum('S','N') NOT NULL DEFAULT 'N',
  `inserir` enum('S','N') NOT NULL DEFAULT 'N',
  `editar` enum('S','N') NOT NULL DEFAULT 'N',
  `remover` enum('S','N') NOT NULL DEFAULT 'N',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_acl_permissao`
--

INSERT INTO `tb_acl_permissao` (`id`, `id_grupo`, `id_controle`, `listar`, `inserir`, `editar`, `remover`, `status`) VALUES
(1, 1, 1, 'S', 'S', 'S', 'S', '1'),
(2, 1, 5, 'S', 'S', 'S', 'S', '1'),
(3, 1, 17, 'S', 'S', 'S', 'S', '1'),
(9, 1, 18, 'S', 'S', 'S', 'S', '1'),
(10, 1, 21, 'S', 'S', 'S', 'S', '1'),
(11, 1, 19, 'S', 'S', 'S', 'S', '1'),
(12, 2, 2, 'S', 'S', 'S', 'N', '1'),
(15, 1, 8, 'S', 'S', 'S', 'S', '1'),
(16, 2, 5, 'S', 'S', 'S', 'N', '1'),
(17, 1, 3, 'S', 'S', 'S', 'S', '1'),
(20, 1, 13, 'S', 'S', 'S', 'S', '1'),
(23, 2, 8, 'S', 'S', 'S', 'S', '1'),
(39, 1, 2, 'S', 'S', 'S', 'S', '1'),
(41, 2, 21, 'S', 'S', 'S', 'S', '1'),
(42, 2, 9, 'S', 'S', 'S', 'S', '1'),
(43, 2, 14, 'S', 'S', 'S', 'S', '1'),
(45, 1, 14, 'S', 'S', 'S', 'S', '1'),
(46, 2, 6, 'S', 'S', 'S', 'S', '1'),
(52, 2, 20, 'S', 'S', 'S', 'S', '1'),
(56, 1, 6, 'S', 'S', 'S', 'S', '1'),
(57, 2, 13, 'S', 'S', 'S', 'S', '1'),
(58, 1, 21, 'S', 'S', 'S', 'S', '1'),
(59, 2, 2, 'N', 'N', 'N', 'N', '1'),
(60, 1, 4, 'S', 'S', 'S', 'S', '1'),
(61, 1, 8, 'S', 'S', 'S', 'S', '1'),
(62, 1, 17, 'S', 'S', 'S', 'S', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_associado`
--

CREATE TABLE `tb_associado` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `login` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categoria`
--

CREATE TABLE `tb_categoria` (
  `id` int(10) UNSIGNED NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_categoria`
--

INSERT INTO `tb_categoria` (`id`, `categoria`, `slug`, `imagem`, `status`) VALUES
(1, 'lava-jatos', 'lava-jatos', NULL, '1'),
(2, 'oficinas', 'oficinas', NULL, '1'),
(3, 'postos de gasolina', 'postos-de-gasolina', NULL, '1'),
(4, 'alimentação', 'alimentacao', NULL, '1'),
(5, 'lazer', 'lazer', NULL, '1'),
(6, 'teste', 'teste-1', NULL, '0'),
(7, 'teste 2', 'teste-2', NULL, '0'),
(8, 'teste 3', 'teste-3', NULL, '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_configuracao`
--

CREATE TABLE `tb_configuracao` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Número sequencial da tabela.',
  `meta_title` varchar(100) NOT NULL COMMENT 'Título para tag title.',
  `meta_description` varchar(255) NOT NULL COMMENT 'Descrição para a tag meta description',
  `meta_keywords` varchar(500) NOT NULL COMMENT 'Keywords para tag meta keywords',
  `meta_generator` varchar(500) NOT NULL DEFAULT 'Aptana Studio 3' COMMENT 'Generator para a tag meta generator',
  `meta_author` varchar(255) NOT NULL DEFAULT 'Alisson Guedes' COMMENT 'Author para tag meta author',
  `meta_creator_address` varchar(255) NOT NULL DEFAULT 'alissonguedes87@gmail.com' COMMENT 'E-mail do autor para tag DC.creator.address',
  `meta_custodian` varchar(255) NOT NULL DEFAULT 'Guedes, Alisson' COMMENT 'Custodian para tag meta Custodian',
  `meta_publisher` varchar(255) NOT NULL DEFAULT 'Digital WareHouse' COMMENT 'Publisher para tag meta DC.publisher',
  `meta_revisit_after` varchar(100) NOT NULL DEFAULT '15 days',
  `meta_rating` varchar(100) NOT NULL DEFAULT 'general',
  `meta_robots` varchar(500) DEFAULT NULL,
  `theme_color` varchar(25) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `logomarca` varchar(255) DEFAULT NULL COMMENT 'Logomarca do site',
  `language` varchar(5) NOT NULL DEFAULT 'pt-br' COMMENT 'Idioma padrão do site.',
  `msg_manutencao` varchar(500) NOT NULL DEFAULT 'Site em manutenção.',
  `msg_bloqueio_temporario` varchar(500) DEFAULT NULL COMMENT 'Mensagem de bloqueio temporário',
  `version` decimal(4,2) DEFAULT NULL COMMENT 'Explicação da configuração.',
  `logomarca_nf` varchar(255) DEFAULT NULL COMMENT 'Local do arquivo de logomarca para impressão na nota fiscal',
  `texto_apresentacao` text,
  `facebook` varchar(255) DEFAULT NULL COMMENT 'Endereço no facebook',
  `instagram` varchar(255) DEFAULT NULL COMMENT 'Endereço no instagram',
  `twitter` varchar(255) DEFAULT NULL COMMENT 'Endereço no twitter',
  `youtube` varchar(4) DEFAULT NULL COMMENT 'Endereço no youtube',
  `linkedin` varchar(255) DEFAULT NULL COMMENT 'Link para o perfil do linkedin',
  `gplus` varchar(255) DEFAULT NULL COMMENT 'Link para o perfil do Google Plus',
  `website` varchar(255) DEFAULT NULL COMMENT 'Endereço do website',
  `email` varchar(255) DEFAULT NULL COMMENT 'E-mail de contato',
  `telefone` varchar(16) DEFAULT NULL,
  `celular` varchar(16) DEFAULT NULL,
  `manutencao` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1 Ativa ou 0 - Inativa o site para manutenção.',
  `publicado` enum('0','1') NOT NULL DEFAULT '1' COMMENT '1 - Ativa ou 0 Inativa permanete ou temporariamente o site'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de configurações do site';

--
-- Extraindo dados da tabela `tb_configuracao`
--

INSERT INTO `tb_configuracao` (`id`, `meta_title`, `meta_description`, `meta_keywords`, `meta_generator`, `meta_author`, `meta_creator_address`, `meta_custodian`, `meta_publisher`, `meta_revisit_after`, `meta_rating`, `meta_robots`, `theme_color`, `path`, `logomarca`, `language`, `msg_manutencao`, `msg_bloqueio_temporario`, `version`, `logomarca_nf`, `texto_apresentacao`, `facebook`, `instagram`, `twitter`, `youtube`, `linkedin`, `gplus`, `website`, `email`, `telefone`, `celular`, `manutencao`, `publicado`) VALUES
(1, 'PJM Telecom', 'Provedor de serviço de Internet em Campina Grande', 'pjm,pjm telecom,pjmtelecom,internet,velocidade,campina grande', 'Aptana Studio 3', 'Alisson Guedes', 'alissonguedes87@gmail.com', 'Guedes, Alisson', 'Digital WareHouse', '15 days', 'general', NULL, NULL, '/pjmtelecom', '/pjmtelecom/public/pjmtelecom/img/logo/1581451769_82aebb3a6bbcb84cde9e.png', 'pt-br', '<h3 class=\"center-align\">Site indisponível.</h3>\n\n<p class=\"center-align\">Estamos enfrentando instabilidades em nossos sistemas. Por favor, tente novamente mais tarde ou informe-nos através do e-mail <a href=\"mailto:contato@pjmtelecom.com\">contato@pjmtelecom.com</a>.</p>', '<h3 class=\"center-align\">Site indisponível.</h3>\n\n<p class=\"center-align\">Estamos enfrentando instabilidades em nossos sistemas. Por favor, tente novamente mais tarde ou informe-nos através do e-mail <a href=\"mailto:contato@pjmtelecom.com\">contato@pjmtelecom.com</a>.</p>', NULL, NULL, '<h5>Insira um texto de apresentação para o seu site aqui...</h5>\n\n\n<p>Insira um texto de apresentação para o seu site aqui...</p>\n\n<p>Adicione outra tag para o parágrafo com <p>Parágrafo</p>.</p>', 'https://www.facebook.com/PJMTelecom/', 'https://www.instagram.com/pjmtelecom/', '', NULL, '', '', NULL, 'contato@pjmtelecom.com', '(83) 3322.9761', '(83) 9 9885.8758', '0', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_empresa`
--

CREATE TABLE `tb_empresa` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Chave primária da tabela.',
  `cnpj` varchar(18) NOT NULL COMMENT 'CNPJ da empresa.',
  `inscricao_estadual` varchar(14) NOT NULL COMMENT 'Inscrição Estadual da empresa',
  `inscricao_municipal` varchar(20) NOT NULL COMMENT 'Inscrição Municipal da empresa.',
  `razao_social` varchar(200) NOT NULL COMMENT 'Razão Social da empresa',
  `nome_fantasia` varchar(200) NOT NULL COMMENT 'Nome Fantasia da empresa.',
  `cep` varchar(9) NOT NULL COMMENT 'CEP do endereço da empresa',
  `endereco` varchar(200) NOT NULL COMMENT 'Endereço da empresa',
  `numero` varchar(11) NOT NULL COMMENT 'Número do endereço da empresa',
  `bairro` varchar(200) NOT NULL COMMENT 'Bairro do endereço da empresa',
  `complemento` varchar(200) DEFAULT NULL COMMENT 'Complemento do endereço da empresa',
  `cidade` varchar(200) NOT NULL COMMENT 'Cidade',
  `estado` varchar(3) NOT NULL COMMENT 'Estado',
  `descricao` text COMMENT 'Descrição da empresa',
  `telefone` varchar(16) NOT NULL COMMENT 'Número do telefone da empresa',
  `email` varchar(255) DEFAULT NULL COMMENT 'E-mail da empresa',
  `aliquota_imposto` decimal(10,3) NOT NULL COMMENT 'Alíquota de imposto da empresa',
  `tributacao` enum('SIMPLES NACIONAL','SN - EXCESSO DE SUB-LIMITE DA RECEITA','REGIME NORMAL') NOT NULL COMMENT 'Tipo de tributação',
  `certificado` blob NOT NULL COMMENT 'Localização do arquivo de certificado digital para emissão de notas fiscais',
  `senha_certificado` varchar(255) NOT NULL COMMENT 'Senha do certificado digital',
  `ambiente` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Tipo do ambiente de emissão de notas fiscais. 0 - Homologação; 1 - Produção',
  `sequence_nfe` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Número da última nota fiscal eletrônica emitida.',
  `sequence_nfce` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Número da última nota fiscal de consumidor emitida.',
  `serie_nfe` int(2) UNSIGNED ZEROFILL NOT NULL DEFAULT '00' COMMENT 'Série da nota fiscal eletrônica.',
  `serie_nfce` int(2) UNSIGNED ZEROFILL NOT NULL DEFAULT '00' COMMENT 'Série da nota fiscal de consumidor.',
  `tokencsc` varchar(6) DEFAULT NULL COMMENT 'Token CSC',
  `csc` varchar(36) DEFAULT NULL COMMENT 'CSC',
  `matriz` enum('S','N') NOT NULL DEFAULT 'N' COMMENT 'Identifica como loja Matriz ou Filial',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de cadastro de lojas/empresas';

--
-- Extraindo dados da tabela `tb_empresa`
--

INSERT INTO `tb_empresa` (`id`, `cnpj`, `inscricao_estadual`, `inscricao_municipal`, `razao_social`, `nome_fantasia`, `cep`, `endereco`, `numero`, `bairro`, `complemento`, `cidade`, `estado`, `descricao`, `telefone`, `email`, `aliquota_imposto`, `tributacao`, `certificado`, `senha_certificado`, `ambiente`, `sequence_nfe`, `sequence_nfce`, `serie_nfe`, `serie_nfce`, `tokencsc`, `csc`, `matriz`, `status`) VALUES
(1, '17.312.858/0001-94', '123123213', '123123213', '123213123', '123213213', '58421-210', 'Dr. Acácio Figueiredo', '17', 'Acácio Figueiredo', '12323213', 'Campina Grande', 'PB', '12312', '123123', NULL, 0.000, 'SIMPLES NACIONAL', '', '', '0', 0, 0, 00, 00, NULL, NULL, 'S', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_menu`
--

CREATE TABLE `tb_menu` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Chave primária da tabela',
  `secao` int(10) UNSIGNED NOT NULL COMMENT 'Chave estrangeira da tabela referente à tabela tb_menu_secao campo `id`',
  `parent` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Chave candidata para agrupamento do menu referente ao campo id',
  `label` varchar(200) NOT NULL COMMENT 'Descrição de exibição do menu',
  `link` varchar(255) NOT NULL COMMENT 'Nome da rota para a página',
  `target` varchar(30) DEFAULT NULL COMMENT 'Forma como será aberto o menu.',
  `icone` varchar(255) DEFAULT NULL COMMENT 'Ícone de exibiçao no menu',
  `ordem` int(11) NOT NULL DEFAULT '0' COMMENT 'Ordem de exibição do menu.',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Indicador de ativo do menu. Se 0, não será exibido nem acessível por ninguém, se 1, ativo e exibido.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela para cadastro de menus com acesso supervisionado';

--
-- Extraindo dados da tabela `tb_menu`
--

INSERT INTO `tb_menu` (`id`, `secao`, `parent`, `label`, `link`, `target`, `icone`, `ordem`, `status`) VALUES
(1, 1, 0, 'Dashboard', 'dashboard', NULL, 'fa fa-dashboard', 0, '1'),
(2, 2, 0, 'Página Inicial', 'pagina-inicial', NULL, 'fa fa-home', 0, '1'),
(3, 2, 0, 'Banners', 'banners', '13', 'fa fa-image', 0, '1'),
(4, 2, 0, 'Planos', 'planos', '9', 'fa fa-usd', 0, '1'),
(5, 2, 0, 'Comunicados', 'comunicados', NULL, 'fa fa-bullhorn', 0, '1'),
(6, 2, 0, 'Dúvidas Frequentes', 'faq', NULL, 'fa fa-comments-o', 0, '1'),
(7, 2, 0, 'Empresa', 'quemsomos', '19', 'fa fa-group', 0, '1'),
(8, 1, 0, 'Usuários', 'usuarios', '15', 'fa fa-users', 0, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_menu_secao`
--

CREATE TABLE `tb_menu_secao` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Chave primária da tabela.',
  `modulo` int(10) UNSIGNED NOT NULL COMMENT 'Chave estrangeira da tabela referente à tabela tb_modulo `id`',
  `secao` varchar(255) NOT NULL COMMENT 'Nome da ção',
  `slug` varchar(255) NOT NULL COMMENT 'Nome da seção sem espaços e minúscula',
  `descricao` varchar(1000) DEFAULT NULL COMMENT 'Observações ou descrição do módulo',
  `posicao` varchar(10) DEFAULT NULL COMMENT 'Posição onde será inserida a seção do menu',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Indicador de ativação do múdlo. 0 - Inativo, 1 - Ativo. Se 0, não é acessível por ninguém.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de módulos de sistema. Serve para cadastrar os tipo de diretórios acessíveis. Ex.: main, admin, entre outros.';

--
-- Extraindo dados da tabela `tb_menu_secao`
--

INSERT INTO `tb_menu_secao` (`id`, `modulo`, `secao`, `slug`, `descricao`, `posicao`, `status`) VALUES
(1, 2, 'Administrativo', 'menu', 'Barra de menus principal para páginas da área administrativa.', 'left', '1'),
(2, 1, 'Páginas do Site', 'site', 'Seção Painel de Controle da Sidebar', 'left', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_modulo`
--

CREATE TABLE `tb_modulo` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Chave primária da tabela.',
  `modulo` varchar(255) NOT NULL COMMENT 'Nome do módulo',
  `diretorio` varchar(255) NOT NULL COMMENT 'Nome do diretório',
  `descricao` varchar(1000) DEFAULT NULL COMMENT 'Observações ou descrição do módulo',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Indicador de ativação do múdlo. 0 - Inativo, 1 - Ativo. Se 0, não é acessível por ninguém.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de módulos de sistema. Serve para cadastrar os tipo de diretórios acessíveis. Ex.: main, admin, entre outros.';

--
-- Extraindo dados da tabela `tb_modulo`
--

INSERT INTO `tb_modulo` (`id`, `modulo`, `diretorio`, `descricao`, `status`) VALUES
(1, 'Página Pública do Site', 'main', 'Módulo acessível por qualquer usuário na internet.', '1'),
(2, 'Página Administrativa do Site', 'admin', 'Módulo acessível apenas para administradores do site.', '1'),
(3, 'Página de Sistema', 'sge', 'Módulo do Sistema de Gestão de Empresas. Acessível apenas para clientes cadastrados na automação comercial', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_parceiro`
--

CREATE TABLE `tb_parceiro` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_categoria` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `logradouro` varchar(255) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `cep` varchar(9) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `uf` varchar(3) NOT NULL,
  `latitude` varchar(11) NOT NULL,
  `longitude` varchar(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_parceiro`
--

INSERT INTO `tb_parceiro` (`id`, `id_categoria`, `nome`, `imagem`, `logradouro`, `numero`, `complemento`, `cep`, `bairro`, `cidade`, `uf`, `latitude`, `longitude`, `status`) VALUES
(1, 1, 'Alisson', '/assets/img/parceiros/1.png', 'Rua Ex-combatente Assis Luiz', '100', 'AP 401-F', '58076-100', 'Ernesto Geisel', 'João Pessoa', 'PB', '-7.243123', '-35.921902', '1'),
(2, 1, 'Marcelo Augusto', '/assets/img/parceiros/2.png', 'Rua Corretor José Carlos Fonseca de Oliveira', '405', '', '58432-581', 'Malvinas', 'Campina Grande', 'PB', '-7.177351', '-34.874810', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_servico`
--

CREATE TABLE `tb_servico` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_categoria` int(10) UNSIGNED NOT NULL,
  `id_parceiro` int(10) UNSIGNED NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(9,3) UNSIGNED NOT NULL,
  `imagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_servico`
--

INSERT INTO `tb_servico` (`id`, `id_categoria`, `id_parceiro`, `descricao`, `valor`, `imagem`) VALUES
(1, 1, 1, 'Lavagem Simples', 15.000, '/assets/img/parceiros/3.png'),
(2, 1, 2, 'Lavagem Completa', 20.000, '/assets/img/parceiros/4.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_servico_agenda`
--

CREATE TABLE `tb_servico_agenda` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_servico` int(10) UNSIGNED NOT NULL,
  `id_associado` int(10) UNSIGNED NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `status` enum('S','P','F','C') NOT NULL DEFAULT 'S' COMMENT 'S - Scheduled (Agendado); P - Progress (Andamento); F - Finished (Finalizado); C - Canceled (Cancelado)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_servico_agenda`
--

INSERT INTO `tb_servico_agenda` (`id`, `id_servico`, `id_associado`, `data`, `hora`, `status`) VALUES
(6, 1, 1, '2020-04-08', '06:00:00', 'S'),
(7, 2, 1, '2020-04-16', '06:00:00', 'S');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Chave primária da tabela. Código interno do usuario',
  `id_grupo` int(10) UNSIGNED NOT NULL COMMENT 'Chave estrangeira da tabela referente à tabela tb_usuario_nivel - Nível de acesso do usuario',
  `id_gestor` int(10) UNSIGNED DEFAULT NULL,
  `nome` varchar(200) NOT NULL COMMENT 'Nome do usuário',
  `imagem` varchar(255) DEFAULT NULL,
  `email` varchar(200) NOT NULL COMMENT 'E-mail do usuário',
  `login` varchar(200) NOT NULL COMMENT 'Login de acesso ao sistema',
  `senha` varchar(255) NOT NULL COMMENT 'Senha para login',
  `salt` varchar(255) DEFAULT NULL COMMENT 'Gera uma hash para a senha',
  `ultimo_login` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Registra a data da última visita',
  `primeiro_login` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Verifica se o usuário já realizou login. 0 - Não; 1 - Sim. Caso ainda não tenha realizado login, deverá solicitar mudança da senha.',
  `listar` enum('S','N') NOT NULL DEFAULT 'N',
  `editar` enum('S','N') NOT NULL DEFAULT 'N',
  `inserir` enum('S','N') NOT NULL DEFAULT 'N',
  `excluir` enum('S','N') NOT NULL DEFAULT 'N',
  `hide_menu` enum('S','N') NOT NULL DEFAULT 'N',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Indicador de ativação do usuario. 0 - Inativo/Bloqueado; 1 - Ativo/Desbloqueado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de cadastro de usuarios de caixas';

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id`, `id_grupo`, `id_gestor`, `nome`, `imagem`, `email`, `login`, `senha`, `salt`, `ultimo_login`, `primeiro_login`, `listar`, `editar`, `inserir`, `excluir`, `hide_menu`, `status`) VALUES
(1, 1, NULL, 'Alisson Guedes', 'assets/img/usuarios/1/a2x.jpg', 'alissonguedes87@gmail.com', 'alisson', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3', '', '2020-02-11 18:03:40', '1', 'N', 'N', 'N', 'N', 'N', '1'),
(2, 2, NULL, 'Felipe', NULL, 'felipeweb26@hotmail.com', 'felipeweb26@hotmail.com', '361be3ac1f67cf94c53a08137483a31e67b79b8d8ba5150d54', '', '2020-01-29 03:29:05', '1', 'N', 'N', 'N', 'N', 'N', '1'),
(3, 2, NULL, 'Bruno', NULL, 'bruno@pjm.net.br', 'bruno@pjm.net.br', 'f4c762d50c21b3581bde831609574cb054e8bbf86f7fb7e05b', '', '2020-01-11 20:21:52', '1', 'N', 'N', 'N', 'N', 'N', '1'),
(4, 2, NULL, 'Lailson', NULL, 'lailsoncosta2015@outlook.com', 'lailsoncosta2015@outlook.com', '0932551321f1921045beae31ffda152050f4db7fc5a22a28c2', '', '2019-12-18 19:08:27', '1', 'N', 'N', 'N', 'N', 'N', '1'),
(5, 4, NULL, 'Lailson Costa', NULL, 'lailsonejoyce@gmail.com', 'lailsonejoyce@gmail.com', 'b123e9e19d217169b981a61188920f9d28638709a513220168', '', '2020-02-11 17:59:46', '1', 'N', 'N', 'N', 'N', 'N', '1'),
(25, 4, NULL, 'Teste', NULL, 'teste@teste.com', 'Teste', 'b123e9e19d217169b981a61188920f9d28638709a513220168', NULL, '2020-02-11 17:17:39', '1', 'N', 'N', 'N', 'N', 'N', '1');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_acl_controle`
--
ALTER TABLE `tb_acl_controle`
  ADD PRIMARY KEY (`id_menu`,`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `FK_tb_acl_controle_tb_menu` (`id_menu`);

--
-- Índices para tabela `tb_acl_grupo`
--
ALTER TABLE `tb_acl_grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modulo` (`modulo`),
  ADD KEY `grupo` (`grupo`),
  ADD KEY `nivel_acesso` (`nivel`);

--
-- Índices para tabela `tb_acl_grupo_modulo`
--
ALTER TABLE `tb_acl_grupo_modulo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_acl_grupo_modulo_id_grupo` (`id_grupo`),
  ADD KEY `fk_tb_acl_grupo_modulo_id_modulo` (`id_modulo`);

--
-- Índices para tabela `tb_acl_permissao`
--
ALTER TABLE `tb_acl_permissao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `FK_tb_acl_permissao_tb_acl_controles` (`id_controle`),
  ADD KEY `FK_tb_acl_permissao_tb_acl_grupo` (`id_grupo`);

--
-- Índices para tabela `tb_associado`
--
ALTER TABLE `tb_associado`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_categoria`
--
ALTER TABLE `tb_categoria`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_configuracao`
--
ALTER TABLE `tb_configuracao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_empresa`
--
ALTER TABLE `tb_empresa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnpj` (`cnpj`);

--
-- Índices para tabela `tb_menu`
--
ALTER TABLE `tb_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_menu_secao` (`secao`);

--
-- Índices para tabela `tb_menu_secao`
--
ALTER TABLE `tb_menu_secao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_tb_menu_secao_modulo` (`modulo`);

--
-- Índices para tabela `tb_modulo`
--
ALTER TABLE `tb_modulo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `diretorio` (`diretorio`);

--
-- Índices para tabela `tb_parceiro`
--
ALTER TABLE `tb_parceiro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_parceiro_id_categoria` (`id_categoria`);

--
-- Índices para tabela `tb_servico`
--
ALTER TABLE `tb_servico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_servico_id_categoria` (`id_categoria`),
  ADD KEY `fk_tb_servico_id_parceiro` (`id_parceiro`);

--
-- Índices para tabela `tb_servico_agenda`
--
ALTER TABLE `tb_servico_agenda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_servico_agenda_id_servico` (`id_servico`),
  ADD KEY `fk_tb_servico_agenda_id_associado` (`id_associado`);

--
-- Índices para tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `fk_tb_usuario_nivel` (`id_grupo`),
  ADD KEY `FK_tb_usuario_id_gestor` (`id_gestor`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_associado`
--
ALTER TABLE `tb_associado`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_categoria`
--
ALTER TABLE `tb_categoria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tb_configuracao`
--
ALTER TABLE `tb_configuracao`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Número sequencial da tabela.', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_empresa`
--
ALTER TABLE `tb_empresa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Chave primária da tabela.', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_parceiro`
--
ALTER TABLE `tb_parceiro`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_servico`
--
ALTER TABLE `tb_servico`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_servico_agenda`
--
ALTER TABLE `tb_servico_agenda`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_parceiro`
--
ALTER TABLE `tb_parceiro`
  ADD CONSTRAINT `fk_tb_parceiro_id_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `tb_categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_servico`
--
ALTER TABLE `tb_servico`
  ADD CONSTRAINT `fk_tb_servico_id_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `tb_categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_servico_id_parceiro` FOREIGN KEY (`id_parceiro`) REFERENCES `tb_parceiro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_servico_agenda`
--
ALTER TABLE `tb_servico_agenda`
  ADD CONSTRAINT `fk_tb_servico_agenda_id_associado` FOREIGN KEY (`id_associado`) REFERENCES `tb_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tb_servico_agenda_id_servico` FOREIGN KEY (`id_servico`) REFERENCES `tb_servico` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
