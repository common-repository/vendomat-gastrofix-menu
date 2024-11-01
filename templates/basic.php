<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>
<?php wp_enqueue_script('gastrofix_menu_gastrofix_loader-masonry.pkgd.js', plugins_url('../javascripts/masonry.pkgd.js', __FILE__ ), array('jquery'), false, false); ?>
<?php wp_enqueue_script('gastrofix_menu_gastrofix_template.js', plugins_url('./template.js', __FILE__ ), array('jquery'), false, false); ?>
<?php wp_enqueue_style('gastrofix_menu_gastrofix_template.css', plugins_url('./template.css', __FILE__)) ?>

<div class="vendomat_menucard">
	<h1>Digitale Speisekarte Bar & Grill</h1>

	<?php 
		$default_gf_datas = file_get_contents(plugins_url('/assets/json/default_masterdata.json', __FILE__));

		$articlelist = json_decode(get_option('store_articles', $default_gf_datas));
		$gf_datas = json_decode(get_option('gf_datas', $default_gf_datas));

		foreach($articlelist as $articleGroup => $articleItems) {
			print('<h2>' . $articleGroup . '</h2>');
			echo '<div class="item_container">';
			foreach($articleItems as $item) {
				foreach($gf_datas->articles as $gf_article_arr) {
					foreach($gf_article_arr as $gf_item) {
						if($gf_item->id == $item->id) {
							echo sprintf('
								<div class="item">
									<h3>%s</h3>
									<div class="item_text">
										%s
									</div>
									<div class="item_img"></div>
									<div class="item_price">%s CHF</div>
								</div>
							', $gf_item->name, $gf_item->description, number_format((float)$gf_item->price, 2, '.', ''));
						}
					}
				}
			}
			echo '</div>';
		}
	?>
</div>