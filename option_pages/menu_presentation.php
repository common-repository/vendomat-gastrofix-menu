<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

////////////////////////////////////////////////
//					Page Variabels
////////////////////////////////////////////////
// Validate licensing key
if(gastrofix_menu_pluginIsActivated(get_option('license_key'))) {
	$licenseActive = true;
} else {
	$licenseActive = false;
}
?>

<?php 


$default_gf_datas = file_get_contents(plugins_url('/assets/json/default_masterdata.json', __FILE__));
$gf_datas = get_option('gf_datas', $default_gf_datas);
////////////////////////////////////////////////
//				End Page Variabels
////////////////////////////////////////////////
?>


<?php if($licenseActive) { ?>
    <div class="notice notice-success is-dismissible inline"><b>Plugin wurde erfolgreich aktiviert.</b></div>
<?php } else { ?>
    <div class="notice notice-error is-dismissible">Ihr GASTROFIX Menu Plugin ist nocht nicht aktiviert.</div>
<?php } ?>


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



<?php $gf_datas = json_decode($gf_datas) ?>


<!-- Create DataTable -->
<script>
const dataTableOptions = {
	orderCellsTop: true,
	fixedHeader: true,
	pageLength: 25,
	language: {
		"url": "<?php echo plugins_url('/assets/json/dataTables/German.json', __FILE__) ?>"
	}
}

$(document).ready(function() {
	$('.gfTable thead tr').clone(true).appendTo( '#example thead' );
    $('.gfTable thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Suchen '+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );
 
    var table = $('.gfTable').DataTable(dataTableOptions);
});
</script>

<div class="alternate">
	<h1>Artikelgruppen</h1>

	<table class="gfTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Artikelgruppe</th>
				<th>Kurzbezeichnung</th>
				<th>Gehe zu...</th>
			</tr>
		</thead>
		<tbody>
				<?php
					if(array_key_exists('errorMessage', $gf_datas->articlegroups) == false) {
						foreach($gf_datas->articlegroups as $arr) {
							foreach($arr as $item => $pref) {
								if($pref->superGroup->id == $pref->id) {
									echo '<tr style="background: #F0F8FF; font-weight: bold">';
								} else {
									echo '<tr>';
								};
								echo '
											<td>' . $pref->id . '</td>
											<td>' . $pref->name . '</td>
											<td>' . $pref->shortName . '</td>
											<td><a href="'. admin_url("admin.php?page=vendomat-gastrofix-menu-articlelist&supergroup=" . $pref->id) .'">Artikelliste</a></td>
										</tr>';
							}
						}
					}
				?>
		</tbody>
	</table>
</div>
<div class="spacerY50"></div>