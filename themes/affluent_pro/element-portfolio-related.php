<?php $args = cpotheme_related_query(get_the_ID(), 'cpo_portfolio', 'cpo_portfolio_category', 3); ?>
<?php if($args != false): ?>
<?php $feature_posts = new WP_Query($args); ?>
<?php if($feature_posts->have_posts()): $count = 0; ?>
<div id="portfolio" class="portfolio">
	<?php cpotheme_grid($feature_posts->posts, 'element', 'portfolio', 3, array('class' => 'column-fit')); ?>
</div>
<?php endif; ?>
<?php endif; ?>