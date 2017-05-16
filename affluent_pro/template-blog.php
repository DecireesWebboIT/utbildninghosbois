<?php /* Template Name: Blog */ ?>
<?php get_header(); ?>

<?php get_template_part('element', 'page-header'); ?>

<div id="main" class="main">
	<div class="container">
		<section id="content" class="content">
			<?php do_action('cpotheme_before_content'); ?>
			
			<?php if(have_posts()) while(have_posts()): the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="page-content">
					<?php the_content(); ?>
				</div>
			</div>
			<?php endwhile; ?>
			
			<?php $query = new WP_Query("post_type=post&paged=".cpotheme_current_page()."&posts_per_page=".get_option('posts_per_page')); ?>
			<?php if($query->posts): ?>
			<?php cpotheme_grid($query->posts, 'element', 'blog', cpotheme_get_option('blog_columns'), array('class' => 'column-narrow')); ?>
			<?php cpotheme_numbered_pagination($query); ?>
			<?php wp_reset_postdata(); ?>
			<?php endif; ?>
			
			<?php do_action('cpotheme_after_content'); ?>
		</section>
		<?php get_sidebar(); ?>
		<div class="clear"></div>
	</div>
</div>

<?php get_footer(); ?>