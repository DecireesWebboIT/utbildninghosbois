<?php
/**
 * Clever_Mega_Menu_Import_Export
 *
 * @package    Clever_Mega_Menu
 */
final class Clever_Mega_Menu_Import_Export
{
    /**
     * Hook suffix
     *
     * @var    string
     *
     * @see    https://developer.wordpress.org/reference/functions/add_submenu_page/
     */
    public $hook_suffix;

    /**
     * Settings
     *
     * @see    Clever_Mega_Menu::$settings
     *
     * @var    array
     */
    private $settings;

    /**
     * Constructor
     */
    function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Add the settings page
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @see    https://developer.wordpress.org/reference/hooks/admin_menu/
     */
    function _add($context)
    {
        $this->hook_suffix = add_submenu_page(
            'class-clever-mega-menu-dashboard.php',
            esc_html__('Import/Export', 'clever-mega-menu'),
            esc_html__('Import/Export', 'clever-mega-menu'),
            'manage_options',
            basename(__FILE__),
            array($this, '_render')
       );
    }

    /**
     * Render
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     */
    function _render()
    {
        ?><div class="wrap clever-mega-menu-admin">
            <h2><?php esc_html_e('Import/Export Menu Themes', 'clever-mega-menu') ?></h2>
            <table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Import Menu Theme', 'clever-mega-menu') ?></th>
						<td>
							<p><?php _e('Choose an import file from your computer then click on the "Import" button.', 'clever-mega-menu') ?></p>
							<form enctype="multipart/form-data" method="post" action="<?php echo menu_page_url(basename(__FILE__), 0) ?>">
                                <?php wp_nonce_field('clever-mega-menu-import-data', 'clever-mega-menu-import-nonc3') ?>
								<label for="clever-mega-menu-import-data" class="screen-reader-text">
                                    <?php _e('Upload File', 'clever-mega-menu') ?>:
                                </label>
								<p><input type="file" id="clever-mega-menu-import-data" name="clever-mega-menu-import-data"></p>
								<?php submit_button(__('Import', 'clever-mega-menu'), 'primary', 'upload') ?>
							</form>

						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Export Menu Theme', 'clever-mega-menu') ?></th>
						<td>
							<p><?php _e('Once you have saved the export file, you can use the import function to import the menu theme on any sites using Clever Mega Menu.', 'clever-mega-menu') ?></p>
							<form class="clever-mega-menu-export-form" method="post" action="<?php echo menu_page_url(basename(__FILE__), 0) ?>">
                                <?php
                                    wp_nonce_field('clever-mega-menu-export-data', 'clever-mega-menu-export-nonc3');
                                    $menu_themes = $this->get_menu_themes();
                                if ($menu_themes) :
                                    ?><div class="option-field"><label><select name="clever-mega-menu-exporting-menu-theme">
                                        <option value="">-- <?php esc_html_e('Select a menu theme', 'clever-mega-menu') ?> --</option>
                                        <option value="all"><?php esc_html_e('All menu themes', 'clever-mega-menu') ?></option><?php
                                        foreach ($menu_themes as $menu_theme) :
                                            ?><option value="<?php echo $menu_theme->post_name ?>"><?php echo $menu_theme->post_title ?></option><?php
                                        endforeach;
                                    ?></select></label></div><?php
                                else :
                                    ?><p><?php esc_html_e('No menu theme available.', 'clever-mega-menu') ?></p><?php
                                endif;
                                submit_button(__('Export', 'clever-mega-menu'), 'primary', 'clever-mega-menu-export-btn');
								?>
							</form>
						</td>
					</tr>
				</tbody>
			</table>
        </div><?php
    }

