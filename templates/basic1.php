<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
<link href="https://fonts.googleapis.com/css?family=Coming+Soon&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Walter+Turncoat&display=swap" rel="stylesheet">

<style>
	.main-content-inner.col-sm-12.col-md-8.no-sidebar {
		min-width: 350px;
		width: 100%;
	}

	.vendomat_menucard {
		position: relative;
		background: #000 center repeat;
        background-image: url('<?php echo plugins_url( "assets/black_linen_v2.png", __FILE__ )  ?>');
		/*background-image: url("https://www.toptal.com/designers/subtlepatterns/patterns/purty_wood.png");*/
		width: 100%;
		color: #FFF;
		padding: 25px;
        padding-bottom: 50px;
    	border: 2px solid #CCCCCC;
		-webkit-box-shadow: inset 0px 0px 5px 0px rgba(255,255,255,0.25);
		-moz-box-shadow: inset 0px 0px 5px 0px rgba(255,255,255,0.25);
		box-shadow: inset 0px 0px 5px 0px rgba(255,255,255,0.25);
	}

	.vendomat_menucard h1 {
		/*font-family: 'Dancing Script', cursive;*/
		font-family: 'Walter Turncoat', cursive;
		font-style: italic;
		font-weight: normal !important;
		font-size: 63px;
		color: #EFEFEF;
	}

	.vendomat_menucard h2 {
		font-family: 'Walter Turncoat', cursive;
		font-weight: normal !important;
		font-size: 1.5em;
        color: #bbbbbb;
	}

	.vendomat_menucard h3 {
		font-family: 'Walter Turncoat', cursive;
	}

	.vendomat_menucard h3 {
		font-weight: bold !important;
		font-size: 1.3em;
		padding: 0;
		margin: 0;
        color: #bbbbbb;
	}

	.vendomat_menucard .item_container {
	}

	.vendomat_menucard .item_container .item {
		font-family: 'Walter Turncoat', cursive;
		background: rgba(0,0,0,0.25);
		width: calc(50% - 5px);
		vertical-align: top;
		padding: 10px;
		margin-bottom: 5px;
		min-width: 300px;
	}

	.vendomat_menucard .item_container .item .item_text {
		display: inline-block;
		width: calc(100% - 208px);
		vertical-align: top;
		margin-top: 20px;
	}

    .vendomat_menucard .item_container .item img {
        float: right;
        width: 200px
    }

	.vendomat_menucard .item_container .item .item_img {
		display: inline-block;
		width: 200px;
		vertical-align: top;
		margin-top: 20px;
		text-align: right;
	}

	.vendomat_menucard .item_container .item .item_price {
		width: 100%;
		text-align: right;
		margin-top: 15px;
		border-top: 1px solid #FFFFFF;
	}
</style>


<!-- Styling of item elements -->
<script>
(function($) {
	$(document).ready(function(){
		$(window).resize(() => {
			if($(window).width() < 900) {
				$('.item').css({
					'width': '100%'
				})
			} else {
				$('.item').css({
					'width': 'calc(50% - 5px)'
				})
			}
		})

		$(document).ready(() => {
			$('.item').each(function() {
				if($(this).find('img').length) {
					$(this).find('img').prependTo($(this).find('.item_text'))
					$(this).find('.item_text').css('width', '100%')
				} else {
					$(this).find('.item_img').hide();
					$(this).find('.item_text').css('width', '100%')
				}
			})

			$('.item_container').masonry({
				itemSelector: '.item',
				horizontalOrder: true,
				gutter: 5
			});
		})
	})
 }(jQuery));
</script>

<div class="vendomat_menucard">
	<h1>Digitale Speisekarte Bar & Grill</h1>

	<?php 
		$articlelist = json_decode(get_option('store_articles'));
		$gf_datas = json_decode(get_option('gf_datas'));

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