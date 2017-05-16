<?php $query = new WP_Query('post_type=cpo_feature&posts_per_page=-1&order=ASC&orderby=menu_order'); ?>
<?php if($query->posts): ?>
<div id="features" class="features">
	<div class="container">		
		<?php cpotheme_block('home_features', 'features-heading'); ?>
		<div class="features-content">
			<?php $columns = cpotheme_get_option('features_columns'); if($columns == '') $columns = 3; ?>
			<?php cpotheme_grid($query->posts, 'element', 'feature', $columns); ?>
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php endif; ?>