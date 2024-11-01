<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Validate licensing key
if(gastrofix_menu_pluginIsActivated(get_option('license_key'))) {
	$licenseActive = true;
} else {
	$licenseActive = false;
}
?>

<?php if($licenseActive) { ?>
<?php 
	$datetime = new DateTime();
	$vars = array(
		'$gf_last_sync' => get_option('gf_last_sync', 'Noch nie')
	);
	$message = '
		<div class="spacerY10">
		<div class="notice notice-info is-dismissible inline">GASTROFIX Stammdaten zuletzt importiert am: <b>$gf_last_sync</b></div>
	';
	if(strlen(esc_attr($gf_datas)) > 0) {
		echo strtr($message, $vars);
	}
?>
<?php } ?>


<script>

async function gastrofix_menu_sendAJAX(_url, _data) {    
	try {
		const result = $.ajax({
			type: "POST",
			url: _url,
			data: _data,
            dataType: "json"
        });

		return result

	} catch (error) {
        console.error(error);
    }
}

    $(document).ready(() => {
        $('#activate_plugin_form').on('submit', function(e) {
            e.preventDefault();

            const license_key = $(this).find('input[name="activation_code"]').val()
            
            const url = ajax_object.ajaxurl;
            const data = {
                action: "gastrofix_menu_send_request",
                type: "GET",
                url: `http://212.237.211.45:3000/api/v1/activate_license?license_key=${license_key}`,
                headers: [
                    "Accept: application/json"
                ],
                security: ajax_object.ajax_nonce
            }

            gastrofix_menu_sendAJAX(url, data).then((result) => {
                if(result.success) {
                    alert("Lizenz wurde erfolgreich aktiviert.")
                    const licenseForm = $('#saveLicenseKey')

                    licenseForm.find('input[name="license_key"]').val(license_key)
                    licenseForm.submit();
                } else {
                    alert("Lizenz konnte nicht aktiviert werden.")
                }
            }).catch((err) => {
                alert("Lizenz konnte nicht aktiviert werden.")
                console.error(err)
            })
        })
    })
</script>


<?php if($licenseActive) { ?>
    <div class="notice notice-success is-dismissible inline"><b>Plugin wurde erfolgreich aktiviert.</b></div>
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
<?php if($licenseActive == false) { ?>
    <div id="activation_container">
        <div class="alternate">
            <form id="activate_plugin_form">
                <label for="activation_code"><h3>Aktivierungscode</h3></label>
                <div class="spacerY5"></div>
                <input type="text" name="activation_code" placeholder="XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX" class="input input-medium" />
                <input type="submit" value="Plugin aktivieren" class="button button-primary" />
                <a href="https://vendoapp.ch/vendoWP/purchase" class="button button-secondary">Aktivierungscode für 39€ Kaufen</a>
            </form>
        </div>
    </div>
    <div class="spacerY25"></div>
<?php } ?>
<div class="alternate">
    <h2>Plugin Beschreibung</h2>
    <p></p>
    Viele Gastronomen wenden täglich sehr viel Zeit auf, um neue Tagesgerichte zu verfassen und zu Papier zu bringen. 
    <br/>Viele aktualisieren aber nicht die Webseite weil es Ihnen einfach zu umständlich oder zu kompliziert ist.
    <p></p>
    Im Zuge unserer Digitalisierungsstrategie haben wir das Wordpress-Plugin entwickelt, mit dem Ziel, wenn der Restaurantleiter<br>
    1) neue Gerichte <br>
    2) neue Preise <br>
    3) die zum Menu passende Weinempfehlung <br>
    4) die zum Artikel passende Deklaration der Allergene und Nährwerte in der GASTROFIX Cloud editiert. <br>
    Sollen alle Änderungen mittels einem Tasten "Klick" ebenfalls auf SEINER WEBSITE aktualisiert werden.
    <p></p>

    <h2>Funktionsweise</h2>
    <ul>
    <li>- Das GASTROFIX-Wordpress-Plugin steht allen Marketingunternehmen/Webdesignern die mit Wordpress arbeiten zur Verfügung.</li>
    <li>- Das GASTROFIX-Wordpress-Plugin holt via GASTROFIX-API die gesamten Artikeldaten ab.</li>
    <li>- Es können im PlugIn Artikel per Filtertechnik einzeln oder ganze Artikel-Gruppen deaktiviert werden (weil z.B. Infotexte nicht auf der digitalen Speisekarte angezeigt werden sollen, wie auch Saisonale Artikel etc.).</li>
    <li>- Es können auch die Allergene und Nährwerte aus der GASTROFIX Artikelinfo mit übertragen und angezeigt werden (ist heute der grösste Aufwand für jeden Gastronomen, gesetzliche Vorgabe seit 1.5.2018 in der Schweiz).</li>
    <li>- Zum Text der Allergene fügen einige Kunden auch die Weinempfehlung dazu, inkl. Weinbeschreibung und Bild der Weinflasche. (auch diese Daten werden via plugin übertragen).</li>
    </ul>

    <h2>Weitere Anwendungsbereiche</h2>
    <ul>
    <li>- digitale Speisekarte für Gäste auf einem Tablett.</li>
    <li>- digital Signage bei Fastfood Cornern hängt meistens über der Theke.</li>
    <li>- digital Screen mit aktuellen Tagesmenus in klassichen Restaurants.</li>
    <li>- digitale Weinkarte im Weinkeller wo der Gast seinen Wein selber aussucht.</li>
    </ul>
</div>
<div class="spacerY25"></div>
<div class="alternate">
    <h2>Shortcode</h2>
    <p></p>
    <input type="text" value="[gf_menucard]" class="code" readonly />
</div>

<div hidden>
    <form method="post" action="options.php" id="saveLicenseKey">
        <?php settings_fields( 'api_licensing_group' ); ?>
        <?php do_settings_sections( 'api_licensing_group' ); ?>
        <input type="text" name="license_key" class="regular-text" />
    </form>
</div>