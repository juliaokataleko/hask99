-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11-Jul-2019 às 00:29
-- Versão do servidor: 10.1.38-MariaDB
-- versão do PHP: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hask99`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `table_acesslog`
--

CREATE TABLE `table_acesslog` (
  `acesslog_id` int(11) NOT NULL,
  `ip` varchar(25) NOT NULL,
  `url` varchar(200) DEFAULT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `table_acesslog`
--

INSERT INTO `table_acesslog` (`acesslog_id`, `ip`, `url`, `dateCreated`) VALUES
(1, '127.0.0.1', 'http://kataleko.com/hask99/home', '2019-07-10 22:27:52'),
(2, '127.0.0.1', 'http://kataleko.com/hask99/home', '2019-07-10 22:27:53'),
(3, '127.0.0.1', 'http://kataleko.com/hask99/home', '2019-07-10 22:27:53'),
(4, '127.0.0.1', 'http://kataleko.com/hask99/login', '2019-07-10 22:27:55'),
(5, '127.0.0.1', 'http://kataleko.com/hask99/register', '2019-07-10 22:27:57'),
(6, '127.0.0.1', 'http://kataleko.com/hask99/register', '2019-07-10 22:28:20'),
(7, '127.0.0.1', 'http://kataleko.com/hask99/login', '2019-07-10 22:28:20'),
(8, '127.0.0.1', 'http://kataleko.com/hask99/login', '2019-07-10 22:28:27'),
(9, '127.0.0.1', 'http://kataleko.com/hask99/index', '2019-07-10 22:28:27'),
(10, '127.0.0.1', 'http://kataleko.com/hask99/notactive', '2019-07-10 22:28:27'),
(11, '127.0.0.1', 'http://kataleko.com/hask99/notactive', '2019-07-10 22:28:44'),
(12, '127.0.0.1', 'http://kataleko.com/hask99/index', '2019-07-10 22:28:44'),
(13, '127.0.0.1', 'http://kataleko.com/hask99/profile?user=admin', '2019-07-10 22:28:46'),
(14, '127.0.0.1', 'http://kataleko.com/hask99/post', '2019-07-10 22:28:50'),
(15, '127.0.0.1', 'http://kataleko.com/hask99/post', '2019-07-10 22:29:06'),
(16, '127.0.0.1', 'http://kataleko.com/hask99/index', '2019-07-10 22:29:07'),
(17, '127.0.0.1', 'http://kataleko.com/hask99/index', '2019-07-10 22:29:08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `table_group`
--

CREATE TABLE `table_group` (
  `group_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `privacy` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NULL DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `table_groups`
--

CREATE TABLE `table_groups` (
  `group_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `permissions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `table_like`
--

CREATE TABLE `table_like` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `table_posts`
--

CREATE TABLE `table_posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question` varchar(200) NOT NULL,
  `category` int(11) NOT NULL,
  `details` text NOT NULL,
  `dataCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dataModified` timestamp NULL DEFAULT NULL,
  `file` varchar(100) DEFAULT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `table_posts`
--

INSERT INTO `table_posts` (`post_id`, `user_id`, `question`, `category`, `details`, `dataCreated`, `dataModified`, `file`, `group_id`) VALUES
(75, 42, 'Como criar um sistema php?? #desenvolvimento', 0, '', '2019-07-10 22:29:06', NULL, '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `table_reads`
--

CREATE TABLE `table_reads` (
  `read_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `table_users`
--

CREATE TABLE `table_users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(70) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `joined` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `grupo` int(11) DEFAULT '1',
  `active` int(11) DEFAULT '0',
  `confirmation_code` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `table_users`
--

INSERT INTO `table_users` (`user_id`, `username`, `email`, `name`, `password`, `salt`, `joined`, `grupo`, `active`, `confirmation_code`) VALUES
(42, 'admin', 'admin@email.com', 'Administrator', '5595e4480c095bb4ab89fc0319f4d5cd3dd33ca559655000a6cbbfc88a619537', 'å½_å+Òá1Is×rgDWÖ×ÚÏPþ¬MúÂ‚=', '2019-07-10 23:28:20', 1, 1, '5d26');

-- --------------------------------------------------------

--
-- Estrutura da tabela `table_users_session`
--

CREATE TABLE `table_users_session` (
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_alerts`
--

CREATE TABLE `tbl_alerts` (
  `object_id` int(11) NOT NULL,
  `user_id_action` int(11) NOT NULL,
  `type_alert` int(11) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModified` timestamp NULL DEFAULT NULL,
  `user_id_receive` int(11) NOT NULL,
  `readState` tinyint(1) NOT NULL DEFAULT '0',
  `alertId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_comments`
--

CREATE TABLE `tbl_comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_acesslog`
--
ALTER TABLE `table_acesslog`
  ADD PRIMARY KEY (`acesslog_id`);

--
-- Indexes for table `table_group`
--
ALTER TABLE `table_group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `table_groups`
--
ALTER TABLE `table_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `table_like`
--
ALTER TABLE `table_like`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `table_posts`
--
ALTER TABLE `table_posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `table_reads`
--
ALTER TABLE `table_reads`
  ADD PRIMARY KEY (`read_id`);

--
-- Indexes for table `table_users`
--
ALTER TABLE `table_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `table_users_session`
--
ALTER TABLE `table_users_session`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `tbl_alerts`
--
ALTER TABLE `tbl_alerts`
  ADD PRIMARY KEY (`alertId`);

--
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_acesslog`
--
ALTER TABLE `table_acesslog`
  MODIFY `acesslog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `table_group`
--
ALTER TABLE `table_group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_groups`
--
ALTER TABLE `table_groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_like`
--
ALTER TABLE `table_like`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `table_posts`
--
ALTER TABLE `table_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `table_reads`
--
ALTER TABLE `table_reads`
  MODIFY `read_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=640;

--
-- AUTO_INCREMENT for table `table_users`
--
ALTER TABLE `table_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `table_users_session`
--
ALTER TABLE `table_users_session`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_alerts`
--
ALTER TABLE `tbl_alerts`
  MODIFY `alertId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
