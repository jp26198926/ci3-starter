-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2020 at 02:19 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci3_starter`
--
DROP DATABASE `ci3_starter`;
CREATE DATABASE IF NOT EXISTS `ci3_starter` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ci3_starter`;

-- --------------------------------------------------------

--
-- Table structure for table `admin_mod_perm`
--

DROP TABLE IF EXISTS `admin_mod_perm`;
CREATE TABLE `admin_mod_perm` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_mod_perm`
--

INSERT INTO `admin_mod_perm` (`id`, `role_id`, `module_id`, `permission_id`) VALUES
(1, 1, 1, 1),
(2, 1, 1, 2),
(3, 1, 2, 1),
(4, 1, 3, 1),
(84, 1, 3, 2),
(85, 1, 3, 3),
(5, 1, 4, 1),
(6, 1, 4, 2),
(7, 1, 4, 3),
(88, 1, 5, 1),
(87, 1, 5, 2),
(86, 1, 5, 3),
(92, 1, 6, 1),
(93, 1, 6, 8),
(94, 1, 7, 8),
(89, 1, 8, 1),
(90, 1, 8, 2),
(91, 1, 8, 3);

-- --------------------------------------------------------

--
-- Table structure for table `admin_module`
--

DROP TABLE IF EXISTS `admin_module`;
CREATE TABLE `admin_module` (
  `id` int(11) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `module_description` varchar(100) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_module`
--

INSERT INTO `admin_module` (`id`, `module_name`, `module_description`, `parent_id`) VALUES
(1, 'admin_user', 'User Account', 1),
(2, 'admin_role', 'Role', 1),
(3, 'admin_permission', 'Permission', 1),
(4, 'admin_module', 'Module', 1),
(5, 'admin_parent', 'Parent Module', 1),
(6, 'maintenance_db', 'Database', 2),
(7, 'queue_general', 'General Queue', 3),
(8, 'maintenance_settings', 'Settings', 2);

-- --------------------------------------------------------

--
-- Table structure for table `admin_parent`
--

