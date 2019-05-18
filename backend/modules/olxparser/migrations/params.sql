SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `new_parser_olx_params`;
CREATE TABLE `new_parser_olx_params` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pack` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `default_value` text NOT NULL,
  `textfield` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `new_parser_olx_params` (`id`, `pack`, `name`, `label`, `value`, `default_value`, `textfield`) VALUES
(1,	1,	'list_proxy',	'proxy ip:port, по одному в строке',	'83.239.58.162:8080\r\n',	'',	1),
(17,	1,	'root_url',	'Задаём исходный URL для парсинга информации',	'https://www.olx.ua/nedvizhimost/prodazha-kvartir/kharkov/',	'https://www.olx.ua/nedvizhimost/prodazha-kvartir/kharkov/',	0),
(19,	1,	'list_users_agents',	'user agent, по одному в строке',	'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; FSL 7.0.6.01001)\r\n',	'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; FSL 7.0.6.01001)\r\n',	1),
(20,	1,	'_count_true_pages_list',	'Количество обработываемых объектов за одну итерацию',	'100',	'100',	0),
(21,	1,	'url_phone',	'Задаём необходимый url для получения номера телефона при помощи ajax',	'https://www.olx.ua/ajax/misc/contact/phone/',	'https://www.olx.ua/ajax/misc/contact/phone/',	0);

