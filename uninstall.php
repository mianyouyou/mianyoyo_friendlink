<?php

!defined('DEBUG') AND exit('Access Denied.');

$tablepre = $db->tablepre;
db_exec("DROP TABLE IF EXISTS {$tablepre}friendlink");
setting_delete('mianyoyo_friendlink');
cache_delete('mianyoyo_friendlink_list');
