--
-- Search Module MySQL Database for Phire CMS 2.0
--

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------------

--
-- Table structure for table `searches`
--

CREATE TABLE IF NOT EXISTS `[{prefix}]searches` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `keywords` varchar(255) NOT NULL,
  `results` int(16) NOT NULL,
  `method` varchar(255) NOT NULL,
  `timestamp` int(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20001;

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 1;
