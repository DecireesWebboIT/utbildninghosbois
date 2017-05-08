<div class="portfolio-item">
	<a class="portfolio-item-image" href="<?php the_permalink(); ?>">
		<div class="portfolio-item-overlay dark primary-color-bg">
			<h3 class="portfolio-item-title">
				<?php the_title(); ?>
			</h3>
			<?php if(has_excerpt()): ?>
			<div class="portfolio-item-description">
				<?php the_excerpt(); ?>
			</div>
			<?php endif; ?>
			<?php cpotheme_edit(); ?>
		</div>
		<?php the_post_thumbnail('portfolio', array('title' => '')); ?>
	</a>
</div>