<?php 
$core_path = defined('CPOTHEME_CORE_URL') ? CPOTHEME_CORE_URL : get_template_directory_uri().'/core/';
$theme_data = wp_get_theme();

?>

<div class="cpotheme-welcome">
	<div class="cpotheme-welcome-header">
		<h1 class="cpotheme-welcome-title">
			<?php echo esc_attr(CPOTHEME_NAME); ?>
		</h1>
		<div class="cpotheme-welcome-version">
			<span class="cpotheme-welcome-version-number">
				<?php printf(__('Version %s', 'cpotheme'), esc_attr(CPOTHEME_VERSION)); ?>
			</span>
		</div>
		<div class="cpotheme-welcome-description">
			<?php $content_types_url = add_query_arg(array('tab' => 'plugin-information', 'plugin' => 'cpo-content-types', 'TB_iframe' => 'true', 'width' => '640', 'height' => '500'), admin_url('plugin-install.php')); ?>
			<?php $content_types = '<strong><a class="thickbox" href="'.$content_types_url.'">CPO Content Types</a></strong>'; ?>
			<?php printf(__('Thank you for choosing %s! To get started, make sure you have the %s plugin installed and then check the following list. We hope you enjoy using this theme to build an awesome WordPress website.', 'cpotheme'), esc_attr(CPOTHEME_NAME), $content_types); ?>
		</div>
	</div>
	<img class="cpotheme-welcome-image" src="<?php echo get_template_directory_uri().'/screenshot.png'; ?>">
	
	<div class="cpotheme-welcome-clear"></div>
	
	<div class="cpotheme-welcome-section">
		<div class="cpotheme-welcome-column">
			<h3>1. <?php _e('Install Recommended Plugins', 'cpotheme'); ?></h3>
			<p>
				<?php _e('This theme works well with a number of free plugins to unlock its full potential. It is highly recommended that you install them.', 'cpotheme'); ?>
			</p>
			
			<?php $plugin_url = add_query_arg(array('tab' => 'plugin-information', 'plugin' => 'cpo-content-types', 'TB_iframe' => 'true', 'width' => '640', 'height' => '500'), admin_url('plugin-install.php')); ?>
			<a class="cpotheme-welcome-task thickbox" href="<?php echo $plugin_url; ?>"><span class="cpotheme-welcome-icon dashicons-before dashicons-admin-plugins"></span> <strong><?php _e('Install CPO Content Types', 'cpotheme'); ?></strong></a>
			
			<?php $plugin_url = add_query_arg(array('tab' => 'plugin-information', 'plugin' => 'cpo-shortcodes', 'TB_iframe' => 'true', 'width' => '640', 'height' => '500'), admin_url('plugin-install.php')); ?>
			<a class="cpotheme-welcome-task thickbox" href="<?php echo $plugin_url; ?>"><span class="cpotheme-welcome-icon dashicons-before dashicons-admin-plugins"></span><?php _e('Install CPO Shortcodes', 'cpotheme'); ?></a>
			
			<?php $plugin_url = add_query_arg(array('tab' => 'plugin-information', 'plugin' => 'cpo-widgets', 'TB_iframe' => 'true', 'width' => '640', 'height' => '500'), admin_url('plugin-install.php')); ?>
			<a class="cpotheme-welcome-task thickbox" href="<?php echo $plugin_url; ?>'"><span class="cpotheme-welcome-icon dashicons-before dashicons-admin-plugins"></span><?php _e('Install CPO Widgets', 'cpotheme'); ?></a>
			
			<?php $plugin_url = add_query_arg(array('tab' => 'plugin-information', 'plugin' => 'cpo-content-blocks', 'TB_iframe' => 'true', 'width' => '640', 'height' => '500'), admin_url('plugin-install.php')); ?>
			<a class="cpotheme-welcome-task thickbox" href="<?php echo $plugin_url; ?>'"><span class="cpotheme-welcome-icon dashicons-before dashicons-admin-plugins"></span><?php _e('Install CPO Content Blocks', 'cpotheme'); ?></a>
		</div>
		<div class="cpotheme-welcome-column">
			<h3>2. <?php _e('Add Custom Content Types', 'cpotheme'); ?></h3>
			<p>
				<?php $plugin_url = add_query_arg(array('tab' => 'plugin-information', 'plugin' => 'cpo-content-types', 'TB_iframe' => 'true', 'width' => '640', 'height' => '500'), admin_url('plugin-install.php')); ?>
				<?php _e('This theme supports special content types. Populate the following and your site will take shape.', 'cpotheme'); ?> 
				<?php printf(__('You will need the %s plugin.', 'cpotheme'), $content_types); ?>
			</p>
			
			<?php if(!defined('CPOTHEME_USE_SLIDES') && !defined('CPOTHEME_USE_FEATURES') && !defined('CPOTHEME_USE_PORTFOLIO') && !defined('CPOTHEME_USE_PRODUCTS') && !defined('CPOTHEME_USE_SERVICES') && !defined('CPOTHEME_USE_TESTIMONIALS') && !defined('CPOTHEME_USE_TEAM')): ?>
			<a class="cpotheme-welcome-task" href="edit.php?post_type=post"><span class="cpotheme-welcome-icon dashicons-before dashicons-admin-post"></span> <?php _e('Start creating posts', 'cpotheme'); ?></a>			
			<?php endif; ?>
			<?php if(defined('CPOTHEME_USE_SLIDES') && CPOTHEME_USE_SLIDES == true): ?>
			<a class="cpotheme-welcome-task" href="edit.php?post_type=cpo_slide"><span class="cpotheme-welcome-icon dashicons-before dashicons-images-alt2"></span> <?php _e('Add slides to the homepage', 'cpotheme'); ?></a>
			<?php endif; ?>
			<?php if(defined('CPOTHEME_USE_FEATURES') && CPOTHEME_USE_FEATURES == true): ?>
			<a class="cpotheme-welcome-task" href="edit.php?post_type=cpo_feature"><span class="cpotheme-welcome-icon dashicons-before dashicons-star-filled"></span> <?php _e('Add feature blocks to the homepage', 'cpotheme'); ?></a>
			<?php endif; ?>
			<?php if(defined('CPOTHEME_USE_PORTFOLIO') && CPOTHEME_USE_PORTFOLIO == true): ?>
			<a class="cpotheme-welcome-task" href="edit.php?post_type=cpo_portfolio"><span class="cpotheme-welcome-icon dashicons-before dashicons-portfolio"></span> <?php _e('Create your portfolio items', 'cpotheme'); ?></a>			
			<?php endif; ?>
			<?php if(defined('CPOTHEME_USE_PRODUCTS') && CPOTHEME_USE_PRODUCTS == true): ?>
			<a class="cpotheme-welcome-task" href="edit.php?post_type=cpo_product"><span class="cpotheme-welcome-icon dashicons-before dashicons-cart"></span> <?php _e('Showcase your products', 'cpotheme'); ?></a>
			<?php endif; ?>
			<?php if(defined('CPOTHEME_USE_SERVICES') && CPOTHEME_USE_SERVICES == true): ?>
			<a class="cpotheme-welcome-task" href="edit.php?post_type=cpo_service"><span class="cpotheme-welcome-icon dashicons-before dashicons-archive"></span> <?php _e('List your services', 'cpotheme'); ?></a>			
			<?php endif; ?>
			<?php if(defined('CPOTHEME_USE_TESTIMONIALS') && CPOTHEME_USE_TESTIMONIALS == true): ?>
			<a class="cpotheme-welcome-task" href="edit.php?post_type=cpo_testimonial"><span class="cpotheme-welcome-icon dashicons-before dashicons-format-chat"></span> <?php _e('Add some testimonials', 'cpotheme'); ?></a>
			<?php endif; ?>
			<?php if(defined('CPOTHEME_USE_TEAM') && CPOTHEME_USE_TEAM == true): ?>
			<a class="cpotheme-welcome-task" href="edit.php?post_type=cpo_team"><span class="cpotheme-welcome-icon dashicons-before dashicons-universal-access"></span> <?php _e('Add your team members', 'cpotheme'); ?></a>
			<?php endif; ?>
			<?php if(defined('CPOTHEME_USE_CLIENTS') && CPOTHEME_USE_CLIENTS == true): ?>
			<a class="cpotheme-welcome-task" href="edit.php?post_type=cpo_client"><span class="cpotheme-welcome-icon dashicons-before dashicons-businessman"></span> <?php _e('Add your clients', 'cpotheme'); ?></a>
			<?php endif; ?>
			<?php if(defined('CPOTHEME_USE_PORTFOLIO') && CPOTHEME_USE_PORTFOLIO == true): ?>
			<a class="cpotheme-welcome-task" href="post-new.php?post_type=page"><span class="cpotheme-welcome-icon dashicons-before dashicons-welcome-add-page"></span> <?php _e('Create a page with the Portfolio template', 'cpotheme'); ?></a>
			<?php endif; ?>
			<?php if(defined('CPOTHEME_USE_PRODUCTS') && CPOTHEME_USE_PRODUCTS == true): ?>
			<a class="cpotheme-welcome-task" href="post-new.php?post_type=page"><span class="cpotheme-welcome-icon dashicons-before dashicons-welcome-add-page"></span> <?php _e('Create a page with the Products template', 'cpotheme'); ?></a>
			<?php endif; ?>
			<?php if(defined('CPOTHEME_USE_SERVICES') && CPOTHEME_USE_SERVICES == true): ?>
			<a class="cpotheme-welcome-task" href="post-new.php?post_type=page"><span class="cpotheme-welcome-icon dashicons-before dashicons-welcome-add-page"></span> <?php _e('Create a page with the Services template', 'cpotheme'); ?></a>
			<?php endif; ?>
			<?php if(defined('CPOTHEME_USE_TEAM') && CPOTHEME_USE_TEAM == true): ?>
			<a class="cpotheme-welcome-task" href="post-new.php?post_type=page"><span class="cpotheme-welcome-icon dashicons-before dashicons-welcome-add-page"></span> <?php _e('Create a page with the Team template', 'cpotheme'); ?></a>
			<?php endif; ?>
		</div>
		<div class="cpotheme-welcome-column cpotheme-welcome-column-last">
			<h3>3. <?php _e('Configure The Theme', 'cpotheme'); ?></h3>
			<p>
				<?php _e('Add the finishing touch. Customize your theme using the theme options page, add your menus, and create your sidebar widgets.', 'cpotheme'); ?>
			</p>
			<a class="cpotheme-welcome-task" href="customize.php"><span class="cpotheme-welcome-icon dashicons-before dashicons-admin-appearance"></span><?php _e('Customize the appearance of your site', 'cpotheme'); ?></a>
			<a class="cpotheme-welcome-task" href="options-general.php?page=cpotheme_license"><span class="cpotheme-welcome-icon dashicons-before dashicons-admin-network"></span><?php _e('Add your license key', 'cpotheme'); ?></a>
			<a class="cpotheme-welcome-task" href="nav-menus.php"><span class="cpotheme-welcome-icon dashicons-before dashicons-menu"></span><?php _e('Set up the main navigation menu', 'cpotheme'); ?></a>
			<a class="cpotheme-welcome-task" href="widgets.php"><span class="cpotheme-welcome-icon dashicons-before dashicons-welcome-widgets-menus"></span><?php _e('Add some widgets to your sidebar', 'cpotheme'); ?></a>
		</div>
		<div class="cpotheme-welcome-clear"></div>
	</div>
	
	<?php $image_path = get_template_directory_uri().'/core'; ?>
	<?php if(defined('CPOTHEME_CORE_URL')) $image_path = esc_url(CPOTHEME_CORE_URL); ?>
	<div class="cpotheme-welcome-section">
		<div class="cpotheme-welcome-block cpotheme-welcome-block-wide">
			<img class="cpotheme-welcome-block-image" src="<?php echo $image_path.'/images/plugin-forge.jpg'; ?>">
			<div class="cpotheme-welcome-block-body">
				<h3 class="cpotheme-welcome-block-title"><?php _e('Forge, a front-end page builder', 'cpotheme'); ?></h3>
				<p>
					<?php _e('Design virtually any kind of layout with a drag & drop interface, right on the design of your site. No coding required.', 'cpotheme'); ?>
				</p>
				<?php $plugin_url = add_query_arg(array('tab' => 'plugin-information', 'plugin' => 'forge', 'TB_iframe' => 'true', 'width' => '640', 'height' => '500'), admin_url('plugin-install.php')); ?>
				<a class="button button-primary thickbox" href="<?php echo $plugin_url; ?>'"><?php _e('Install Forge', 'cpotheme'); ?></a>
			</div>
		</div>
		<div class="cpotheme-welcome-block">
			<img class="cpotheme-welcome-block-image" src="<?php echo $image_path.'/images/plugin-infuse.jpg'; ?>">
			<div class="cpotheme-welcome-block-body">
				<h3 class="cpotheme-welcome-block-title"><?php _e('Add reusable content with Infuse', 'cpotheme'); ?></h3>
				<p>
					<?php _e('Create a site-wide announcement, add content to the homepage, or recycle the same blocks of content across many pages.', 'cpotheme'); ?>
				</p>
				<?php $plugin_url = add_query_arg(array('tab' => 'plugin-information', 'plugin' => 'infuse', 'TB_iframe' => 'true', 'width' => '640', 'height' => '500'), admin_url('plugin-install.php')); ?>
				<a class="button button-primary thickbox" href="<?php echo $plugin_url; ?>'"><?php _e('Install Infuse', 'cpotheme'); ?></a>
			</div>
		</div>
		<div class="cpotheme-welcome-block cpotheme-welcome-block-last">
			<img class="cpotheme-welcome-block-image" src="<?php echo $image_path.'/images/plugin-cpo-shortcodes.jpg'; ?>">
			<div class="cpotheme-welcome-block-body">
				<h3 class="cpotheme-welcome-block-title"><?php _e('Insert multimedia elements with CPO Shortcodes', 'cpotheme'); ?></h3>
				<p>
					<?php _e('Add buttons, pricing tables, icon boxes, and even grid-like post listings much more thanks to the power of shortcodes.', 'cpotheme'); ?>
				</p>
				<?php $plugin_url = add_query_arg(array('tab' => 'plugin-information', 'plugin' => 'cpo-shortcodes', 'TB_iframe' => 'true', 'width' => '640', 'height' => '500'), admin_url('plugin-install.php')); ?>
				<a class="button button-primary thickbox" href="<?php echo $plugin_url; ?>'"><?php _e('Install CPO Shortcodes', 'cpotheme'); ?></a>
			</div>
		</div>
		<div class="cpotheme-welcome-block">
			<img class="cpotheme-welcome-block-image" src="<?php echo $image_path.'/images/plugin-cpo-widgets.jpg'; ?>">
			<div class="cpotheme-welcome-block-body">
				<h3 class="cpotheme-welcome-block-title"><?php _e('Add essential widgets with CPO Widgets', 'cpotheme'); ?></h3>
				<p>
					<?php _e('Display images in your latest posts widget, add your most recent tweets, link your social profiles, and much more.', 'cpotheme'); ?>
				</p>
				<?php $plugin_url = add_query_arg(array('tab' => 'plugin-information', 'plugin' => 'cpo-widgets', 'TB_iframe' => 'true', 'width' => '640', 'height' => '500'), admin_url('plugin-install.php')); ?>
				<a class="button button-primary thickbox" href="<?php echo $plugin_url; ?>'"><?php _e('Install CPO Widgets', 'cpotheme'); ?></a>
			</div>
		</div>
		<div class="cpotheme-welcome-block cpotheme-welcome-block-last">
			<img class="cpotheme-welcome-block-image" src="<?php echo $image_path.'/images/plugin-cpo-content-types.jpg'; ?>">
			<div class="cpotheme-welcome-block-body">
				<h3 class="cpotheme-welcome-block-title"><?php _e('Need help? Check the knowledge base', 'cpotheme'); ?></h3>
				<p>
					<?php printf(__('Check out the extensive documentation pages and see what you can achieve with %s.', 'cpotheme'), esc_attr(CPOTHEME_NAME)); ?>
				</p>
				<a class="button button-primary" target="_blank" href="<?php echo esc_url('//www.cpothemes.com/documentation'); ?>"><?php _e('Read The Docs', 'cpotheme'); ?></a>
			</div>
		</div>
		<div class="cpotheme-welcome-column cpotheme-welcome-column-last">
			
		</div>
		<div class="cpotheme-welcome-clear"></div>
	</div>