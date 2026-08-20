<?php

!defined('DEBUG') AND exit('Access Denied.');

$gid != 1 && $gid != 2 AND message(-1, lang('user_group_insufficient_privilege'));

if (!class_exists('MianyoyoFriendlinkService')) {
	include_once APP_PATH . 'plugin/mianyoyo_friendlink/model/MianyoyoFriendlinkService.php';
}

$_mfl_cfg = MianyoyoFriendlinkService::getSettings();
$_mfl_list = MianyoyoFriendlinkService::listAll();

if ($method == 'POST') {
	CsrfService::check();
	$_mfl_action = param('mfl_action', 'save');
	if ($_mfl_action === 'save_display') {
		MianyoyoFriendlinkService::saveSettings(array(
			'show_header' => param('show_header', 0),
			'show_footer' => param('show_footer', 0),
		));
		message(0, lang('mfl_saved'), array('redirect_url' => url('plugin-setting-mianyoyo_friendlink')));
	}

	$lids = param('lid', array());
	$names = param('name', array());
	$urls = param('url', array());
	$icons = param('icon', array());
	$ranks = param('rank', array());
	$showHeaders = param('show_header_row', array());
	$showFooters = param('show_footer_row', array());

	$rows = array();
	if (is_array($lids)) {
		foreach ($lids as $k => $lid) {
			$rows[] = array(
				'lid' => $lid,
				'name' => is_array($names) ? ($names[$k] ?? '') : '',
				'url' => is_array($urls) ? ($urls[$k] ?? '') : '',
				'icon' => is_array($icons) ? ($icons[$k] ?? '') : '',
				'rank' => is_array($ranks) ? ($ranks[$k] ?? 0) : 0,
				'show_header' => (is_array($showHeaders) && !empty($showHeaders[$k])) ? 1 : 0,
				'show_footer' => (is_array($showFooters) && !empty($showFooters[$k])) ? 1 : 0,
			);
		}
	}
	MianyoyoFriendlinkService::saveList($rows);
	message(0, lang('mfl_saved'), array('redirect_url' => url('plugin-setting-mianyoyo_friendlink')));
}

include _include(ADMIN_PATH . 'view/htm/header.inc.htm');
include_once APP_PATH . 'plugin/mianyoyo_friendlink/inc/MianyoyoAdminUi.php';
MianyoyoAdminUi::css('mianyoyo_friendlink');
include _include(APP_PATH . 'plugin/mianyoyo_friendlink/view/htm/setting.htm');
include _include(ADMIN_PATH . 'view/htm/footer.inc.htm');
