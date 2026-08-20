<?php

!defined('DEBUG') AND exit('Access Denied.');

class MianyoyoFriendlinkService {

	public static function getSettings(): array {
		$defaults = array('show_header' => 0, 'show_footer' => 1);
		$cfg = setting_get('mianyoyo_friendlink');
		if (!is_array($cfg)) {
			$cfg = array();
		}
		return array_merge($defaults, $cfg);
	}

	public static function saveSettings(array $input): void {
		$cfg = self::getSettings();
		$cfg['show_header'] = !empty($input['show_header']) ? 1 : 0;
		$cfg['show_footer'] = !empty($input['show_footer']) ? 1 : 0;
		setting_set('mianyoyo_friendlink', $cfg);
		cache_delete('mianyoyo_friendlink_list');
	}

	public static function listAll(): array {
		$cached = cache_get('mianyoyo_friendlink_list');
		if (is_array($cached)) {
			return $cached;
		}
		$list = db_find('friendlink', array(), array('rank' => 1, 'lid' => 1), 1, 200);
		if (!is_array($list)) {
			$list = array();
		}
		cache_set('mianyoyo_friendlink_list', $list, 600);
		return $list;
	}

	public static function listFor(string $place): array {
		$cfg = self::getSettings();
		if ($place === 'header' && empty($cfg['show_header'])) {
			return array();
		}
		if ($place === 'footer' && empty($cfg['show_footer'])) {
			return array();
		}
		$out = array();
		foreach (self::listAll() as $row) {
			if ($place === 'header' && empty($row['show_header'])) {
				continue;
			}
			if ($place === 'footer' && empty($row['show_footer'])) {
				continue;
			}
			if (trim($row['name']) === '' || trim($row['url']) === '') {
				continue;
			}
			$out[] = $row;
		}
		return $out;
	}

	public static function saveList(array $rows): void {
		$old = self::listAll();
		$oldMap = array();
		foreach ($old as $row) {
			$oldMap[intval($row['lid'])] = $row;
		}
		$keep = array();
		foreach ($rows as $row) {
			$lid = intval($row['lid'] ?? 0);
			$name = trim(strval($row['name'] ?? ''));
			$url = trim(strval($row['url'] ?? ''));
			$icon = trim(strval($row['icon'] ?? ''));
			$rank = intval($row['rank'] ?? 0);
			$show_header = !empty($row['show_header']) ? 1 : 0;
			$show_footer = !empty($row['show_footer']) ? 1 : 0;
			if ($name === '' && $url === '') {
				continue;
			}
			// 仅允许 http(s) 与站内相对路径
			if ($url !== '' && !preg_match('#^(https?://|/|[a-z0-9_\-]+\.htm)#i', $url)) {
				continue;
			}
			$data = array(
				'name' => mb_substr($name, 0, 100),
				'url' => mb_substr($url, 0, 500),
				'icon' => mb_substr($icon, 0, 100),
				'rank' => $rank,
				'show_header' => $show_header,
				'show_footer' => $show_footer,
			);
			if ($lid > 0 && isset($oldMap[$lid])) {
				db_update('friendlink', array('lid' => $lid), $data);
				$keep[$lid] = true;
			} else {
				$newId = db_insert('friendlink', $data);
				if ($newId) {
					$keep[intval($newId)] = true;
				}
			}
		}
		foreach ($oldMap as $lid => $_row) {
			if (empty($keep[$lid])) {
				db_delete('friendlink', array('lid' => $lid));
			}
		}
		cache_delete('mianyoyo_friendlink_list');
	}
}
