<?php
/**
 * Changelog
 */

$affluent = wp_get_theme( 'affluent' );

?>
<div class="featured-section changelog">
	

	<?php
	WP_Filesystem();
	global $wp_filesystem;
	$affluent_changelog       = $wp_filesystem->get_contents( get_template_directory() . '/changelog.txt' );
	$affluent_changelog_lines = explode( PHP_EOL, $affluent_changelog );
	foreach ( $affluent_changelog_lines as $affluent_changelog_line ) {
		if ( substr( $affluent_changelog_line, 0, 3 ) === "###" ) {
			echo '<h4>' . substr( $affluent_changelog_line, 3 ) . '</h4>';
		} else {
			echo $affluent_changelog_line, '<br/>';
		}


	}

	echo '<hr />';


	?>

</div>