DROP TABLE IF EXISTS `admin_parent`;
CREATE TABLE `admin_parent` (
  `parent_id` int(11) NOT NULL,
  `parent_name` varchar(100) NOT NULL,
  `parent_description` varchar(100) NOT NULL,
  `parent_icon` varchar(50) NOT NULL DEFAULT '',
  `parent_order` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_parent`
--

INSERT INTO `admin_parent` (`parent_id`, `parent_name`, `parent_description`, `parent_icon`, `parent_order`) VALUES
(1, 'Administration', 'Administration', 'fa-gear', 100),
(2, 'Maintenance', 'Maintenance', 'fa-wrench', 99),
(3, 'Queuing', 'Queuing', 'fa-sort-alpha-asc', 98);

-- --------------------------------------------------------

--
-- Table structure for table `admin_permission`
--

DROP TABLE IF EXISTS `admin_permission`;
CREATE TABLE `admin_permission` (
  `id` int(11) NOT NULL,
  `permission` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_permission`
--

INSERT INTO `admin_permission` (`id`, `permission`) VALUES
(6, 'Activate'),
(1, 'Add'),
(5, 'Audit'),
(3, 'Delete'),
(8, 'Generate'),
(2, 'Modify'),
(7, 'Print'),
(4, 'Sendback');

-- --------------------------------------------------------

--
-- Table structure for table `admin_role`
--

DROP TABLE IF EXISTS `admin_role`;
CREATE TABLE `admin_role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_role`
--

INSERT INTO `admin_role` (`id`, `role_name`) VALUES
(1, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `app_currency`
--

DROP TABLE IF EXISTS `app_currency`;
CREATE TABLE `app_currency` (
  `id` int(11) NOT NULL,
  `country` varchar(100) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_currency`
--

INSERT INTO `app_currency` (`id`, `country`, `currency`, `code`) VALUES
(1, 'AFGHANISTAN', 'Afghani', 'AFN'),
(2, 'ALBANIA', 'Lek', 'ALL'),
(3, 'ALGERIA', 'Algerian Dinar', 'DZD'),
(4, 'AMERICAN SAMOA', 'US Dollar', 'USD'),
(5, 'ANDORRA', 'Euro', 'EUR'),
(6, 'ANGOLA', 'Kwanza', 'AOA'),
(7, 'ANGUILLA', 'East Caribbean Dollar', 'XCD'),
(8, 'ANTIGUA AND BARBUDA', 'East Caribbean Dollar', 'XCD'),
(9, 'ARGENTINA', 'Argentine Peso', 'ARS'),
(10, 'ARMENIA', 'Armenian Dram', 'AMD'),
(11, 'ARUBA', 'Aruban Florin', 'AWG'),
(12, 'AUSTRALIA', 'Australian Dollar', 'AUD'),
(13, 'AUSTRIA', 'Euro', 'EUR'),
(14, 'AZERBAIJAN', 'Azerbaijanian Manat', 'AZN'),
(15, 'BAHAMAS (THE)', 'Bahamian Dollar', 'BSD'),
(16, 'BAHRAIN', 'Bahraini Dinar', 'BHD'),
(17, 'BANGLADESH', 'Taka', 'BDT'),
(18, 'BARBADOS', 'Barbados Dollar', 'BBD'),
(19, 'BELARUS', 'Belarussian Ruble', 'BYN'),
(20, 'BELGIUM', 'Euro', 'EUR'),
(21, 'BELIZE', 'Belize Dollar', 'BZD'),
(22, 'BENIN', 'CFA Franc BCEAO', 'XOF'),
(23, 'BERMUDA', 'Bermudian Dollar', 'BMD'),
(24, 'BHUTAN', 'Ngultrum', 'BTN'),
(25, 'BHUTAN', 'Indian Rupee', 'INR'),
(26, 'BOLIVIA (PLURINATIONAL STATE OF)', 'Boliviano', 'BOB'),
(27, 'BOLIVIA (PLURINATIONAL STATE OF)', 'Mvdol', 'BOV'),
(28, 'BONAIRE, SINT EUSTATIUS AND SABA', 'US Dollar', 'USD'),
(29, 'BOSNIA AND HERZEGOVINA', 'Convertible Mark', 'BAM'),
(30, 'BOTSWANA', 'Pula', 'BWP'),
(31, 'BOUVET ISLAND', 'Norwegian Krone', 'NOK'),
(32, 'BRAZIL', 'Brazilian Real', 'BRL'),
(33, 'BRITISH INDIAN OCEAN TERRITORY (THE)', 'US Dollar', 'USD'),
(34, 'BRUNEI DARUSSALAM', 'Brunei Dollar', 'BND'),
(35, 'BULGARIA', 'Bulgarian Lev', 'BGN'),
(36, 'BURKINA FASO', 'CFA Franc BCEAO', 'XOF'),
(37, 'BURUNDI', 'Burundi Franc', 'BIF'),
(38, 'CABO VERDE', 'Cabo Verde Escudo', 'CVE'),
(39, 'CAMBODIA', 'Riel', 'KHR'),
(40, 'CAMEROON', 'CFA Franc BEAC', 'XAF'),
(41, 'CANADA', 'Canadian Dollar', 'CAD'),
(42, 'CAYMAN ISLANDS (THE)', 'Cayman Islands Dollar', 'KYD'),
(43, 'CENTRAL AFRICAN REPUBLIC (THE)', 'CFA Franc BEAC', 'XAF'),
(44, 'CHAD', 'CFA Franc BEAC', 'XAF'),
(45, 'CHILE', 'Unidad de Fomento', 'CLF'),
(46, 'CHILE', 'Chilean Peso', 'CLP'),
(47, 'CHINA', 'Yuan Renminbi', 'CNY'),
(48, 'CHRISTMAS ISLAND', 'Australian Dollar', 'AUD'),
(49, 'COCOS (KEELING) ISLANDS (THE)', 'Australian Dollar', 'AUD'),
(50, 'COLOMBIA', 'Colombian Peso', 'COP'),
(51, 'COLOMBIA', 'Unidad de Valor Real', 'COU'),
(52, 'COMOROS (THE)', 'Comoro Franc', 'KMF'),
(53, 'CONGO (THE DEMOCRATIC REPUBLIC OF THE)', 'Congolese Franc', 'CDF'),
(54, 'CONGO (THE)', 'CFA Franc BEAC', 'XAF'),
(55, 'COOK ISLANDS (THE)', 'New Zealand Dollar', 'NZD'),
(56, 'COSTA RICA', 'Costa Rican Colon', 'CRC'),
(57, 'CROATIA', 'Kuna', 'HRK'),
(58, 'CUBA', 'Peso Convertible', 'CUC'),
(59, 'CUBA', 'Cuban Peso', 'CUP'),
(60, 'CURAÇAO', 'Netherlands Antillean Guilder', 'ANG'),
(61, 'CYPRUS', 'Euro', 'EUR'),
(62, 'CZECH REPUBLIC (THE)', 'Czech Koruna', 'CZK'),
(63, 'CÔTE D''IVOIRE', 'CFA Franc BCEAO', 'XOF'),
(64, 'DENMARK', 'Danish Krone', 'DKK'),
(65, 'DJIBOUTI', 'Djibouti Franc', 'DJF'),
(66, 'DOMINICA', 'East Caribbean Dollar', 'XCD'),
(67, 'DOMINICAN REPUBLIC (THE)', 'Dominican Peso', 'DOP'),
(68, 'ECUADOR', 'US Dollar', 'USD'),
(69, 'EGYPT', 'Egyptian Pound', 'EGP'),
(70, 'EL SALVADOR', 'El Salvador Colon', 'SVC'),
(71, 'EL SALVADOR', 'US Dollar', 'USD'),
(72, 'EQUATORIAL GUINEA', 'CFA Franc BEAC', 'XAF'),
(73, 'ERITREA', 'Nakfa', 'ERN'),
(74, 'ESTONIA', 'Euro', 'EUR'),
(75, 'ETHIOPIA', 'Ethiopian Birr', 'ETB'),
(76, 'EUROPEAN UNION', 'Euro', 'EUR'),
(77, 'FALKLAND ISLANDS (THE) [MALVINAS]', 'Falkland Islands Pound', 'FKP'),
(78, 'FAROE ISLANDS (THE)', 'Danish Krone', 'DKK'),
(79, 'FIJI', 'Fiji Dollar', 'FJD'),
(80, 'FINLAND', 'Euro', 'EUR'),
(81, 'FRANCE', 'Euro', 'EUR'),
(82, 'FRENCH GUIANA', 'Euro', 'EUR'),
(83, 'FRENCH POLYNESIA', 'CFP Franc', 'XPF'),
(84, 'FRENCH SOUTHERN TERRITORIES (THE)', 'Euro', 'EUR'),
(85, 'GABON', 'CFA Franc BEAC', 'XAF'),
(86, 'GAMBIA (THE)', 'Dalasi', 'GMD'),
(87, 'GEORGIA', 'Lari', 'GEL'),
(88, 'GERMANY', 'Euro', 'EUR'),
(89, 'GHANA', 'Ghana Cedi', 'GHS'),
(90, 'GIBRALTAR', 'Gibraltar Pound', 'GIP'),
(91, 'GREECE', 'Euro', 'EUR'),
(92, 'GREENLAND', 'Danish Krone', 'DKK'),
(93, 'GRENADA', 'East Caribbean Dollar', 'XCD'),
(94, 'GUADELOUPE', 'Euro', 'EUR'),
(95, 'GUAM', 'US Dollar', 'USD'),
(96, 'GUATEMALA', 'Quetzal', 'GTQ'),
(97, 'GUERNSEY', 'Pound Sterling', 'GBP'),
(98, 'GUINEA', 'Guinea Franc', 'GNF'),
(99, 'GUINEA-BISSAU', 'CFA Franc BCEAO', 'XOF'),
(100, 'GUYANA', 'Guyana Dollar', 'GYD'),
(101, 'HAITI', 'Gourde', 'HTG'),
(102, 'HAITI', 'US Dollar', 'USD'),
(103, 'HEARD ISLAND AND McDONALD ISLANDS', 'Australian Dollar', 'AUD'),
(104, 'HOLY SEE (THE)', 'Euro', 'EUR'),
(105, 'HONDURAS', 'Lempira', 'HNL'),
(106, 'HONG KONG', 'Hong Kong Dollar', 'HKD'),
(107, 'HUNGARY', 'Forint', 'HUF'),
(108, 'ICELAND', 'Iceland Krona', 'ISK'),
(109, 'INDIA', 'Indian Rupee', 'INR'),
(110, 'INDONESIA', 'Rupiah', 'IDR'),
(111, 'INTERNATIONAL MONETARY FUND (IMF) ', 'SDR (Special Drawing Right)', 'XDR'),
(112, 'IRAN (ISLAMIC REPUBLIC OF)', 'Iranian Rial', 'IRR'),
(113, 'IRAQ', 'Iraqi Dinar', 'IQD'),
(114, 'IRELAND', 'Euro', 'EUR'),
(115, 'ISLE OF MAN', 'Pound Sterling', 'GBP'),
(116, 'ISRAEL', 'New Israeli Sheqel', 'ILS'),
(117, 'ITALY', 'Euro', 'EUR'),
(118, 'JAMAICA', 'Jamaican Dollar', 'JMD'),
(119, 'JAPAN', 'Yen', 'JPY'),
(120, 'JERSEY', 'Pound Sterling', 'GBP'),
(121, 'JORDAN', 'Jordanian Dinar', 'JOD'),
(122, 'KAZAKHSTAN', 'Tenge', 'KZT'),
(123, 'KENYA', 'Kenyan Shilling', 'KES'),
(124, 'KIRIBATI', 'Australian Dollar', 'AUD'),
(125, 'KOREA (THE DEMOCRATIC PEOPLE’S REPUBLIC OF)', 'North Korean Won', 'KPW'),
(126, 'KOREA (THE REPUBLIC OF)', 'Won', 'KRW'),
(127, 'KUWAIT', 'Kuwaiti Dinar', 'KWD'),
(128, 'KYRGYZSTAN', 'Som', 'KGS'),
(129, 'LAO PEOPLE’S DEMOCRATIC REPUBLIC (THE)', 'Kip', 'LAK'),
(130, 'LATVIA', 'Euro', 'EUR'),
(131, 'LEBANON', 'Lebanese Pound', 'LBP'),
(132, 'LESOTHO', 'Loti', 'LSL'),
(133, 'LESOTHO', 'Rand', 'ZAR'),
(134, 'LIBERIA', 'Liberian Dollar', 'LRD'),
(135, 'LIBYA', 'Libyan Dinar', 'LYD'),
(136, 'LIECHTENSTEIN', 'Swiss Franc', 'CHF'),
(137, 'LITHUANIA', 'Euro', 'EUR'),
(138, 'LUXEMBOURG', 'Euro', 'EUR'),
(139, 'MACAO', 'Pataca', 'MOP'),
(140, 'MADAGASCAR', 'Malagasy Ariary', 'MGA'),
(141, 'MALAWI', 'Kwacha', 'MWK'),
(142, 'MALAYSIA', 'Malaysian Ringgit', 'MYR'),
(143, 'MALDIVES', 'Rufiyaa', 'MVR'),
(144, 'MALI', 'CFA Franc BCEAO', 'XOF'),
(145, 'MALTA', 'Euro', 'EUR'),
(146, 'MARSHALL ISLANDS (THE)', 'US Dollar', 'USD'),
(147, 'MARTINIQUE', 'Euro', 'EUR'),
(148, 'MAURITANIA', 'Ouguiya', 'MRU'),
(149, 'MAURITIUS', 'Mauritius Rupee', 'MUR'),
(150, 'MAYOTTE', 'Euro', 'EUR'),
(151, 'MEMBER COUNTRIES OF THE AFRICAN DEVELOPMENT BANK GROUP', 'ADB Unit of Account', 'XUA'),
(152, 'MEXICO', 'Mexican Peso', 'MXN'),
(153, 'MEXICO', 'Mexican Unidad de Inversion (UDI)', 'MXV'),
(154, 'MICRONESIA (FEDERATED STATES OF)', 'US Dollar', 'USD'),
(155, 'MOLDOVA (THE REPUBLIC OF)', 'Moldovan Leu', 'MDL'),
(156, 'MONACO', 'Euro', 'EUR'),
(157, 'MONGOLIA', 'Tugrik', 'MNT'),
(158, 'MONTENEGRO', 'Euro', 'EUR'),
(159, 'MONTSERRAT', 'East Caribbean Dollar', 'XCD'),
(160, 'MOROCCO', 'Moroccan Dirham', 'MAD'),
(161, 'MOZAMBIQUE', 'Mozambique Metical', 'MZN'),
(162, 'MYANMAR', 'Kyat', 'MMK'),
(163, 'NAMIBIA', 'Namibia Dollar', 'NAD'),
(164, 'NAMIBIA', 'Rand', 'ZAR'),
(165, 'NAURU', 'Australian Dollar', 'AUD'),
(166, 'NEPAL', 'Nepalese Rupee', 'NPR'),
(167, 'NETHERLANDS (THE)', 'Euro', 'EUR'),
(168, 'NEW CALEDONIA', 'CFP Franc', 'XPF'),
(169, 'NEW ZEALAND', 'New Zealand Dollar', 'NZD'),
(170, 'NICARAGUA', 'Cordoba Oro', 'NIO'),
(171, 'NIGER (THE)', 'CFA Franc BCEAO', 'XOF'),
(172, 'NIGERIA', 'Naira', 'NGN'),
(173, 'NIUE', 'New Zealand Dollar', 'NZD'),
(174, 'NORFOLK ISLAND', 'Australian Dollar', 'AUD'),
(175, 'NORTHERN MARIANA ISLANDS (THE)', 'US Dollar', 'USD'),
(176, 'NORWAY', 'Norwegian Krone', 'NOK'),
(177, 'OMAN', 'Rial Omani', 'OMR'),
(178, 'PAKISTAN', 'Pakistan Rupee', 'PKR'),
(179, 'PALAU', 'US Dollar', 'USD'),
(180, 'PALESTINE, STATE OF', 'No universal currency', ''),
(181, 'PANAMA', 'Balboa', 'PAB'),
(182, 'PANAMA', 'US Dollar', 'USD'),
(183, 'PAPUA NEW GUINEA', 'Kina', 'PGK'),
(184, 'PARAGUAY', 'Guarani', 'PYG'),
(185, 'PERU', 'Nuevo Sol', 'PEN'),
(186, 'PHILIPPINES (THE)', 'Philippine Peso', 'PHP'),
(187, 'PITCAIRN', 'New Zealand Dollar', 'NZD'),
(188, 'POLAND', 'Zloty', 'PLN'),
(189, 'PORTUGAL', 'Euro', 'EUR'),
(190, 'PUERTO RICO', 'US Dollar', 'USD'),
(191, 'QATAR', 'Qatari Rial', 'QAR'),
(192, 'REPUBLIC OF NORTH MACEDONIA', 'Denar', 'MKD'),
(193, 'ROMANIA', 'Romanian Leu', 'RON'),
(194, 'RUSSIAN FEDERATION (THE)', 'Russian Ruble', 'RUB'),
(195, 'RWANDA', 'Rwanda Franc', 'RWF'),
(196, 'RÉUNION', 'Euro', 'EUR'),
(197, 'SAINT BARTHÉLEMY', 'Euro', 'EUR'),
(198, 'SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA', 'Saint Helena Pound', 'SHP'),
(199, 'SAINT KITTS AND NEVIS', 'East Caribbean Dollar', 'XCD'),
(200, 'SAINT LUCIA', 'East Caribbean Dollar', 'XCD'),
(201, 'SAINT MARTIN (FRENCH PART)', 'Euro', 'EUR'),
(202, 'SAINT PIERRE AND MIQUELON', 'Euro', 'EUR'),
(203, 'SAINT VINCENT AND THE GRENADINES', 'East Caribbean Dollar', 'XCD'),
(204, 'SAMOA', 'Tala', 'WST'),
(205, 'SAN MARINO', 'Euro', 'EUR'),
(206, 'SAO TOME AND PRINCIPE', 'Dobra', 'STN'),
(207, 'SAUDI ARABIA', 'Saudi Riyal', 'SAR'),
(208, 'SENEGAL', 'CFA Franc BCEAO', 'XOF'),
(209, 'SERBIA', 'Serbian Dinar', 'RSD'),
(210, 'SEYCHELLES', 'Seychelles Rupee', 'SCR'),
(211, 'SIERRA LEONE', 'Leone', 'SLL'),
(212, 'SINGAPORE', 'Singapore Dollar', 'SGD'),
(213, 'SINT MAARTEN (DUTCH PART)', 'Netherlands Antillean Guilder', 'ANG'),
(214, 'SISTEMA UNITARIO DE COMPENSACION REGIONAL DE PAGOS "SUCRE"', 'Sucre', 'XSU'),
(215, 'SLOVAKIA', 'Euro', 'EUR'),
(216, 'SLOVENIA', 'Euro', 'EUR'),
(217, 'SOLOMON ISLANDS', 'Solomon Islands Dollar', 'SBD'),
(218, 'SOMALIA', 'Somali Shilling', 'SOS'),
(219, 'SOUTH AFRICA', 'Rand', 'ZAR'),
(220, 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'No universal currency', ''),
(221, 'SOUTH SUDAN', 'South Sudanese Pound', 'SSP'),
(222, 'SPAIN', 'Euro', 'EUR'),
(223, 'SRI LANKA', 'Sri Lanka Rupee', 'LKR'),
(224, 'SUDAN (THE)', 'Sudanese Pound', 'SDG'),
(225, 'SURINAME', 'Surinam Dollar', 'SRD'),
(226, 'SVALBARD AND JAN MAYEN', 'Norwegian Krone', 'NOK'),
(227, 'SWAZILAND', 'Lilangeni', 'SZL'),
(228, 'SWEDEN', 'Swedish Krona', 'SEK'),
(229, 'SWITZERLAND', 'WIR Euro', 'CHE'),
(230, 'SWITZERLAND', 'Swiss Franc', 'CHF'),
(231, 'SWITZERLAND', 'WIR Franc', 'CHW'),
(232, 'SYRIAN ARAB REPUBLIC', 'Syrian Pound', 'SYP'),
(233, 'TAIWAN (PROVINCE OF CHINA)', 'New Taiwan Dollar', 'TWD'),
(234, 'TAJIKISTAN', 'Somoni', 'TJS'),
(235, 'TANZANIA, UNITED REPUBLIC OF', 'Tanzanian Shilling', 'TZS'),
(236, 'THAILAND', 'Baht', 'THB'),
(237, 'TIMOR-LESTE', 'US Dollar', 'USD'),
(238, 'TOGO', 'CFA Franc BCEAO', 'XOF'),
(239, 'TOKELAU', 'New Zealand Dollar', 'NZD'),
(240, 'TONGA', 'Pa’anga', 'TOP'),
(241, 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago Dollar', 'TTD'),
(242, 'TUNISIA', 'Tunisian Dinar', 'TND'),
(243, 'TURKEY', 'Turkish Lira', 'TRY'),
(244, 'TURKMENISTAN', 'Turkmenistan New Manat', 'TMT'),
(245, 'TURKS AND CAICOS ISLANDS (THE)', 'US Dollar', 'USD'),
(246, 'TUVALU', 'Australian Dollar', 'AUD'),
(247, 'UGANDA', 'Uganda Shilling', 'UGX'),
(248, 'UKRAINE', 'Hryvnia', 'UAH'),
(249, 'UNITED ARAB EMIRATES (THE)', 'UAE Dirham', 'AED'),
(250, 'UNITED KINGDOM OF GREAT BRITAIN AND NORTHERN IRELAND (THE)', 'Pound Sterling', 'GBP'),
(251, 'UNITED STATES MINOR OUTLYING ISLANDS (THE)', 'US Dollar', 'USD'),
(252, 'UNITED STATES OF AMERICA (THE)', 'US Dollar', 'USD'),
(253, 'UNITED STATES OF AMERICA (THE)', 'US Dollar (Next day)', 'USN'),
(254, 'URUGUAY', 'Uruguay Peso en Unidades Indexadas (URUIURUI)', 'UYI'),
(255, 'URUGUAY', 'Peso Uruguayo', 'UYU'),
(256, 'UZBEKISTAN', 'Uzbekistan Sum', 'UZS'),
(257, 'VANUATU', 'Vatu', 'VUV'),
(258, 'VENEZUELA (BOLIVARIAN REPUBLIC OF)', 'Bolivar', 'VEF'),
(259, 'VIET NAM', 'Dong', 'VND'),
(260, 'VIRGIN ISLANDS (BRITISH)', 'US Dollar', 'USD'),
(261, 'VIRGIN ISLANDS (U.S.)', 'US Dollar', 'USD'),
(262, 'WALLIS AND FUTUNA', 'CFP Franc', 'XPF'),
(263, 'WESTERN SAHARA', 'Moroccan Dirham', 'MAD'),
(264, 'YEMEN', 'Yemeni Rial', 'YER'),
(265, 'ZAMBIA', 'Zambian Kwacha', 'ZMW'),
(266, 'ZIMBABWE', 'Zimbabwe Dollar', 'ZWL'),
(267, 'ÅLAND ISLANDS', 'Euro', 'EUR');

-- --------------------------------------------------------

--
-- Table structure for table `app_details`
--

DROP TABLE IF EXISTS `app_details`;
CREATE TABLE `app_details` (
  `id` int(11) NOT NULL,
  `company_code` varchar(10) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_address` varchar(200) DEFAULT NULL,
  `company_contact` varchar(50) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `session_prefix` varchar(10) NOT NULL,
  `email_protocol` varchar(10) DEFAULT NULL,
  `smtp_crypto` varchar(5) DEFAULT NULL,
  `smtp_host` varchar(50) DEFAULT NULL,
  `smtp_user` varchar(50) DEFAULT NULL,
  `smtp_pass` varchar(50) DEFAULT NULL,
  `smtp_port` int(11) DEFAULT NULL,
  `timezone_id` int(11) NOT NULL DEFAULT '292',
  `timer_countdown` int(11) NOT NULL DEFAULT '120' COMMENT 'seconds',
  `gst_percent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `currency_id` int(11) DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_details`
--

INSERT INTO `app_details` (`id`, `company_code`, `company_name`, `company_address`, `company_contact`, `contact_person`, `session_prefix`, `email_protocol`, `smtp_crypto`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `timezone_id`, `timer_countdown`, `gst_percent`, `currency_id`, `updated_by`, `dt_updated`) VALUES
(1, 'CI-3s', 'CI3 Starter', '', '', '', 'clinic', 'smtp', '', 'smtp.gmail.com', 'support@frabellefpg.com', '!!fpg!!fr@b3ll3!', 465, 290, 120, '0.00', 183, 1, '2020-09-11 04:36:43');

-- --------------------------------------------------------

--
-- Table structure for table `app_timezone`
--

DROP TABLE IF EXISTS `app_timezone`;
CREATE TABLE `app_timezone` (
  `id` int(11) NOT NULL,
  `country_code` varchar(5) NOT NULL,
  `zone` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_timezone`
--

INSERT INTO `app_timezone` (`id`, `country_code`, `zone`) VALUES
(1, 'AD', 'Europe/Andorra'),
(2, 'AE', 'Asia/Dubai'),
(3, 'AF', 'Asia/Kabul'),
(4, 'AG', 'America/Antigua'),
(5, 'AI', 'America/Anguilla'),
(6, 'AL', 'Europe/Tirane'),
(7, 'AM', 'Asia/Yerevan'),
(8, 'AO', 'Africa/Luanda'),
(9, 'AQ', 'Antarctica/McMurdo'),
(10, 'AQ', 'Antarctica/Casey'),
(11, 'AQ', 'Antarctica/Davis'),
(12, 'AQ', 'Antarctica/DumontDUrville'),
(13, 'AQ', 'Antarctica/Mawson'),
(14, 'AQ', 'Antarctica/Palmer'),
(15, 'AQ', 'Antarctica/Rothera'),
(16, 'AQ', 'Antarctica/Syowa'),
(17, 'AQ', 'Antarctica/Troll'),
(18, 'AQ', 'Antarctica/Vostok'),
(19, 'AR', 'America/Argentina/Buenos_Aires'),
(20, 'AR', 'America/Argentina/Cordoba'),
(21, 'AR', 'America/Argentina/Salta'),
(22, 'AR', 'America/Argentina/Jujuy'),
(23, 'AR', 'America/Argentina/Tucuman'),
(24, 'AR', 'America/Argentina/Catamarca'),
(25, 'AR', 'America/Argentina/La_Rioja'),
(26, 'AR', 'America/Argentina/San_Juan'),
(27, 'AR', 'America/Argentina/Mendoza'),
(28, 'AR', 'America/Argentina/San_Luis'),
(29, 'AR', 'America/Argentina/Rio_Gallegos'),
(30, 'AR', 'America/Argentina/Ushuaia'),
(31, 'AS', 'Pacific/Pago_Pago'),
(32, 'AT', 'Europe/Vienna'),
(33, 'AU', 'Australia/Lord_Howe'),
(34, 'AU', 'Antarctica/Macquarie'),
(35, 'AU', 'Australia/Hobart'),
(36, 'AU', 'Australia/Currie'),
(37, 'AU', 'Australia/Melbourne'),
(38, 'AU', 'Australia/Sydney'),
(39, 'AU', 'Australia/Broken_Hill'),
(40, 'AU', 'Australia/Brisbane'),
(41, 'AU', 'Australia/Lindeman'),
(42, 'AU', 'Australia/Adelaide'),
(43, 'AU', 'Australia/Darwin'),
(44, 'AU', 'Australia/Perth'),
(45, 'AU', 'Australia/Eucla'),
(46, 'AW', 'America/Aruba'),
(47, 'AX', 'Europe/Mariehamn'),
(48, 'AZ', 'Asia/Baku'),
(49, 'BA', 'Europe/Sarajevo'),
(50, 'BB', 'America/Barbados'),
(51, 'BD', 'Asia/Dhaka'),
(52, 'BE', 'Europe/Brussels'),
(53, 'BF', 'Africa/Ouagadougou'),
(54, 'BG', 'Europe/Sofia'),
(55, 'BH', 'Asia/Bahrain'),
(56, 'BI', 'Africa/Bujumbura'),
(57, 'BJ', 'Africa/Porto-Novo'),
(58, 'BL', 'America/St_Barthelemy'),
(59, 'BM', 'Atlantic/Bermuda'),
(60, 'BN', 'Asia/Brunei'),
(61, 'BO', 'America/La_Paz'),
(62, 'BQ', 'America/Kralendijk'),
(63, 'BR', 'America/Noronha'),
(64, 'BR', 'America/Belem'),
(65, 'BR', 'America/Fortaleza'),
(66, 'BR', 'America/Recife'),
(67, 'BR', 'America/Araguaina'),
(68, 'BR', 'America/Maceio'),
(69, 'BR', 'America/Bahia'),
(70, 'BR', 'America/Sao_Paulo'),
(71, 'BR', 'America/Campo_Grande'),
(72, 'BR', 'America/Cuiaba'),
(73, 'BR', 'America/Santarem'),
(74, 'BR', 'America/Porto_Velho'),
(75, 'BR', 'America/Boa_Vista'),
(76, 'BR', 'America/Manaus'),
(77, 'BR', 'America/Eirunepe'),
(78, 'BR', 'America/Rio_Branco'),
(79, 'BS', 'America/Nassau'),
(80, 'BT', 'Asia/Thimphu'),
(81, 'BW', 'Africa/Gaborone'),
(82, 'BY', 'Europe/Minsk'),
(83, 'BZ', 'America/Belize'),
(84, 'CA', 'America/St_Johns'),
(85, 'CA', 'America/Halifax'),
(86, 'CA', 'America/Glace_Bay'),
(87, 'CA', 'America/Moncton'),
(88, 'CA', 'America/Goose_Bay'),
(89, 'CA', 'America/Blanc-Sablon'),
(90, 'CA', 'America/Toronto'),
(91, 'CA', 'America/Nipigon'),
(92, 'CA', 'America/Thunder_Bay'),
(93, 'CA', 'America/Iqaluit'),
(94, 'CA', 'America/Pangnirtung'),
(95, 'CA', 'America/Atikokan'),
(96, 'CA', 'America/Winnipeg'),
(97, 'CA', 'America/Rainy_River'),
(98, 'CA', 'America/Resolute'),
(99, 'CA', 'America/Rankin_Inlet'),
(100, 'CA', 'America/Regina'),
(101, 'CA', 'America/Swift_Current'),
(102, 'CA', 'America/Edmonton'),
(103, 'CA', 'America/Cambridge_Bay'),
(104, 'CA', 'America/Yellowknife'),
(105, 'CA', 'America/Inuvik'),
(106, 'CA', 'America/Creston'),
(107, 'CA', 'America/Dawson_Creek'),
(108, 'CA', 'America/Fort_Nelson'),
(109, 'CA', 'America/Vancouver'),
(110, 'CA', 'America/Whitehorse'),
(111, 'CA', 'America/Dawson'),
(112, 'CC', 'Indian/Cocos'),
(113, 'CD', 'Africa/Kinshasa'),
(114, 'CD', 'Africa/Lubumbashi'),
(115, 'CF', 'Africa/Bangui'),
(116, 'CG', 'Africa/Brazzaville'),
(117, 'CH', 'Europe/Zurich'),
(118, 'CI', 'Africa/Abidjan'),
(119, 'CK', 'Pacific/Rarotonga'),
(120, 'CL', 'America/Santiago'),
(121, 'CL', 'America/Punta_Arenas'),
(122, 'CL', 'Pacific/Easter'),
(123, 'CM', 'Africa/Douala'),
(124, 'CN', 'Asia/Shanghai'),
(125, 'CN', 'Asia/Urumqi'),
(126, 'CO', 'America/Bogota'),
(127, 'CR', 'America/Costa_Rica'),
(128, 'CU', 'America/Havana'),
(129, 'CV', 'Atlantic/Cape_Verde'),
(130, 'CW', 'America/Curacao'),
(131, 'CX', 'Indian/Christmas'),
(132, 'CY', 'Asia/Nicosia'),
(133, 'CY', 'Asia/Famagusta'),
(134, 'CZ', 'Europe/Prague'),
(135, 'DE', 'Europe/Berlin'),
(136, 'DE', 'Europe/Busingen'),
(137, 'DJ', 'Africa/Djibouti'),
(138, 'DK', 'Europe/Copenhagen'),
(139, 'DM', 'America/Dominica'),
(140, 'DO', 'America/Santo_Domingo'),
(141, 'DZ', 'Africa/Algiers'),
(142, 'EC', 'America/Guayaquil'),
(143, 'EC', 'Pacific/Galapagos'),
(144, 'EE', 'Europe/Tallinn'),
(145, 'EG', 'Africa/Cairo'),
(146, 'EH', 'Africa/El_Aaiun'),
(147, 'ER', 'Africa/Asmara'),
(148, 'ES', 'Europe/Madrid'),
(149, 'ES', 'Africa/Ceuta'),
(150, 'ES', 'Atlantic/Canary'),
(151, 'ET', 'Africa/Addis_Ababa'),
(152, 'FI', 'Europe/Helsinki'),
(153, 'FJ', 'Pacific/Fiji'),
(154, 'FK', 'Atlantic/Stanley'),
(155, 'FM', 'Pacific/Chuuk'),
(156, 'FM', 'Pacific/Pohnpei'),
(157, 'FM', 'Pacific/Kosrae'),
(158, 'FO', 'Atlantic/Faroe'),
(159, 'FR', 'Europe/Paris'),
(160, 'GA', 'Africa/Libreville'),
(161, 'GB', 'Europe/London'),
(162, 'GD', 'America/Grenada'),
(163, 'GE', 'Asia/Tbilisi'),
(164, 'GF', 'America/Cayenne'),
(165, 'GG', 'Europe/Guernsey'),
(166, 'GH', 'Africa/Accra'),
(167, 'GI', 'Europe/Gibraltar'),
(168, 'GL', 'America/Godthab'),
(169, 'GL', 'America/Danmarkshavn'),
(170, 'GL', 'America/Scoresbysund'),
(171, 'GL', 'America/Thule'),
(172, 'GM', 'Africa/Banjul'),
(173, 'GN', 'Africa/Conakry'),
(174, 'GP', 'America/Guadeloupe'),
(175, 'GQ', 'Africa/Malabo'),
(176, 'GR', 'Europe/Athens'),
(177, 'GS', 'Atlantic/South_Georgia'),
(178, 'GT', 'America/Guatemala'),
(179, 'GU', 'Pacific/Guam'),
(180, 'GW', 'Africa/Bissau'),
(181, 'GY', 'America/Guyana'),
(182, 'HK', 'Asia/Hong_Kong'),
(183, 'HN', 'America/Tegucigalpa'),
(184, 'HR', 'Europe/Zagreb'),
(185, 'HT', 'America/Port-au-Prince'),
(186, 'HU', 'Europe/Budapest'),
(187, 'ID', 'Asia/Jakarta'),
(188, 'ID', 'Asia/Pontianak'),
(189, 'ID', 'Asia/Makassar'),
(190, 'ID', 'Asia/Jayapura'),
(191, 'IE', 'Europe/Dublin'),
(192, 'IL', 'Asia/Jerusalem'),
(193, 'IM', 'Europe/Isle_of_Man'),
(194, 'IN', 'Asia/Kolkata'),
(195, 'IO', 'Indian/Chagos'),
(196, 'IQ', 'Asia/Baghdad'),
(197, 'IR', 'Asia/Tehran'),
(198, 'IS', 'Atlantic/Reykjavik'),
(199, 'IT', 'Europe/Rome'),
(200, 'JE', 'Europe/Jersey'),
(201, 'JM', 'America/Jamaica'),
(202, 'JO', 'Asia/Amman'),
(203, 'JP', 'Asia/Tokyo'),
(204, 'KE', 'Africa/Nairobi'),
(205, 'KG', 'Asia/Bishkek'),
(206, 'KH', 'Asia/Phnom_Penh'),
(207, 'KI', 'Pacific/Tarawa'),
(208, 'KI', 'Pacific/Enderbury'),
(209, 'KI', 'Pacific/Kiritimati'),
(210, 'KM', 'Indian/Comoro'),
(211, 'KN', 'America/St_Kitts'),
(212, 'KP', 'Asia/Pyongyang'),
(213, 'KR', 'Asia/Seoul'),
(214, 'KW', 'Asia/Kuwait'),
(215, 'KY', 'America/Cayman'),
(216, 'KZ', 'Asia/Almaty'),
(217, 'KZ', 'Asia/Qyzylorda'),
(218, 'KZ', 'Asia/Qostanay'),
(219, 'KZ', 'Asia/Aqtobe'),
(220, 'KZ', 'Asia/Aqtau'),
(221, 'KZ', 'Asia/Atyrau'),
(222, 'KZ', 'Asia/Oral'),
(223, 'LA', 'Asia/Vientiane'),
(224, 'LB', 'Asia/Beirut'),
(225, 'LC', 'America/St_Lucia'),
(226, 'LI', 'Europe/Vaduz'),
(227, 'LK', 'Asia/Colombo'),
(228, 'LR', 'Africa/Monrovia'),
(229, 'LS', 'Africa/Maseru'),
(230, 'LT', 'Europe/Vilnius'),
(231, 'LU', 'Europe/Luxembourg'),
(232, 'LV', 'Europe/Riga'),
(233, 'LY', 'Africa/Tripoli'),
(234, 'MA', 'Africa/Casablanca'),
(235, 'MC', 'Europe/Monaco'),
(236, 'MD', 'Europe/Chisinau'),
(237, 'ME', 'Europe/Podgorica'),
(238, 'MF', 'America/Marigot'),
(239, 'MG', 'Indian/Antananarivo'),
(240, 'MH', 'Pacific/Majuro'),
(241, 'MH', 'Pacific/Kwajalein'),
(242, 'MK', 'Europe/Skopje'),
(243, 'ML', 'Africa/Bamako'),
(244, 'MM', 'Asia/Yangon'),
(245, 'MN', 'Asia/Ulaanbaatar'),
(246, 'MN', 'Asia/Hovd'),
(247, 'MN', 'Asia/Choibalsan'),
(248, 'MO', 'Asia/Macau'),
(249, 'MP', 'Pacific/Saipan'),
(250, 'MQ', 'America/Martinique'),
(251, 'MR', 'Africa/Nouakchott'),
(252, 'MS', 'America/Montserrat'),
(253, 'MT', 'Europe/Malta'),
(254, 'MU', 'Indian/Mauritius'),
(255, 'MV', 'Indian/Maldives'),
(256, 'MW', 'Africa/Blantyre'),
(257, 'MX', 'America/Mexico_City'),
(258, 'MX', 'America/Cancun'),
(259, 'MX', 'America/Merida'),
(260, 'MX', 'America/Monterrey'),
(261, 'MX', 'America/Matamoros'),
(262, 'MX', 'America/Mazatlan'),
(263, 'MX', 'America/Chihuahua'),
(264, 'MX', 'America/Ojinaga'),
(265, 'MX', 'America/Hermosillo'),
(266, 'MX', 'America/Tijuana'),
(267, 'MX', 'America/Bahia_Banderas'),
(268, 'MY', 'Asia/Kuala_Lumpur'),
(269, 'MY', 'Asia/Kuching'),
(270, 'MZ', 'Africa/Maputo'),
(271, 'NA', 'Africa/Windhoek'),
(272, 'NC', 'Pacific/Noumea'),
(273, 'NE', 'Africa/Niamey'),
(274, 'NF', 'Pacific/Norfolk'),
(275, 'NG', 'Africa/Lagos'),
(276, 'NI', 'America/Managua'),
(277, 'NL', 'Europe/Amsterdam'),
(278, 'NO', 'Europe/Oslo'),
(279, 'NP', 'Asia/Kathmandu'),
(280, 'NR', 'Pacific/Nauru'),
(281, 'NU', 'Pacific/Niue'),
(282, 'NZ', 'Pacific/Auckland'),
(283, 'NZ', 'Pacific/Chatham'),
(284, 'OM', 'Asia/Muscat'),
(285, 'PA', 'America/Panama'),
(286, 'PE', 'America/Lima'),
(287, 'PF', 'Pacific/Tahiti'),
(288, 'PF', 'Pacific/Marquesas'),
(289, 'PF', 'Pacific/Gambier'),
(290, 'PG', 'Pacific/Port_Moresby'),
(291, 'PG', 'Pacific/Bougainville'),
(292, 'PH', 'Asia/Manila'),
(293, 'PK', 'Asia/Karachi'),
(294, 'PL', 'Europe/Warsaw'),
(295, 'PM', 'America/Miquelon'),
(296, 'PN', 'Pacific/Pitcairn'),
(297, 'PR', 'America/Puerto_Rico'),
(298, 'PS', 'Asia/Gaza'),
(299, 'PS', 'Asia/Hebron'),
(300, 'PT', 'Europe/Lisbon'),
(301, 'PT', 'Atlantic/Madeira'),
(302, 'PT', 'Atlantic/Azores'),
(303, 'PW', 'Pacific/Palau'),
(304, 'PY', 'America/Asuncion'),
(305, 'QA', 'Asia/Qatar'),
(306, 'RE', 'Indian/Reunion'),
(307, 'RO', 'Europe/Bucharest'),
(308, 'RS', 'Europe/Belgrade'),
(309, 'RU', 'Europe/Kaliningrad'),
(310, 'RU', 'Europe/Moscow'),
(311, 'UA', 'Europe/Simferopol'),
(312, 'RU', 'Europe/Kirov'),
(313, 'RU', 'Europe/Astrakhan'),
(314, 'RU', 'Europe/Volgograd'),
(315, 'RU', 'Europe/Saratov'),
(316, 'RU', 'Europe/Ulyanovsk'),
(317, 'RU', 'Europe/Samara'),
(318, 'RU', 'Asia/Yekaterinburg'),
(319, 'RU', 'Asia/Omsk'),
(320, 'RU', 'Asia/Novosibirsk'),
(321, 'RU', 'Asia/Barnaul'),
(322, 'RU', 'Asia/Tomsk'),
(323, 'RU', 'Asia/Novokuznetsk'),
(324, 'RU', 'Asia/Krasnoyarsk'),
(325, 'RU', 'Asia/Irkutsk'),
(326, 'RU', 'Asia/Chita'),
(327, 'RU', 'Asia/Yakutsk'),
(328, 'RU', 'Asia/Khandyga'),
(329, 'RU', 'Asia/Vladivostok'),
(330, 'RU', 'Asia/Ust-Nera'),
(331, 'RU', 'Asia/Magadan'),
(332, 'RU', 'Asia/Sakhalin'),
(333, 'RU', 'Asia/Srednekolymsk'),
(334, 'RU', 'Asia/Kamchatka'),
(335, 'RU', 'Asia/Anadyr'),
(336, 'RW', 'Africa/Kigali'),
(337, 'SA', 'Asia/Riyadh'),
(338, 'SB', 'Pacific/Guadalcanal'),
(339, 'SC', 'Indian/Mahe'),
(340, 'SD', 'Africa/Khartoum'),
(341, 'SE', 'Europe/Stockholm'),
(342, 'SG', 'Asia/Singapore'),
(343, 'SH', 'Atlantic/St_Helena'),
(344, 'SI', 'Europe/Ljubljana'),
(345, 'SJ', 'Arctic/Longyearbyen'),
(346, 'SK', 'Europe/Bratislava'),
(347, 'SL', 'Africa/Freetown'),
(348, 'SM', 'Europe/San_Marino'),
(349, 'SN', 'Africa/Dakar'),
(350, 'SO', 'Africa/Mogadishu'),
(351, 'SR', 'America/Paramaribo'),
(352, 'SS', 'Africa/Juba'),
(353, 'ST', 'Africa/Sao_Tome'),
(354, 'SV', 'America/El_Salvador'),
(355, 'SX', 'America/Lower_Princes'),
(356, 'SY', 'Asia/Damascus'),
(357, 'SZ', 'Africa/Mbabane'),
(358, 'TC', 'America/Grand_Turk'),
(359, 'TD', 'Africa/Ndjamena'),
(360, 'TF', 'Indian/Kerguelen'),
(361, 'TG', 'Africa/Lome'),
(362, 'TH', 'Asia/Bangkok'),
(363, 'TJ', 'Asia/Dushanbe'),
(364, 'TK', 'Pacific/Fakaofo'),
(365, 'TL', 'Asia/Dili'),
(366, 'TM', 'Asia/Ashgabat'),
(367, 'TN', 'Africa/Tunis'),
(368, 'TO', 'Pacific/Tongatapu'),
(369, 'TR', 'Europe/Istanbul'),
(370, 'TT', 'America/Port_of_Spain'),
(371, 'TV', 'Pacific/Funafuti'),
(372, 'TW', 'Asia/Taipei'),
(373, 'TZ', 'Africa/Dar_es_Salaam'),
(374, 'UA', 'Europe/Kiev'),
(375, 'UA', 'Europe/Uzhgorod'),
(376, 'UA', 'Europe/Zaporozhye'),
(377, 'UG', 'Africa/Kampala'),
(378, 'UM', 'Pacific/Midway'),
(379, 'UM', 'Pacific/Wake'),
(380, 'US', 'America/New_York'),
(381, 'US', 'America/Detroit'),
(382, 'US', 'America/Kentucky/Louisville'),
(383, 'US', 'America/Kentucky/Monticello'),
(384, 'US', 'America/Indiana/Indianapolis'),
(385, 'US', 'America/Indiana/Vincennes'),
(386, 'US', 'America/Indiana/Winamac'),
(387, 'US', 'America/Indiana/Marengo'),
(388, 'US', 'America/Indiana/Petersburg'),
(389, 'US', 'America/Indiana/Vevay'),
(390, 'US', 'America/Chicago'),
(391, 'US', 'America/Indiana/Tell_City'),
(392, 'US', 'America/Indiana/Knox'),
(393, 'US', 'America/Menominee'),
(394, 'US', 'America/North_Dakota/Center'),
(395, 'US', 'America/North_Dakota/New_Salem'),
(396, 'US', 'America/North_Dakota/Beulah'),
(397, 'US', 'America/Denver'),
(398, 'US', 'America/Boise'),
(399, 'US', 'America/Phoenix'),
(400, 'US', 'America/Los_Angeles'),
(401, 'US', 'America/Anchorage'),
(402, 'US', 'America/Juneau'),
(403, 'US', 'America/Sitka'),
(404, 'US', 'America/Metlakatla'),
(405, 'US', 'America/Yakutat'),
(406, 'US', 'America/Nome'),
(407, 'US', 'America/Adak'),
(408, 'US', 'Pacific/Honolulu'),
(409, 'UY', 'America/Montevideo'),
(410, 'UZ', 'Asia/Samarkand'),
(411, 'UZ', 'Asia/Tashkent'),
(412, 'VA', 'Europe/Vatican'),
(413, 'VC', 'America/St_Vincent'),
(414, 'VE', 'America/Caracas'),
(415, 'VG', 'America/Tortola'),
(416, 'VI', 'America/St_Thomas'),
(417, 'VN', 'Asia/Ho_Chi_Minh'),
(418, 'VU', 'Pacific/Efate'),
(419, 'WF', 'Pacific/Wallis'),
(420, 'WS', 'Pacific/Apia'),
(421, 'YE', 'Asia/Aden'),
(422, 'YT', 'Indian/Mayotte'),
(423, 'ZA', 'Africa/Johannesburg'),
(424, 'ZM', 'Africa/Lusaka'),
(425, 'ZW', 'Africa/Harare');

-- --------------------------------------------------------

--
-- Table structure for table `app_version`
--

DROP TABLE IF EXISTS `app_version`;
CREATE TABLE `app_version` (
  `id` int(11) NOT NULL,
  `version_no` varchar(20) NOT NULL,
  `version_description` text NOT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_version`
--

INSERT INTO `app_version` (`id`, `version_no`, `version_description`, `dt_updated`, `updated_by`) VALUES
(1, '2020.05.10', '* Initial Release', '2020-04-01 06:02:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sender_id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `dt`, `sender_id`, `msg`, `status_id`) VALUES
(1, '2020-07-26 00:45:28', 1, 'test', 2),
(2, '2020-07-26 00:46:21', 1, 'test2', 2),
(3, '2020-07-26 00:46:32', 1, 'test3', 2),
(4, '2020-07-26 00:46:38', 1, 'hellow world', 2),
(5, '2020-07-26 00:47:18', 1, 'hello worl', 2),
(6, '2020-07-26 00:47:22', 1, 'test', 2);

-- --------------------------------------------------------

--
-- Table structure for table `chat_status`
--

DROP TABLE IF EXISTS `chat_status`;
CREATE TABLE `chat_status` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat_status`
--

INSERT INTO `chat_status` (`id`, `status`) VALUES
(2, 'ACTIVE'),
(1, 'DELETED');

-- --------------------------------------------------------

--
-- Table structure for table `log_login`
--

DROP TABLE IF EXISTS `log_login`;
CREATE TABLE `log_login` (
  `id` int(11) NOT NULL,
  `dt` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `local_ip` varchar(64) DEFAULT NULL,
  `public_ip` varchar(64) DEFAULT NULL,
  `computer_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `queue_status`
--

DROP TABLE IF EXISTS `queue_status`;
CREATE TABLE `queue_status` (
  `queue_status_id` int(11) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `queue_status`
--

INSERT INTO `queue_status` (`queue_status_id`, `status`) VALUES
(2, 'CALLING'),
(4, 'DONE'),
(3, 'SERVING'),
(1, 'WAITING');

-- --------------------------------------------------------

--
-- Table structure for table `trail_db_backup`
--

DROP TABLE IF EXISTS `trail_db_backup`;
CREATE TABLE `trail_db_backup` (
  `id` bigint(20) NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(100) DEFAULT NULL,
  `performed_by` int(11) NOT NULL DEFAULT '0',
  `status_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trail_db_restore`
--

DROP TABLE IF EXISTS `trail_db_restore`;
CREATE TABLE `trail_db_restore` (
  `id` bigint(20) NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(100) DEFAULT NULL,
  `performed_by` int(11) NOT NULL DEFAULT '0',
  `status_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trail_db_status`
--

DROP TABLE IF EXISTS `trail_db_status`;
CREATE TABLE `trail_db_status` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trail_db_status`
--

INSERT INTO `trail_db_status` (`id`, `status`) VALUES
(2, 'COMPLETED'),
(1, 'STARTED');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL DEFAULT '',
  `position` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `fname`, `lname`, `mname`, `position`, `email`, `role_id`, `status_id`, `created_by`, `date_created`) VALUES
(1, 'jaypee.hindang', '$2y$12$w7Gc5KyU4VvcAZiKf/IDfOF48kY4Hw1/Ggwnj3wqiOJASbOTuBIKe', 'jaypee', 'hindang', '', NULL, 'eujay_29@yahoo.com.ph', 1, 1, 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_status`
--

DROP TABLE IF EXISTS `user_status`;
CREATE TABLE `user_status` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_status`
--

INSERT INTO `user_status` (`id`, `status`) VALUES
(1, 'ACTIVE'),
(2, 'INACTIVE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_mod_perm`
--
ALTER TABLE `admin_mod_perm`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_id` (`role_id`,`module_id`,`permission_id`);

--
-- Indexes for table `admin_module`
--
ALTER TABLE `admin_module`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `module_name` (`module_name`);

--
-- Indexes for table `admin_parent`
--
ALTER TABLE `admin_parent`
  ADD PRIMARY KEY (`parent_id`),
  ADD UNIQUE KEY `parent_name` (`parent_name`),
  ADD UNIQUE KEY `parent_order` (`parent_order`);

--
-- Indexes for table `admin_permission`
--
ALTER TABLE `admin_permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission` (`permission`);

--
-- Indexes for table `admin_role`
--
ALTER TABLE `admin_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `app_currency`
--
ALTER TABLE `app_currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_details`
--
ALTER TABLE `app_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_timezone`
--
ALTER TABLE `app_timezone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_version`
--
ALTER TABLE `app_version`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `version_no` (`version_no`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_status`
--
ALTER TABLE `chat_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status` (`status`);

--
-- Indexes for table `log_login`
--
ALTER TABLE `log_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue_status`
--
ALTER TABLE `queue_status`
  ADD PRIMARY KEY (`queue_status_id`),
  ADD UNIQUE KEY `status` (`status`);

--
-- Indexes for table `trail_db_backup`
--
ALTER TABLE `trail_db_backup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trail_db_restore`
--
ALTER TABLE `trail_db_restore`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trail_db_status`
--
ALTER TABLE `trail_db_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status` (`status`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_mod_perm`
--
ALTER TABLE `admin_mod_perm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `admin_module`
--
ALTER TABLE `admin_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `admin_parent`
--
ALTER TABLE `admin_parent`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `admin_permission`
--
ALTER TABLE `admin_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `admin_role`
--
ALTER TABLE `admin_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `app_currency`
--
ALTER TABLE `app_currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;
--
-- AUTO_INCREMENT for table `app_details`
--
ALTER TABLE `app_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `app_timezone`
--
ALTER TABLE `app_timezone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=426;
--
-- AUTO_INCREMENT for table `app_version`
--
ALTER TABLE `app_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `chat_status`
--
ALTER TABLE `chat_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `log_login`
--
ALTER TABLE `log_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `queue_status`
--
ALTER TABLE `queue_status`
  MODIFY `queue_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `trail_db_backup`
--
ALTER TABLE `trail_db_backup`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trail_db_restore`
--
ALTER TABLE `trail_db_restore`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trail_db_status`
--
ALTER TABLE `trail_db_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_status`
--
ALTER TABLE `user_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
