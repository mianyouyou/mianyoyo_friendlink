<?php

!defined('DEBUG') AND exit('Access Denied.');

$tablepre = $db->tablepre;

$sql = "CREATE TABLE IF NOT EXISTS {$tablepre}friendlink (
	lid INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL DEFAULT '',
	url VARCHAR(500) NOT NULL DEFAULT '',
	icon VARCHAR(100) NOT NULL DEFAULT '',
	rank INT NOT NULL DEFAULT 0,
	show_header TINYINT NOT NULL DEFAULT 0,
	show_footer TINYINT NOT NULL DEFAULT 1,
	PRIMARY KEY (lid),
	KEY idx_rank (rank)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
db_exec($sql);

setting_set('mianyoyo_friendlink', array(
	'show_header' => 0,
	'show_footer' => 1,
));