    /**
     * Import
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     */
    function _import()
    {
        if (
            !$this->validate_current_page() ||
			!isset($_POST['clever-mega-menu-import-nonc3']) ||
            empty($_FILES['clever-mega-menu-import-data']['tmp_name'])
        ) {
            return;
        }

        if (!wp_verify_nonce($_POST['clever-mega-menu-import-nonc3'], 'clever-mega-menu-import-data')) {
            return;
        }

		$upload_data = file_get_contents($_FILES['clever-mega-menu-import-data']['tmp_name']);
		$import_data = json_decode($upload_data, true);

        if ($import_data) {
            foreach ($import_data as $key => $value) {
                $menu_theme = get_page_by_path($key, OBJECT, 'clever_menu_theme');
                if ($menu_theme && $menu_theme->post_title === $value['name']) {
                    continue;
                }
                $args = array(
                    'post_type'      => 'clever_menu_theme',
                    'post_status'    => 'publish',
                    'post_title'     => $value['name'],
                    'post_name'      => $key,
                    'comment_status' => 'closed',
                    'ping_status'    => 'closed',
                    'meta_input'     => $value['value']
                );
                $inserted = wp_insert_post($args, true);
                if (is_wp_error($inserted)) {
                    $imported = false;
                    break;
                } else {
                    $theme_post = new \WP_Post($inserted);
                    $theme_meta = new Clever_Mega_Menu_Theme_Meta($this->settings);
                    $theme_meta->generate_css($value['value'], $theme_post);
                }
            }
        }

        $page_url = html_entity_decode(menu_page_url(basename(__FILE__), 0));

		if ($_FILES['clever-mega-menu-import-data']['error'] || !$imported) {
            wp_redirect($page_url . '&imported=false');
		}

		wp_redirect($page_url. '&imported=true');

		exit;
    }

    /**
     * Export
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     */
    function _export()
    {
        if (
            !$this->validate_current_page() ||
            !isset($_POST['clever-mega-menu-export-nonc3']) ||
            empty($_POST['clever-mega-menu-exporting-menu-theme'])
        ) {
            return;
        }

        if (!wp_verify_nonce($_POST['clever-mega-menu-export-nonc3'], 'clever-mega-menu-export-data')) {
            return;
        }

        $export_data = array();
        $meta_key    = Clever_Mega_Menu_Theme_Meta::META_KEY;
        $_menu_theme = sanitize_title($_POST['clever-mega-menu-exporting-menu-theme']);

        if ('all' === $_menu_theme) {
            $menu_themes = $this->get_menu_themes();
            if ($menu_themes) {
                foreach ($menu_themes as $menu_theme) {
                    $export_data[$menu_theme->post_name]['name'] = $menu_theme->post_title;
                    $export_data[$menu_theme->post_name]['value'] = get_post_meta($menu_theme->ID, $meta_key, true);
                }
            }
        } else {
            $menu_theme = get_page_by_path($_menu_theme, OBJECT, 'clever_menu_theme');
            $export_data[$_menu_theme]['name'] = $menu_theme->post_title;
            $export_data[$_menu_theme]['value'] = get_post_meta($menu_theme->ID, $meta_key, true);
        }

        $export_json = json_encode($export_data);

	    header('Content-Description: File Transfer');
	    header('Cache-Control: public, must-revalidate');
	    header('Pragma: hack');
	    header('Content-Type: application/json; charset='.get_option('blog_charset'));
	    header('Content-Disposition: attachment; filename="clever-mega-menu-themes-'.date('Ymd-His').'.json"');
	    header('Content-Length: '.mb_strlen($export_json));

	    exit($export_json);
	}

    /**
     * Do notification
     *
     * @see    https://developer.wordpress.org/reference/hooks/admin_notices/
     */
    function _notify()
    {
        if ( !$this->validate_current_page() ) {
			return;
        }

        if ( isset( $_GET['imported'] ) && 'true' === $_GET['imported'] ) :
            ?><div class="notice notice-success is-dismissible">
                <p><strong>
                    <?php _e('Data have been imported successfully!', 'clever-mega-menu') ?>
                </strong></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">
                        <?php _e('Dismiss this notice.') ?>
                    </span>
                </button>
            </div><?php
        endif;
        if ( isset( $_GET['imported'] ) && 'false' === $_GET['imported'] ) :
            ?><div class="notice notice-error is-dismissible">
                <p><strong>
                    <?php _e('Failed to import data. Please try again!', 'clever-mega-menu') ?>
                </strong></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">
                        <?php _e('Dismiss this notice.') ?>
                    </span>
                </button>
            </div><?php
        endif;
    }

    /**
     * Validate current page
     */
    private function validate_current_page()
    {
    	global $page_hook;

    	if (isset($page_hook) && $page_hook === $this->hook_suffix) {
    		return true;
        }

    	if (isset($_GET['page']) && $_GET['page'] === basename(__FILE__)) {
    		return true;
        }

    	return false;
    }

    /**
     * Get all published menu themes
     */
    private function get_menu_themes()
    {
        return get_posts(array(
            'post_type'              => 'clever_menu_theme',
            'post_status'            => 'publish',
            'suppress_filters'       => true,
            'no_found_rows'          => true,
            'cache_results'          => false,
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false
        ));
    }
}
