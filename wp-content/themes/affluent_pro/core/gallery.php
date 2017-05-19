<?php

function cpotheme_metabox_gallery($post){
	
	$output = '';
	
	//Backwards compatibility - If meta not exists, use attached images 
	if(metadata_exists('post', $post->ID, 'page_gallery')){
		$value = get_post_meta($post->ID, 'page_gallery', true);
	}else{
		$args = array(
		'post_type' => 'attachment',
		'post_status' => 'inherit',
		'post_parent' => $post->ID,
		'exclude' => get_post_thumbnail_id($post->ID),
		'post_mime_type' => 'image',
		'posts_per_page' => -1,
		'order' => 'ASC',
		'orderby' => 'menu_order');
		$images = get_posts($args);
		$value = '';
		$first = true;
		foreach($images as $current_image){
			if(!$first){
				$value .= ',';
			}
			$value .= $current_image->ID;
			$first = false;
		}
	}

	$output .= '<div id="cpotheme-gallery">';
	
	$attachments = array_filter(explode(',', $value));
	$output .= '<ul class="cpotheme-gallery-images">';
	if($attachments){
		foreach($attachments as $attachment_id){
			if(trim($attachment_id) != ''){
				$output .= '<li class="image" data-attachment_id="'.esc_attr($attachment_id ).'">';
				$output .=  wp_get_attachment_image($attachment_id, 'thumbnail');
				$output .= '<a href="#" class="cpotheme-gallery-remove delete tips" data-tip="'.__('Remove', 'cpotheme').'">'.__('Remove', 'cpotheme').'</a>';
				$output .= '</li>';
			}
		}
	}
	$output .= '</ul>';
	$output .= '<input type="hidden" id="page_gallery" name="page_gallery" value="'.esc_attr($value).'"/>';
	$output .= '</div>';
	
	$output .= '<div class="cpotheme-clear"></div>';
	$output .= '<p class="cpotheme-gallery-add hide-if-no-js">';
	$output .= '<a href="#" data-choose="'.__('Add Images', 'cpotheme').'" data-update="'.__('Add to gallery', 'cpotheme').'" data-delete="'.__('Delete image', 'cpotheme').'" data-text="'.__('Delete', 'cpotheme').'">';
	$output .= __('Add Images', 'cpotheme');
	$output .= '</a>';
	$output .= '</p>';

	echo $output;
}


function cpotheme_gallery_images($post_id){
	$args = array(
	'post_type' => 'attachment',
	'post_status' => 'inherit',
	'post_parent' => $post_id,
	'exclude' => get_post_thumbnail_id($post_id),
	'post_mime_type' => 'image',
	'posts_per_page' => -1,
	'order' => 'ASC',
	'orderby' => 'menu_order');
	$images = get_posts($args);
	return $images;
}


function cpotheme_gallery_display($imagelist){
	$gallery = '<div id="cpotheme-gallery-imagelist" class="cpotheme-gallery-imagelist">';
	$count = 0;
	foreach($imagelist as $image):
		$count++;
		$last = '';
		if($count % 3 == 0) $last = ' cpotheme-gallery-image-last';
		$gallery .= '<div class="cpotheme-gallery-image'.$last.'">'; 
		$image_url = wp_get_attachment_image_src($image->ID, 'thumbnail');
		$gallery .= '<a href="'.admin_url('/post.php?post='.$image->ID.'&action=edit&image-editor').'" title="'.__('Edit This Image', 'cpotheme').'" target="_blank">';
		$gallery .= '<img src="'.$image_url[0].'" alt="'.$image->post_title.'" rel="'.$image->ID.'" title="'.$image->post_content.'"> ';
		$gallery .= '</a>';			
		//$gallery .= '<span class="cpotheme-gallery-image-remove" rel="'.$image->ID.'"></span>'; 
		$gallery .= '</div>'; 
	endforeach;
	$gallery .= '</div>';
	return $gallery;
}


//Refresh the metabox
function cpotheme_gallery_refresh_metabox(){

	$parent	= $_POST['parent'];
	$loop = cpotheme_gallery_images($parent);
	$images	= cpotheme_gallery_display($loop);

	$ret = array();

	if(!empty($parent)){
		$ret['success'] = true;
		$ret['gallery'] = $images;
	}else{
		$ret['success'] = false;
	}

	echo json_encode($ret);
	die();
}


//Remove single image
function cpotheme_gallery_remove(){

	// content from AJAX post
	$image_id = $_POST['image_id'];
	$parent	= $_POST['parent'];

	// no image ID came through, so bail
	if(empty($image_id)){
		$ret['success'] = false;
		echo json_encode($ret);
		die();
	}

	//Remove attachment - Does not actually delete the file
	$image_data = array();
	$image_data['ID'] = $image_id;
	$image_data['post_parent'] = 0;
	$update = wp_update_post($image_data);

	// AJAX return array
	$ret = array();

	if($update !== 0){
		// loop to refresh the gallery
		$loop = cpotheme_gallery_images($parent);
		$images	= cpotheme_gallery_display($loop);
		// return values
		$ret['success'] = true;
		$ret['gallery'] = $images;

	}else{
		// failure return. can probably make more verbose
		$ret['success'] = false;

	}

	echo json_encode($ret);
	die();
}