SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+03:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- `ssn_accounts`
--

CREATE TABLE IF NOT EXISTS `ssn_accounts` (
  `acc_id` smallint(11) NOT NULL,
  `acc_name` varchar(200) NOT NULL,
  `acc_comment` varchar(255) DEFAULT NULL,
  `acc_is_active` tinyint(4) NOT NULL DEFAULT '1',
  `acc_key` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`acc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='accounts information';

-- --------------------------------------------------------

--
--  `ssn_commands`
--

CREATE TABLE IF NOT EXISTS `ssn_commands` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account` smallint(6) NOT NULL,
  `object` tinyint(4) NOT NULL,
  `command` smallint(6) NOT NULL,
  `token` char(16) DEFAULT NULL COMMENT 'used token',
  `time_store` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 - draft, 1 - ready, 2 - loaded, 3 - in processing',
  `command_data` varchar(8000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
--  `ssn_logs`
--

CREATE TABLE IF NOT EXISTS `ssn_logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account` smallint(6) NOT NULL,
  `object` tinyint(4) NOT NULL,
  `record_type` tinyint(6) NOT NULL COMMENT 'type code: 1 - log, 2 - preferences',
  `timestamp` int(16) NOT NULL COMMENT 'used token',
  `time_store` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `record_data` varchar(8000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
--  `ssn_teledata`
--

CREATE TABLE IF NOT EXISTS `ssn_teledata` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account` smallint(6) NOT NULL,
  `object` tinyint(4) NOT NULL,
  `sensor` smallint(6) NOT NULL,
  `index` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'sensor value index',
  `time_send` bigint(20) NOT NULL,
  `time_store` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sensor_value` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `x_ind_timestamp` (`time_store`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
--  `ssn_dict`
--
CREATE TABLE IF NOT EXISTS `ssn_dict` (
	    id_dict 		bigint(20) NOT NULL AUTO_INCREMENT,
		dict_parent 	bigint(20) DEFAULT NULL,
	    dict_item_type	tinyint(4) DEFAULT NULL,
	    dict_value_int 	bigint(20) DEFAULT NULL,
	    dict_value_int2 bigint(20) DEFAULT NULL,
	    dict_value_int3 bigint(20) DEFAULT NULL,
	    dict_item_comment varchar(2000) DEFAULT NULL,
	    dict_value_string varchar(1000) DEFAULT NULL,
	    dict_value_float float4,
		dict_is_common tinyint(4) DEFAULT 0,
		dict_is_active tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id_dict`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10000;

-- --------------------------------------------------------

--
--  `ssn_users`
--
CREATE TABLE IF NOT EXISTS `ssn_users` (
	    user_id 		bigint(20) NOT NULL AUTO_INCREMENT,
		user_login 		varchar(200) NOT NULL,
	    user_name		varchar(250) NOT NULL,
	    user_comment 	varchar(250) DEFAULT NULL,
	    user_acc		bigint(20) DEFAULT NULL,
	    user_passwd 	varchar(255) DEFAULT NULL,
	    user_is_active  tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
