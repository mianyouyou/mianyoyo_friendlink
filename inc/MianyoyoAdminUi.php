<?php

!defined('DEBUG') AND exit('Access Denied.');

if (class_exists('MianyoyoAdminUi', false)) {
	return;
}

class MianyoyoAdminUi {

	public static function css($pluginDir) {
		global $conf;
		$_file = APP_PATH . 'plugin/' . $pluginDir . '/static/css/admin-setting.css';
		$_ver = is_file($_file) ? filemtime($_file) : (isset($conf['static_version']) ? $conf['static_version'] : time());
		echo '<link rel="stylesheet" href="../plugin/' . esc_attr($pluginDir) . '/static/css/admin-setting.css?v=' . intval($_ver) . '">' . "\n";
	}

	public static function load($pluginDir) {
		$_inc = APP_PATH . 'plugin/' . $pluginDir . '/inc/MianyoyoAdminUi.php';
		if (!class_exists('MianyoyoAdminUi', false) && is_file($_inc)) {
			include_once $_inc;
		}
		self::css($pluginDir);
	}

	public static function pageOpen($title, $brief = '', $icon = 'ti-settings') {
		?>
<div class="my-admin-page">
	<div class="my-admin-hero">
		<div class="my-admin-hero-icon"><i class="ti <?php echo esc_attr($icon); ?>"></i></div>
		<div class="my-admin-hero-main">
			<h1 class="my-admin-hero-title"><?php echo esc_html($title); ?></h1>
			<?php if ($brief !== '') { ?>
			<p class="my-admin-hero-brief"><?php echo esc_html($brief); ?></p>
			<?php } ?>
		</div>
	</div>
		<?php
	}

	public static function pageClose() {
		echo "</div>\n";
	}

	public static function formOpen($action, $extraClass = '') {
		$_cls = trim('my-admin-form ' . $extraClass);
		?>
<form method="post" action="<?php echo esc_attr($action); ?>" class="<?php echo esc_attr($_cls); ?>">
	<?php echo CsrfService::input(); ?>
		<?php
	}

	public static function formClose($label = null) {
		if ($label === null) {
			$label = lang('submit');
		}
		?>
	<div class="my-admin-submit-bar">
		<button type="submit" class="btn btn-primary px-4"><i class="ti ti-device-floppy me-1"></i><?php echo esc_html($label); ?></button>
	</div>
</form>
		<?php
	}

	public static function sectionOpen($title, $icon = 'ti-adjustments', $desc = '') {
		?>
<div class="my-admin-section card">
	<div class="my-admin-section-head">
		<span class="my-admin-section-icon"><i class="ti <?php echo esc_attr($icon); ?>"></i></span>
		<div class="my-admin-section-meta">
			<div class="my-admin-section-title"><?php echo esc_html($title); ?></div>
			<?php if ($desc !== '') { ?>
			<div class="my-admin-section-desc"><?php echo esc_html($desc); ?></div>
			<?php } ?>
		</div>
	</div>
	<div class="my-admin-section-body">
		<?php
	}

	public static function sectionClose() {
		?>
	</div>
</div>
		<?php
	}

	public static function hint($text) {
		echo '<div class="my-admin-hint">' . esc_html($text) . '</div>';
	}
}
