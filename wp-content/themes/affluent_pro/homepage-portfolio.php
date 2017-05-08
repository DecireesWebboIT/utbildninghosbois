<?php $query = new WP_Query('post_type=cpo_portfolio&order=ASC&orderby=menu_order&meta_key=portfolio_featured&meta_value=1&numberposts=-1&posts_per_page=-1'); ?>
<?php if($query->posts): ?>
<div id="portfolio" class="portfolio">
	<div class="container">
		<?php cpotheme_block('home_portfolio', 'portfolio-heading section-heading'); ?>
		<?php $columns = cpotheme_get_option('portfolio_columns'); if($columns == 0) $columns = 3; ?>
		<?php cpotheme_grid($query->posts, 'element', 'portfolio', $columns, array('class' => 'column-fit')); ?>
	</div>
</div>
<?php endif; ?>