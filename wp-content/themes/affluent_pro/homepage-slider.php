<?php $query = new WP_Query('post_type=cpo_slide&posts_per_page=-1&order=ASC&orderby=menu_order'); ?>
<?php if($query->posts): $slide_count = 0; ?>
<div id="slider" class="slider">
	<div class="slider-slides cycle-slideshow"<?php cpotheme_slider_data();?>>
		<?php foreach($query->posts as $post): setup_postdata($post); ?>
		<?php $slide_count++; ?>
		<?php $image_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), array(1500, 7000), false, ''); ?>
		<?php $slide_position = get_post_meta(get_the_ID(), 'slide_position', true); ?>
		<?php $slide_color = get_post_meta(get_the_ID(), 'slide_color', true); ?>
		<?php $slide_link = get_post_meta(get_the_ID(), 'slide_link', true); ?>
		<?php $slide_url = get_post_meta(get_the_ID(), 'slide_url', true); ?>
		<div id="slide_<?php echo $slide_count; ?>" class="slide <?php echo $slide_position.' '.$slide_color; ?>" style="background-image:url(<?php echo $image_url[0]; ?>);">
			<div class="slide-body">
				<div class="container">
					<div class="slide-caption">
						<h2 class="slide-title">
							<?php the_title(); ?>
						</h2>
						<div class="slide-content">
							<?php the_content(); ?>
						</div>
						<?php if($slide_url != '' && $slide_link != ''): ?>
						<a class="slide-link button button-medium" href="<?php echo $slide_url; ?>"><?php echo $slide_link; ?></a>
						<?php endif; ?>
						<?php cpotheme_edit(); ?>
					</div>
					<div class="slide-image">
						<?php cpotheme_get_media(get_post_meta(get_the_ID(), 'slide_image', true)); ?>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php if(sizeof($query->posts) > 1): ?>
	<?php wp_enqueue_script('cpotheme_cycle'); ?>
	<?php wp_enqueue_style('cpotheme-fontawesome'); ?>
	<div class="slider-prev" data-cycle-cmd="pause"></div>
	<div class="slider-next" data-cycle-cmd="pause"></div>
	<?php endif; ?>
</div> 			
<?php endif; ?>			
