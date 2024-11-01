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
?>

<?php if($licenseActive) { ?>
    <div class="notice notice-success is-dismissible inline"><b>Plugin wurde erfolgreich aktiviert.</b></div>
<?php } else { ?>
    <div class="notice notice-error is-dismissible">Ihr GASTROFIX Menu Plugin ist nocht nicht aktiviert.</div>
<?php } 

////////////////////////////////////////////////
//				End Page Variabels
////////////////////////////////////////////////
?>


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
<?php
if (null !== (sanitize_text_field($_GET['supergroup']))) {
	$supergroup_id = sanitize_text_field($_GET['supergroup']);
} else {
  $supergroup_id = False;
}
?>


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
 
    table = $('.gfTable').DataTable(dataTableOptions);
});
</script>

<!-- Create JSON -->
<script>
$(document).ready(function() {
	const form = $('#saveArticlelistForm')
	const store_articles = form.find('input[name="store_articles"]')
    let stored_articles_arr = JSON.parse(<?php echo json_encode(get_option('store_articles')) ?>) || {}

	const articles = $('table tr[name="article"]')
                  

	$('.save_articlelist').on('click', function() {
		//let articles_json = {}

		var data = table.rows().nodes();
		// Iterate through all visible data rows
		data.each(function (value, index) {
			const id = $(value).find('[name="article_id"]').text()
			const name = $(value).find('[name="article_name"]').text()
			const shortName = $(value).find('[name="article_shortName"]').text()
			const articleGroup = $(value).find('[name="article_articleGroup"]').text()

			// Check if data row is checked
			if($(value).find('input[type="checkbox"]').is(":checked")) {
				const article_obj = {
					'id': id,
					'name': name,
					'shortName': shortName,
					'articleGroup': articleGroup,
				}

				if(stored_articles_arr[articleGroup]) {
					let object_already_saved = false
					// Check if article is already saved in stored_articles_arr
					stored_articles_arr[articleGroup].reverse().forEach((stored_obj,index) => {
						if(stored_obj['id'] === id) {
							object_already_saved = true
						}
					})

					// Add article_obj to stored_articles_arr if not yet saved
					if(object_already_saved === false) {
						stored_articles_arr[articleGroup].push(article_obj)
					}
				} else {
					stored_articles_arr[articleGroup] = [article_obj]
				}
			} else {
				if(stored_articles_arr[articleGroup]) {
					// Remove article from stored_articles_arr if saved
					stored_articles_arr[articleGroup].reverse().forEach((stored_obj,index) => {
						if(stored_obj['id'] === id) {
							// Remove overlapping elements
							stored_articles_arr[articleGroup].splice(index, 1)
							// Check length of articlegroup after removing item
							// Delete Articlegroup from Stored Article if length is 0
							if(stored_articles_arr[articleGroup].length === 0) {
								delete stored_articles_arr[articleGroup]
							}
						}
					})
				}
			}
		});

		const form = $('#saveArticlelistForm')
		const store_articles = form.find('input[name="store_articles"]')
		const submit_btn = form.find('input[type="submit"]')


		store_articles.val(JSON.stringify(stored_articles_arr))

		form.submit()
	})
})
</script>

<div class="alternate">
	<h1>Artikelliste</h1>

	<div class="spacerY10"></div>
	<button class="save_articlelist button button-primary">Speichern</button>
	<div class="spacerY10"></div>

	<table class="gfTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Artikelname</th>
				<th>Kurzbezeichnung</th>
				<th>Artikelgruppe</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
				<?php 
					if(array_key_exists('errorMessage', $gf_datas->articles) == false) {
						foreach($gf_datas->articles as $arr) {
							foreach($arr as $item => $pref) {
								if($pref->articleGroup->id == $supergroup_id || $supergroup_id == False) {
									$iter_result = false;
									foreach(json_decode(get_option('store_articles', "{}")) as $saved_obj) {
										foreach($saved_obj as $obj) {
											if($pref->id == $obj->id) {
												$iter_result = true;
											}
										}
									}

									echo '	<tr name="article" id="item' . $pref->id . '">
												<td name="article_id">' . $pref->id . '</td>
												<td name="article_name">' . $pref->name . '</td>
												<td name="article_shortName">' . $pref->shortName . '</td>
												<td name="article_articleGroup">' . $pref->articleGroup->name . '</td>';

									if($iter_result) {
										echo '<td name="article_status"><input type="checkbox" checked /></td>';
									} else {
										echo '<td name="article_status"><input type="checkbox" /></td>';
									}
									echo '</tr>';
								}
							}
						}
					}
				?>
		</tbody>
	</table>


	<div hidden>
		<form method="post" action="options.php" id="saveArticlelistForm">
			<?php settings_fields( 'articlelist_store_group' ); ?>
			<?php do_settings_sections( 'articlelist_store_group' ); ?>
			<input type="text" name="store_articles" class="regular-text" value="<?php echo esc_attr( get_option('store_articles') ); ?>" />
		</form>
	</div>

	<div class="spacerY10"></div>
	<button class="save_articlelist button button-primary">Speichern</button>
	<div class="spacerY25"></div>
</div>
<div class="spacerY25"></div>