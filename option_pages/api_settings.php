<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Validate licensing key
if(gastrofix_menu_pluginIsActivated(get_option('license_key'))) {
	$licenseActive = true;
} else {
	$licenseActive = false;
}
?>

<?php
	$datetime = new DateTime();
?>

<?php if($licenseActive) { ?>
    <div class="notice notice-success is-dismissible inline"><b>Plugin wurde erfolgreich aktiviert.</b></div>
	<?php
		$vars = array(
			'$gf_last_sync' => get_option('gf_last_sync', 'Noch nie')
		);
		$message = '
			<div class="spacerY10"></div>
			<div class="notice notice-info is-dismissible inline">GASTROFIX Stammdaten zuletzt importiert am: <b>$gf_last_sync</b></div>
		';
		if(strlen(esc_attr(get_option('gf_datas'))) > 0) {
			echo strtr($message, $vars);
		}
	?>
<?php } else { ?>
    <div class="notice notice-error is-dismissible">Ihr GASTROFIX Menu Plugin ist nocht nicht aktiviert.</div>
<?php } ?>

<div class="spacerY50"></div>
<div class="gf_logo" style="background-image: url(<?php echo plugins_url('/assets/images/gf_logo.svg', __FILE__) ?>)"></div>
<div class="spacerX15"></div>
<div class="gf_title">
    <h1>GASTROFIX Menu Plugin</h1>
    <div class="spacerY5"></div>
    <h5>GASTORIX Schweiz</h5>
</div>
<div class="spacerX15"></div>
<div class="gf_title">
	<!--<a href="https://vendoapp.ch/vendoWP/support" class="button button-primary">Support</a>--->
	<a target="_blank" href="https://vendoapp.ch/vendoWP/support/GF-WP_Plugin_Manual.pdf" class="button button-secondary">Handbuch</a>
</div>
<div class="gf_border"></div>
<div class="alternate">
	<div class="wrap" id="plugin-page">
		<h1>API Einrichtung</h1>

		<h2 class="nav-tab-wrapper">
			<a href="#api_settings" class="nav-tab nav-tab-active" id="api_settings-tab">Generelle Optionen</a>
			<a href="#api_import" class="nav-tab" id="api_import-tab">Import</a>
		</h2>

		<div id="api_settings" class="nav-content" style="display: block;">
			<form method="post" action="options.php">
				<?php settings_fields( 'api_settings_group' ); ?>
				<?php do_settings_sections( 'api_settings_group' ); ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Cloud-Nummer:</th>
						<td>
							<input type="text" name="cloud_nr" class="regular-text" value="<?php echo esc_attr( get_option('cloud_nr') ); ?>" />
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row">Consumer-Key:</th>
						<td><input type="text" name="consumer_key" class="regular-text" value="<?php echo esc_attr( get_option('consumer_key') ); ?>" /></td>
					</tr>
					
					<tr valign="top">
						<th scope="row">Secret-Key:</th>
						<td><input type="text" name="secret_key" class="regular-text" value="<?php echo esc_attr( get_option('secret_key') ); ?>" /></td>
					</tr>

					<tr valign="top">
						<th scope="row">Username:</th>
						<td><input type="text" name="username" class="regular-text" value="<?php echo esc_attr( get_option('username') ); ?>" /></td>
					</tr>

					<tr valign="top">
						<th scope="row">Passwort:</th>
						<td><input type="password" name="password" class="regular-text" value="<?php echo esc_attr( get_option('password') ); ?>" /></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>

		<div id="api_import" class="nav-content">
			<div class="spacerY10"></div>
			<div class="notice notice-error inline" id="api_load_error" style="display: none"></div>
			<form method="post" action="options.php" id="ajaxLoadGASTROFIX">
				<?php settings_fields( 'api_load_group' ); ?>
				<?php do_settings_sections( 'api_load_group' ); ?>
				<input type="hidden" name="gf_datas" value="<?php echo esc_attr( get_option('gf_datas') ); ?>" />
				<input type="hidden" name="gf_last_sync" value="<?php echo $datetime->format('d.m.Y H:i:s'); ?>" />
				<div class="alternate">
					<h3>Import</h3>
					<div class="spacerY10"></div>
					Laden Sie ihre GASTROFIX Stammdaten hier herunter
					<div id="loader" class="hidden">
						<div class="spacerY10"></div>
						<progress></progress>
					</div>
					<div class="spacerY10"></div>
					<?php if($licenseActive) { ?>
						<button id="fakeSubmit" class="button button-primary">GASTROFIX Stammdaten importieren</button>
					<?php } else { ?>
						<button id="fakeSubmit" class="button button-primary disabled">GASTROFIX Stammdaten importieren</button>
					<?php } ?>
					<div class="hidden">
						<?php submit_button('GASTROFIX Stammdaten importieren'); ?>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>