-- Package:   SmartOrder for Joomla 3.x
-- Author:    Organik Online Media Ltd.
-- Copyright: Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
-- License:   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
-- See:       LICENSE.txt

CREATE TABLE IF NOT EXISTS `#__smartorder_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `ordering` int(11) DEFAULT '0',
  `published` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `IX_ordering` (`ordering`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

INSERT INTO `#__smartorder_categories` (`id`, `name`, `ordering`, `published`) VALUES
(1, 'Pizza', 3, 1),
(3, 'Salad', 5, 1),
(40, 'Pasta', 4, 1),
(34, 'Hamburger', 6, 1),
(39, 'Drinks', 31, 1);

CREATE TABLE IF NOT EXISTS `#__smartorder_currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` char(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=116 ;

INSERT INTO `#__smartorder_currency` (`id`, `code`, `name`, `symbol`) VALUES
(1, 'ALL', 'Albania Lek', 'Lek'),
(2, 'AFN', 'Afghanistan Afghani', '؋'),
(3, 'ARS', 'Argentina Peso', '$'),
(4, 'AWG', 'Aruba Guilder', 'ƒ'),
(5, 'AUD', 'Australia Dollar', '$'),
(6, 'AZN', 'Azerbaijan New Manat', 'ман'),
(7, 'BSD', 'Bahamas Dollar', '$'),
(8, 'BBD', 'Barbados Dollar', '$'),
(9, 'BYR', 'Belarus Ruble', 'p.'),
(10, 'BZD', 'Belize Dollar', 'BZ$'),
(11, 'BMD', 'Bermuda Dollar', '$'),
(12, 'BOB', 'Bolivia Boliviano', '$b'),
(13, 'BAM', 'Bosnia and Herzegovina Convertible Marka', 'KM'),
(14, 'BWP', 'Botswana Pula', 'P'),
(15, 'BGN', 'Bulgaria Lev', 'лв'),
(16, 'BRL', 'Brazil Real', 'R$'),
(17, 'BND', 'Brunei Darussalam Dollar', '$'),
(18, 'KHR', 'Cambodia Riel', '៛'),
(19, 'CAD', 'Canada Dollar', '$'),
(20, 'KYD', 'Cayman Islands Dollar', '$'),
(21, 'CLP', 'Chile Peso', '$'),
(22, 'CNY', 'China Yuan Renminbi', '¥'),
(23, 'COP', 'Colombia Peso', '$'),
(24, 'CRC', 'Costa Rica Colon', '₡'),
(25, 'HRK', 'Croatia Kuna', 'kn'),
(26, 'CUP', 'Cuba Peso', '₱'),
(27, 'CZK', 'Czech Republic Koruna', 'Kč'),
(28, 'DKK', 'Denmark Krone', 'kr'),
(29, 'DOP', 'Dominican Republic Peso', 'RD$'),
(30, 'XCD', 'East Caribbean Dollar', '$'),
(31, 'EGP', 'Egypt Pound', '£'),
(32, 'SVC', 'El Salvador Colon', '$'),
(33, 'EEK', 'Estonia Kroon', 'kr'),
(34, 'EUR', 'Euro Member Countries', '€'),
(35, 'FKP', 'Falkland Islands (Malvinas) Pound', '£'),
(36, 'FJD', 'Fiji Dollar', '$'),
(37, 'GHC', 'Ghana Cedis', '¢'),
(38, 'GIP', 'Gibraltar Pound', '£'),
(39, 'GTQ', 'Guatemala Quetzal', 'Q'),
(40, 'GGP', 'Guernsey Pound', '£'),
(41, 'GYD', 'Guyana Dollar', '$'),
(42, 'HNL', 'Honduras Lempira', 'L'),
(43, 'HKD', 'Hong Kong Dollar', '$'),
(44, 'HUF', 'Hungary Forint', 'Ft'),
(45, 'ISK', 'Iceland Krona', 'kr'),
(46, 'INR', 'India Rupee', ''),
(47, 'IDR', 'Indonesia Rupiah', 'Rp'),
(48, 'IRR', 'Iran Rial', '﷼'),
(49, 'IMP', 'Isle of Man Pound', '£'),
(50, 'ILS', 'Israel Shekel', '₪'),
(51, 'JMD', 'Jamaica Dollar', 'J$'),
(52, 'JPY', 'Japan Yen', '¥'),
(53, 'JEP', 'Jersey Pound', '£'),
(54, 'KZT', 'Kazakhstan Tenge', 'лв'),
(55, 'KPW', 'Korea (North) Won', '₩'),
(56, 'KRW', 'Korea (South) Won', '₩'),
(57, 'KGS', 'Kyrgyzstan Som', 'лв'),
(58, 'LAK', 'Laos Kip', '₭'),
(59, 'LVL', 'Latvia Lat', 'Ls'),
(60, 'LBP', 'Lebanon Pound', '£'),
(61, 'LRD', 'Liberia Dollar', '$'),
(62, 'LTL', 'Lithuania Litas', 'Lt'),
(63, 'MKD', 'Macedonia Denar', 'ден'),
(64, 'MYR', 'Malaysia Ringgit', 'RM'),
(65, 'MUR', 'Mauritius Rupee', '₨'),
(66, 'MXN', 'Mexico Peso', '$'),
(67, 'MNT', 'Mongolia Tughrik', '₮'),
(68, 'MZN', 'Mozambique Metical', 'MT'),
(69, 'NAD', 'Namibia Dollar', '$'),
(70, 'NPR', 'Nepal Rupee', '₨'),
(71, 'ANG', 'Netherlands Antilles Guilder', 'ƒ'),
(72, 'NZD', 'New Zealand Dollar', '$'),
(73, 'NIO', 'Nicaragua Cordoba', 'C$'),
(74, 'NGN', 'Nigeria Naira', '₦'),
(76, 'NOK', 'Norway Krone', 'kr'),
(77, 'OMR', 'Oman Rial', '﷼'),
(78, 'PKR', 'Pakistan Rupee', '₨'),
(79, 'PAB', 'Panama Balboa', 'B/.'),
(80, 'PYG', 'Paraguay Guarani', 'Gs'),
(81, 'PEN', 'Peru Nuevo Sol', 'S/.'),
(82, 'PHP', 'Philippines Peso', '₱'),
(83, 'PLN', 'Poland Zloty', 'zł'),
(84, 'QAR', 'Qatar Riyal', '﷼'),
(85, 'RON', 'Romania New Leu', 'lei'),
(86, 'RUB', 'Russia Ruble', 'руб'),
(87, 'SHP', 'Saint Helena Pound', '£'),
(88, 'SAR', 'Saudi Arabia Riyal', '﷼'),
(89, 'RSD', 'Serbia Dinar', 'Дин.'),
(90, 'SCR', 'Seychelles Rupee', '₨'),
(91, 'SGD', 'Singapore Dollar', '$'),
(92, 'SBD', 'Solomon Islands Dollar', '$'),
(93, 'SOS', 'Somalia Shilling', 'S'),
(94, 'ZAR', 'South Africa Rand', 'R'),
(96, 'LKR', 'Sri Lanka Rupee', '₨'),
(97, 'SEK', 'Sweden Krona', 'kr'),
(98, 'CHF', 'Switzerland Franc', 'CHF'),
(99, 'SRD', 'Suriname Dollar', '$'),
(100, 'SYP', 'Syria Pound', '£'),
(101, 'TWD', 'Taiwan New Dollar', 'NT$'),
(102, 'THB', 'Thailand Baht', '฿'),
(103, 'TTD', 'Trinidad and Tobago Dollar', 'TT$'),
(104, 'TRY', 'Turkey Lira', ''),
(105, 'TRL', 'Turkey Lira', '₤'),
(106, 'TVD', 'Tuvalu Dollar', '$'),
(107, 'UAH', 'Ukraine Hryvna', '₴'),
(108, 'GBP', 'United Kingdom Pound', '£'),
(109, 'USD', 'United States Dollar', '$'),
(110, 'UYU', 'Uruguay Peso', '$U'),
(111, 'UZS', 'Uzbekistan Som', 'лв'),
(112, 'VEF', 'Venezuela Bolivar', 'Bs'),
(113, 'VND', 'Viet Nam Dong', '₫'),
(114, 'YER', 'Yemen Rial', '﷼'),
(115, 'ZWD', 'Zimbabwe Dollar', 'Z$');

CREATE TABLE IF NOT EXISTS `#__smartorder_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` text,
  `price` float(12,5) DEFAULT NULL,
  `discount_price` float(12,5) DEFAULT NULL,
  `published` tinyint(1) DEFAULT '1',
  `ordering` int(11) DEFAULT '0',
  `vat_percent` float(12,5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_` (`cat_id`),
  KEY `ordering` (`ordering`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

INSERT INTO `#__smartorder_items` (`id`, `cat_id`, `name`, `description`, `price`, `discount_price`, `published`, `ordering`, `vat_percent`) VALUES
(1, 1, 'Margarita', 'tomato, basil base, mozzarella ', 10.00000, 10.00000, 1, 0, NULL),
(2, 1, 'Tarantella', 'bocconcini, semi dried tomato, mushroom, chilli', 10.00000, 10.00000, 1, 0, NULL),
(3, 1, 'Cheese Lovers', 'feta, gorgonzola, mozzarella, shaved parmesan', 12.50000, 12.50000, 1, 0, NULL),
(4, 1, 'Mediterranean Chicken', 'chicken, avocado, sun dried tomato', 12.50000, 12.50000, 1, 0, NULL),
(5, 1, 'Frutti di Mare', 'prawns scallops, calamari, fish, anchovies', 15.00000, 15.00000, 1, 0, NULL),
(8, 40, 'The Indian Pasta', 'tomato sauce, mushrooms, curried chicken, peppers, mozzarella', 15.00000, 15.00000, 1, 0, NULL),
(9, 40, 'The Atlantic Pasta', 'tuna, fresh cream, mozzarella, basil, citron', 15.00000, 15.00000, 1, 0, NULL),
(10, 40, 'Fruits de mer Pasta', 'tomato, mushrooms, mussels, prawns, shellfish, crab, í', 11.50000, 11.50000, 1, 0, NULL),
(14, 39, 'Coca Cola Light 0.33l', 'without sugar', 3.00000, 3.00000, 1, 0, NULL),
(15, 39, 'Coca Cola 0.33l', 'the big classic', 3.00000, 3.00000, 1, 0, NULL),
(16, 39, 'Green tea 0.5l', 'based on our special receipt ', 5.00000, 5.00000, 1, 0, NULL),
(18, 3, 'Green salad', 'lettuce, tomato, onions, cucumber, egg, olives & green peppers', 8.00000, 8.00000, 1, 0, NULL),
(19, 3, 'Diet Delight Salad', 'turkey, lettuce, tomato, green pepper, egg, cucumber, olives & onions', 9.00000, 9.00000, 1, 0, NULL),
(20, 3, 'Caesar Salad', 'Crisp romaine lettuce croutons and special caesar dressing', 11.00000, 11.00000, 1, 0, NULL);

CREATE TABLE IF NOT EXISTS `#__smartorder_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(250) DEFAULT NULL,
  `user_email` varchar(250) DEFAULT NULL,
  `user_address` varchar(250) DEFAULT NULL,
  `user_phone` varchar(100) DEFAULT NULL,
  `user_note` text,
  `shipping_costs` float(12,5) NOT NULL DEFAULT '0.00000',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__smartorder_orders_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `basketgroup` int(11) DEFAULT NULL,
  `type` enum('i','t') DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `price` float(12,5) DEFAULT NULL,
  `discount_price` float(12,5) DEFAULT NULL,
  `category_name` varchar(250) DEFAULT NULL,
  `status` char(1) DEFAULT '0',
  `vat_percent` float(12,5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__smartorder_orders_status` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `fontcolor` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `#__smartorder_orders_status` (`id`, `name`, `ordering`, `fontcolor`) VALUES
(0, 'New order', 0, '#D76B00'),
(9, 'Closed order', 1, '#666'),
(10, 'Payment pending', 2, '#c600ff'),
(11, 'Payment failed', 3, '#f00'),
(12, 'Payment successful', 4, '#3f9e00');

CREATE TABLE IF NOT EXISTS `#__smartorder_paypal_ipn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `txn_id` varchar(255) NOT NULL,
  `payer_email` varchar(255) NOT NULL,
  `payer_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `mc_gross` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `raw` text NOT NULL,
  `status` enum('pending','verified','invalid','fraud','duplicate','closed') NOT NULL DEFAULT 'pending',
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `#__smartorder_paypal_settings` (
  `business` varchar(255) NOT NULL,
  `sandbox_mode` tinyint(1) NOT NULL,
  `header_image_url` text NOT NULL,
  `use_shipping_info` tinyint(1) NOT NULL,
  `order_status_successful` varchar(255) NOT NULL,
  `order_status_pending` varchar(255) NOT NULL,
  `order_status_failed` varchar(255) NOT NULL,
  `return_url` text NOT NULL,
  `cancel_url` text NOT NULL,
  `currency` char(3) NOT NULL,
  `checkout_language` varchar(5) NOT NULL,
  `send_gross_prices` tinyint(1) NOT NULL,
  `mail_to_buyer` tinyint(1) NOT NULL,
  `mail_to_merchant` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `#__smartorder_paypal_settings` (`business`, `sandbox_mode`, `header_image_url`, `use_shipping_info`, `order_status_successful`, `order_status_pending`, `order_status_failed`, `return_url`, `cancel_url`, `currency`, `checkout_language`, `send_gross_prices`, `mail_to_buyer`, `mail_to_merchant`) VALUES
('', 1, '', 1, 'Payment successful', 'Payment pending', 'Payment failed', '', '', 'USD', 'US', 1, 1, 1);

CREATE TABLE IF NOT EXISTS `#__smartorder_settings` (
  `id` int(11) NOT NULL,
  `minimum_order_price` float(12,5) DEFAULT NULL,
  `shipping_cost` float(12,5) DEFAULT NULL,
  `free_shipping_limit` float(12,5) DEFAULT NULL,
  `currency_symbol` varchar(20) DEFAULT NULL,
  `currency_display` varchar(10) DEFAULT NULL,
  `currency_decimal` tinyint(4) DEFAULT NULL,
  `currency_decimal_symbol` char(1) DEFAULT NULL,
  `currency_thousand_separator` char(1) DEFAULT NULL,
  `orderform_default_items` tinyint(4) DEFAULT NULL,
  `orderform_default_infotext` varchar(250) DEFAULT NULL,
  `termsofservice_url` varchar(255) DEFAULT NULL,
  `vat_handling` tinyint(4) DEFAULT NULL,
  `vat_default_percent` float(12,5) DEFAULT NULL,
  `payment_methods` varchar(255) NOT NULL,
  `open_Mon_from_H` tinyint(4) NOT NULL,
  `open_Mon_from_M` tinyint(4) NOT NULL,
  `open_Mon_to_H` tinyint(4) NOT NULL,
  `open_Mon_to_M` tinyint(4) NOT NULL,
  `open_Tue_from_H` tinyint(4) NOT NULL,
  `open_Tue_from_M` tinyint(4) NOT NULL,
  `open_Tue_to_H` tinyint(4) NOT NULL,
  `open_Tue_to_M` tinyint(4) NOT NULL,
  `open_Wed_from_H` tinyint(4) NOT NULL,
  `open_Wed_from_M` tinyint(4) NOT NULL,
  `open_Wed_to_H` tinyint(4) NOT NULL,
  `open_Wed_to_M` tinyint(4) NOT NULL,
  `open_Thu_from_H` tinyint(4) NOT NULL,
  `open_Thu_from_M` tinyint(4) NOT NULL,
  `open_Thu_to_H` tinyint(4) NOT NULL,
  `open_Thu_to_M` tinyint(4) NOT NULL,
  `open_Fri_from_H` tinyint(4) NOT NULL,
  `open_Fri_from_M` tinyint(4) NOT NULL,
  `open_Fri_to_H` tinyint(4) NOT NULL,
  `open_Fri_to_M` tinyint(4) NOT NULL,
  `open_Sat_from_H` tinyint(4) NOT NULL,
  `open_Sat_from_M` tinyint(4) NOT NULL,
  `open_Sat_to_H` tinyint(4) NOT NULL,
  `open_Sat_to_M` tinyint(4) NOT NULL,
  `open_Sun_from_H` tinyint(4) NOT NULL,
  `open_Sun_from_M` tinyint(4) NOT NULL,
  `open_Sun_to_H` tinyint(4) NOT NULL,
  `open_Sun_to_M` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `#__smartorder_settings` (`id`, `minimum_order_price`, `shipping_cost`, `free_shipping_limit`, `currency_symbol`, `currency_display`, `currency_decimal`, `currency_decimal_symbol`, `currency_thousand_separator`, `orderform_default_items`, `orderform_default_infotext`, `termsofservice_url`, `vat_handling`, `vat_default_percent`, `payment_methods`, `open_Mon_from_H`, `open_Mon_from_M`, `open_Mon_to_H`, `open_Mon_to_M`, `open_Tue_from_H`, `open_Tue_from_M`, `open_Tue_to_H`, `open_Tue_to_M`, `open_Wed_from_H`, `open_Wed_from_M`, `open_Wed_to_H`, `open_Wed_to_M`, `open_Thu_from_H`, `open_Thu_from_M`, `open_Thu_to_H`, `open_Thu_to_M`, `open_Fri_from_H`, `open_Fri_from_M`, `open_Fri_to_H`, `open_Fri_to_M`, `open_Sat_from_H`, `open_Sat_from_M`, `open_Sat_to_H`, `open_Sat_to_M`, `open_Sun_from_H`, `open_Sun_from_M`, `open_Sun_to_H`, `open_Sun_to_M`) VALUES
(1, 20.00000, 0.00000, 0.00000, '$', 'Symb_00', 2, ',', '_', 4, 'Set up your order! You can use the dropdowns on the left to select foods and drinks. Of course you can browse the menu bellow and click on the buttons to add these items to your basket.', 'index.php/terms-of-use', 1, 25.00000, 'payondelivery,paypal', 8, 0, 23, 0, 8, 0, 23, 0, 8, 0, 23, 0, 8, 0, 23, 0, 8, 0, 23, 0, 8, 0, 23, 0, 8, 0, 23, 0);

CREATE TABLE IF NOT EXISTS `#__smartorder_toppings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` text,
  `price` float(12,5) DEFAULT NULL,
  `discount_price` float(12,5) DEFAULT NULL,
  `published` tinyint(1) DEFAULT '1',
  `ordering` int(11) DEFAULT '0',
  `vat_percent` float(12,5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`,`ordering`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

INSERT INTO `#__smartorder_toppings` (`id`, `cat_id`, `name`, `description`, `price`, `discount_price`, `published`, `ordering`, `vat_percent`) VALUES
(2, 1, 'extra mushroom', NULL, 2.00000, 0.00000, 1, 0, NULL),
(3, 1, 'smoked salmon', NULL, 3.00000, 0.00000, 1, 0, NULL),
(4, 1, 'extra cheese', NULL, 1.00000, 0.00000, 1, 0, NULL),
(5, 1, 'extra baecon', NULL, 3.00000, 0.00000, 1, 0, NULL),
(6, 1, 'extra meat', NULL, 4.00000, 0.00000, 1, 0, NULL),
(7, 1, 'extra tomatoe', NULL, 1.00000, 0.00000, 1, 0, NULL);

CREATE TABLE IF NOT EXISTS `#__smartorder_users` (
  `id` int(11) NOT NULL,
  `address` varchar(250) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_so_user_address` (`address`),
  KEY `IX_so_user_phone` (`phone`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;