
DROP TABLE IF EXISTS `mandarin_system`;
CREATE TABLE IF NOT EXISTS `mandarin_system` (
  `id` int(11) NOT NULL auto_increment,
  `status` int(11) NOT NULL,
  `title` text NOT NULL,
  `title_end` text NOT NULL,
  `merchant_id` varchar(64) NOT NULL default '',
  `merchant_sig` varchar(64) NOT NULL default '',
  `serial` varchar(64) NOT NULL default '',
  `version` FLOAT(2) DEFAULT '1.1' NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

INSERT INTO `mandarin_system` (`id`, `status`, `title`, `title_end`, `merchant_id`, `merchant_sig`, `serial`, `version`) VALUES
(1, 0, '��������� ������� MandarinBank', '����� ������ �������� ����, �� ��������� � ���� ������ ������� MANDARINBANK, ��� ��� ����� ���������� �������� ����� ����� ������� ��������: ������� Visa, MasterCard, ������-������, Webmoney, ��������� QIWI', '', '', '', 1.1);

