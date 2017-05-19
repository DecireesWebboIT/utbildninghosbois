<?php
/*
 * Custom Menu Wizard plugin
 *
 * Custom Menu Wizard Widget class
 */
class Custom_Menu_Wizard_Widget extends WP_Widget {

    /**
     * class constructor
     */
    public function __construct() {

        parent::__construct(
            'custom-menu-wizard',
            'Custom Menu Wizard',
            array(
                'classname' => 'widget_custom_menu_wizard',
                'description' => __('Add a custom menu, or part of one, as a widget', 'custom-menu-wizard'),
                //opt in to support for Selective Refresh for Widgets (in Customizer, WordPress 4.5), and
                //remove support for Widget Customizer plugin (since it's in core from WordPress 3.9)...
                //NB selective refresh has to be opted-in by the theme as well, for it to have any effect.
                'customize_selective_refresh' => true
            )
        );
        $this->_cmw_legacy_warnreadmore = 'http://wordpress.org/plugins/' . $this->id_base . '/changelog/';
        //accessibility mode doesn't necessarily mean that javascript is disabled, but if javascript *is* disabled
        //then accessibility mode *will* be on...
        $this->_cmw_accessibility = isset( $_GET['editwidget'] ) && $_GET['editwidget'];
        $this->_cmw_hash_ct = 0;

        $this->_cmw_hierarchy = new Custom_Menu_Wizard_Sorter();

    } //end __construct()

    /**
     * produces the backend admin form(s)
     *
     * @param array $instance Widget settings
     */
    public function form( $instance ) {

        //raised June 2014 : problem...
        //using the widget_form_callback filter (as Widget Title Links plugin does, which raised the issue) it is perfectly
        //possible for $instance to be non-empty - with any number of properties - for a new widget! The widget_form_callback
        //filter allows any other plugin to add fields to $instance *before* the actual widget itself gets a chance to (and
        //returning false from that filter will prevent the widget ever being called, but not relevant here).
        //(ref: WP_Widget::form_callback() in wp-includes/widgets.php)
        //this means that I can't rely on a !empty($instance) test being indicative of an existing widget (because it could be
        //a new widget but filtered with widget_form_callback).
        //So, I have changed the "legacy" test from
        //  if( !empty( $instance ) && empty( $instance['cmwv'] ) ){
        //to
        //  if( is_numeric( $this->number ) && $this->number > 0 && empty( $instance['cmwv'] ) ){
        //(checking for $this->number > 0 is probably overkill but it doesn't hurt)
        //Note that this could still be circumvented by some other plugin using the widget_form_callback filter to set 'cmwv',
        //but I can't do anything about that!

        //only call the legacy form method if the widget has a number (ie. this instance has been saved, could be either active
        // or inactive) and it does *not* have a version number ('cmwv') set in $instance...
        if( is_numeric( $this->number ) && $this->number > 0 && empty( $instance['cmwv'] ) ){
            $this->cmw_legacy_form( $instance );
            return;
        }

        //sanitize $instance...
        $instance = self::cmw_settings( $instance, array(), __FUNCTION__ );

        //if no populated menus exist, suggest the user go create one...
        if( ( $menus = $this->cmw_scan_menus( $instance['menu'], $instance['branch'] ) ) === false ) : ?>

<p class="widget-<?php echo $this->id_base; ?>-no-menus">
    <em><?php printf(
        wp_kses(
            __( 'No populated menus have been created yet! <a href="%s">Create one...</a>', 'custom-menu-wizard' ),
            array('a'=>array('href'=>array()))
            ),
        esc_attr(
            isset( $GLOBALS['wp_customize'] ) && $GLOBALS['wp_customize'] instanceof WP_Customize_Manager
                ? 'javascript: wp.customize.panel( "nav_menus" ).focus();'
                : admin_url('nav-menus.php')
            )
        ); ?></em>
    <input id="<?php echo $this->get_field_id('cmwv'); ?>" name="<?php echo $this->get_field_name('cmwv'); ?>"
        type="hidden" value="<?php echo Custom_Menu_Wizard_Plugin::$version; ?>" />
        <?php foreach( array('filters', 'fallbacks', 'output', 'container', 'classes', 'links') as $v ) : ?>
    <input id="<?php echo $this->get_field_id("fs_$v"); ?>" name="<?php echo $this->get_field_name("fs_$v"); ?>"
        type="hidden" value="<?php echo $instance["fs_$v"] ? '1' : '0' ?>" />
        <?php  endforeach; ?>
</p>
<?php
            //all done : quit...
            return;
        endif;

        //create the OPTIONs for the relative & absolute optgroups in the branch level select...
        $absGroup = array();
        $relGroup = array();
        if( empty( $instance['branch_start'] ) ){
            $branchLevel = '';
        }else{
            $branchLevel = $instance['branch_start'];
            $i = substr(  $branchLevel, 0, 1 );
            //is it currently set relative?...
            if( $i == '+' || $i == '-' ){
                //if we only have 1 level then set to branch item...
                if( $menus['selectedLevels'] < 2 ){
                    $branchLevel = '';
                //otherwise, limit the 'relativeness' to 1 less than the number of levels
                //available (ie. 5 levels available gives a range -4 thru to +4)...
                }elseif( abs( intval( $branchLevel ) ) > $menus['selectedLevels'] - 1 ){
                    $branchLevel = $i . ($menus['selectedLevels'] - 1);
                }
            //max an absolute against the number of levels available...
            }elseif( intval( $branchLevel ) > $menus['selectedLevels'] ){
                $branchLevel = $menus['selectedLevels'];
            }
        }
        //start with the middle option of the relatives (the level of the branch item)...
        $relGroup[] = '<option value="" ' . selected( $branchLevel, '', false ) . '>' . __('the Branch', 'custom-menu-wizard') . '</option>';
        //now do the absolutes and relatives...
        for( $i = 1; $i <= $menus['selectedLevels']; $i++ ){
            //topmost of the absolutes, the descriptor becomes '1 (root)'...
            $t = $i > 1 ? $i : __('1 (root)', 'custom-menu-wizard');
            //append to the absolutes...
            $absGroup[] = '<option value="' . $i . '" ' . selected( $branchLevel, "$i", false ) . '>' . $t . '</option>';
            //for anything LESS THAN the number of levels...
            if( $i < $menus['selectedLevels'] ){
                //immediately above the branch item, the descriptor becomes '-1 (parent)'...
                $t = $i > 1 ? "-$i" : __('-1 (parent)', 'custom-menu-wizard');
                //prepend to the relatives...
                array_unshift( $relGroup, '<option value="-' . $i . '" ' . selected( $branchLevel, "-$i", false ) . '>' . $t . '</option>' );
                //immediately below the branch item, the descriptor becomes '+1 (children)'...
                $t = $i > 1 ? "+$i" : __('+1 (children)', 'custom-menu-wizard');
                //append to the relatives...
                array_push( $relGroup, '<option value="+' . $i . '" ' . selected( $branchLevel, "+$i", false ) . '>' . $t . '</option>' );
            }
        }

        //set up some simple booleans for use at the disableif___ classes...
        $isByItems = $instance['filter'] == 'items'; // disableif-ss (IS Items filter)
        $isUnlimitedDepth = $isByItems || empty( $instance['depth'] ); // disableif-ud (IS unlimited depth)
        $isNotByBranch = $instance['filter'] != 'branch'; // disableifnot-br (is NOT Branch filter)
        $isNotBranchCurrentItem = $isNotByBranch || !empty( $instance['branch'] ); // disableifnot-br-ci (is NOT "Branch:Current Item")
        $isNotFallbackParentCurrent = $isNotBranchCurrentItem || !in_array( $instance['fallback'], array('parent', 'current') ); //disableifnot-fb-pc (is NOT set to fall back to parent or current)
        $isNotSwitchable = empty( $instance['switch_if'] ) || empty( $instance['switch_at'] ); // disableifnot-sw (missing either the condition of the processing stage)

        //NB the 'onchange' wrapper holds any text required by the "assist"
?>

<div id="<?php echo $this->get_field_id('onchange'); ?>"
    class="widget-<?php echo $this->id_base; ?>-onchange"
    data-cmw-instance-version='<?php echo Custom_Menu_Wizard_Plugin::$version; ?>'
    data-cmw-dialog-nonce='<?php echo wp_create_nonce( 'cmw-find-shortcodes' ); ?>'
    data-cmw-dialog-id='<?php echo $this->get_field_id('dialog'); ?>'>
<?php
        /**
         * permanently visible section : Title (with Hide) and Menu
         */
?>

    <p>
        <input type="hidden" value="<?php echo Custom_Menu_Wizard_Plugin::$version; ?>"
            id="<?php echo $this->get_field_id('cmwv'); ?>" name="<?php echo $this->get_field_name('cmwv'); ?>" />
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'custom-menu-wizard') ?></label>
<?php $this->cmw_formfield_checkbox( $instance, 'hide_title',
            array(
                'label' => _x('Hide', 'verb', 'custom-menu-wizard'),
                'lclass' => 'alignright'
            ) ); ?>
<?php $this->cmw_formfield_textbox( $instance, 'title',
            array(
                'fclass' => 'widefat cmw-widget-title'
            ) ); ?>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('menu'); ?>"><?php _e('Select Menu:', 'custom-menu-wizard'); ?></label>
        <select id="<?php echo $this->get_field_id('menu'); ?>" class="cmw-select-menu cmw-listen"
            name="<?php echo $this->get_field_name('menu'); ?>"><?php echo $menus['names']; ?></select>
    </p>
<?php
        /**
         * start collapsible section : 'Filter'
         */
        $this->cmw_open_a_field_section( $instance, __('Filters', 'custom-menu-wizard'), 'fs_filters' ); ?>

    <div><?php $this->cmw_assist_link(); ?><strong><?php _e('Primary Filter', 'custom-menu-wizard'); ?></strong>

        <div class="cmw-indented">
            <label class="cmw-verticalalign-baseline">
                <input type="radio" <?php checked( $instance['filter'], '' ); ?> value=""
                    id="<?php echo $this->get_field_id('filter'); ?>_0" class="cmw-bylevel cmw-listen"
                    <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('filter'); ?>"
                    /><?php _e('Level:', 'custom-menu-wizard'); ?></label>
            <select id="<?php echo $this->get_field_id('level'); ?>" class="cmw-level cmw-set-levels cmw-listen"
                <?php $this->cmw_disableif(); ?> data-cmw-set-levels="0"
                name="<?php echo $this->get_field_name('level'); ?>"><?php
for( $i = 1, $j = $instance['level'] > $menus['selectedLevels'] ? 1 : $instance['level']; $i <= $menus['selectedLevels']; $i++ ) :
                ?><option value="<?php echo $i; ?>" <?php selected( $j, $i ); ?>><?php echo $i > 1 ? $i : __('1 (root)', 'custom-menu-wizard'); ?></option><?php
endfor; ?></select>

        </div>

        <div class="cmw-indented">
            <label class="cmw-verticalalign-baseline">
                <input type="radio" <?php checked( $instance['filter'], 'branch' ); ?> value="branch"
                    id="<?php echo $this->get_field_id('filter'); ?>_1" class="cmw-bybranch cmw-listen"
                    <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('filter'); ?>"
                    /><?php _e('Branch:', 'custom-menu-wizard'); ?></label>
            <select id="<?php echo $this->get_field_id('branch'); ?>" class="cmw-branches cmw-assist-items cmw-listen"
                <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('branch'); ?>">
                <option value="0" <?php selected( $instance['branch'], 0 ); ?>><?php _e('Current Item', 'custom-menu-wizard'); ?></option>
                <?php echo $menus['selectedOptgroup']; ?></select>
            <select id="<?php echo $this->get_field_id('branch_ignore'); ?>" class='cmw-off-the-page'
                name="<?php echo $this->get_field_name('branch_ignore'); ?>" disabled="disabled">
                <?php echo $menus['optgroups']; ?></select>

        </div>

        <div class="cmw-indented">
            <label class="cmw-verticalalign-baseline">
                <input type="radio" <?php checked( $instance['filter'], 'items' ); ?> value="items"
                    id="<?php echo $this->get_field_id('filter'); ?>_2" class="cmw-byitems cmw-listen"
                    <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('filter'); ?>"
                    /><?php _e('Items:', 'custom-menu-wizard'); ?></label>
            <?php $this->cmw_formfield_textbox( $instance, 'items',
                array(
                    'fclass' => 'cmw-maxwidth-twothirds cmw-setitems cmw-listen'
                ) ); ?>
        </div>
    </div>

    <div class="cmw-disableif-ss<?php $this->cmw_disableif( 'push', $isByItems ); ?>"><?php $this->cmw_assist_link(); ?><strong><?php _e('Secondary Filter', 'custom-menu-wizard'); ?></strong>

        <div class="cmw-indented">
            <label class="cmw-disableifnot-br<?php $this->cmw_disableif( 'push', $isNotByBranch ); ?>"><?php _e('Starting at:', 'custom-menu-wizard'); ?>

                <select id="<?php echo $this->get_field_id('branch_start'); ?>" class="cmw-branch-start cmw-listen"
                    <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('branch_start'); ?>">
                    <optgroup label="<?php _ex('relative...', 'adjective: cf. absolute', 'custom-menu-wizard'); ?>">
                        <?php echo implode( '', $relGroup ); ?></optgroup>
                    <optgroup label="<?php _e('absolute...', 'custom-menu-wizard'); ?>">
                        <?php echo implode( '', $absGroup ); ?></optgroup>
                </select></label><?php $this->cmw_disableif( 'pop' ); ?><!-- end .cmw-disableifnot-br -->

            <br /><span class="cmw-disableifnot-br<?php $this->cmw_disableif( 'push', $isNotByBranch ); ?>">
                <label class="cmw-followed-by">
                    <input type="radio" <?php checked( $instance['start_mode'] !== 'level' ); ?> value=""
                        id="<?php echo $this->get_field_id('start_mode'); ?>_0"
                        <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('start_mode'); ?>"
                        /><?php _e('Item <small>(if possible)</small>', 'custom-menu-wizard'); ?></label>

                <label class="cmw-followed-by cmw-whitespace-nowrap">
                    <input type="radio" <?php checked( $instance['start_mode'] === 'level' ); ?> value="level"
                        id="<?php echo $this->get_field_id('start_mode'); ?>_1"
                        <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('start_mode'); ?>"
                        /><?php _e('Level', 'custom-menu-wizard'); ?></label>
<?php $this->cmw_formfield_checkbox( $instance, 'allow_all_root',
                    array(
                        'label' => __('Allow all Root Items', 'custom-menu-wizard'),
                        'lclass' => 'cmw-whitespace-nowrap'
                    ) ); ?>
            </span><?php $this->cmw_disableif( 'pop' ); ?><!-- end .cmw-disableifnot-br -->
        </div>

        <div class="cmw-indented">
            <label class="cmw-followed-by"><?php _e('For Depth:', 'custom-menu-wizard'); ?>

                <select id="<?php echo $this->get_field_id('depth'); ?>"
                    name="<?php echo $this->get_field_name('depth'); ?>" data-cmw-set-levels="1"
                    <?php $this->cmw_disableif(); ?> class="cmw-depth cmw-set-levels cmw-listen">
                    <option value="0" <?php selected( $instance['depth'] > $menus['selectedLevels'] ? 0 : $instance['depth'], 0 ); ?>><?php _e('unlimited', 'custom-menu-wizard'); ?></option><?php
for( $i = 1; $i <= $menus['selectedLevels']; $i++ ) :
                    ?><option value="<?php echo $i; ?>" <?php selected( $instance['depth'], $i ); ?>><?php printf( _n('%d level', '%d levels', $i, 'custom-menu-wizard'), $i ); ?></option><?php
endfor; ?></select></label>

<?php $this->cmw_formfield_checkbox( $instance, 'depth_rel_current',
                array(
                    'label' => __('Relative to Current Item', 'custom-menu-wizard'),
                    'lclass' => 'cmw-disableif-ud cmw-whitespace-nowrap',
                    'disableif' => $isUnlimitedDepth
                ) ); ?>
        </div>
    </div><?php $this->cmw_disableif( 'pop' ); ?><!-- end .cmw-disableif-ss -->

    <div><?php $this->cmw_assist_link(); ?><strong><?php _e('Inclusions', 'custom-menu-wizard'); ?></strong>

        <div class="cmw-indented">
            <label class="cmw-disableifnot-br<?php $this->cmw_disableif( 'push', $isNotByBranch ); ?>"><?php _e('Branch Ancestors:', 'custom-menu-wizard'); ?>

                <select name="<?php echo $this->get_field_name('ancestors'); ?>"
                    <?php $this->cmw_disableif(); ?> id="<?php echo $this->get_field_id('ancestors'); ?>"
                    class="cmw-ancestors cmw-set-rel-abs-levels cmw-listen">
                    <option value="0" <?php selected( $j, 0 ); ?>>&nbsp;</option>
<?php
        $j = $instance['ancestors'];
        $j = max( min( $j, $menus['selectedLevels'] - 1 ), 1 - $menus['selectedLevels'] ); ?>
                    <optgroup label="<?php _ex('relative...', 'adjective: cf. absolute', 'custom-menu-wizard'); ?>">
                        <option value="-1" <?php selected( $j, -1 ); ?>><?php _e('-1 level (parent)', 'custom-menu-wizard'); ?></option><?php
for( $i = -2; $i > 0 - $menus['selectedLevels']; $i-- ) :
                        ?><option value="<?php echo $i; ?>" <?php selected( $j, $i ); ?>><?php printf(  __('%d levels', 'custom-menu-wizard'), $i ); ?></option><?php
endfor; ?></optgroup>
                    <optgroup label="<?php _e('absolute...', 'custom-menu-wizard'); ?>">
                        <option value="1" <?php selected( $j, 1 ); ?>><?php _e('to level 1 (root)', 'custom-menu-wizard'); ?></option><?php
for( $i = 2; $i < $menus['selectedLevels']; $i++ ) :
                        ?><option value="<?php echo $i; ?>" <?php selected( $j, $i ); ?>><?php printf( __('to level %d', 'custom-menu-wizard'), $i ); ?></option><?php
endfor; ?></optgroup>
                </select></label><?php $this->cmw_disableif( 'pop' ); ?><!-- end .cmw-disableifnot-br -->

            <br /><span class="cmw-disableifnot-br<?php $this->cmw_disableif( 'push', $isNotByBranch ); ?>">
                <label><?php _e('... with Siblings:', 'custom-menu-wizard'); ?>

                    <select id="<?php echo $this->get_field_id('ancestor_siblings'); ?>" class="cmw-ancestor-siblings cmw-set-rel-abs-levels cmw-listen"
                            <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('ancestor_siblings'); ?>">
                        <option value="0" <?php selected( $j, 0 ); ?>>&nbsp;</option>
<?php
$j = $instance['ancestor_siblings'];
$j = max( min( $j, $menus['selectedLevels'] - 1 ), 1 - $menus['selectedLevels'] ); ?>
                        <optgroup label="<?php _ex('relative...', 'adjective: cf. absolute', 'custom-menu-wizard'); ?>">
                            <option value="-1" <?php selected( $j, -1 ); ?>><?php _e('-1 level (parent)', 'custom-menu-wizard'); ?></option><?php
for( $i = -2; $i > 0 - $menus['selectedLevels']; $i-- ) :
                            ?><option value="<?php echo $i; ?>" <?php selected( $j, $i ); ?>><?php printf(  __('%d levels', 'custom-menu-wizard'), $i ); ?></option><?php
endfor; ?></optgroup>
                        <optgroup label="<?php _e('absolute...', 'custom-menu-wizard'); ?>">
                            <option value="1" <?php selected( $j, 1 ); ?>><?php _e('to level 1 (root)', 'custom-menu-wizard'); ?></option><?php
for( $i = 2; $i < $menus['selectedLevels']; $i++ ) :
                            ?><option value="<?php echo $i; ?>" <?php selected( $j, $i ); ?>><?php printf( __('to level %d', 'custom-menu-wizard'), $i ); ?></option><?php
endfor; ?></optgroup>
                    </select></label>
            </span><?php $this->cmw_disableif( 'pop' ); ?><!-- end .cmw-disableifnot-br -->
        </div>

<?php $this->cmw_formfield_checkbox( $instance, 'siblings',
            array(
                'label' => __('Branch Siblings', 'custom-menu-wizard'),
                'lclass' => 'cmw-disableifnot-br',
                'disableif' => $isNotByBranch
            ) ); ?>

        <div class="cmw-indented">
            <label><?php _e('Level:', 'custom-menu-wizard'); ?>

                <select id="<?php echo $this->get_field_id('include_level'); ?>" class="cmw-include-level"
                    name="<?php echo $this->get_field_name('include_level'); ?>">
<?php $j = intval($instance['include_level']) > $menus['selectedLevels'] ? '' : $instance['include_level']; ?>
                    <option value="" <?php selected( $j, '' ); ?>>&nbsp;</option><?php
for( $i = 1; $i <= $menus['selectedLevels']; $i++ ) :
                    ?><option value="<?php echo $i; ?>" <?php selected( $j, "$i" ); ?>><?php echo $i; ?></option><?php
                    ?><option value="<?php echo $i . '-'; ?>" <?php selected( $j, $i . '-' ); ?>>&nbsp;&nbsp;&nbsp;<?php echo "$i " . __('and above', 'custom-menu-wizard'); ?></option><?php
                    ?><option value="<?php echo $i . '+'; ?>" <?php selected( $j, $i . '+' ); ?>>&nbsp;&nbsp;&nbsp;<?php echo "$i " . __('and below', 'custom-menu-wizard'); ?></option><?php
endfor; ?></select></label>
        </div>
    </div>

    <div><?php $this->cmw_assist_link(); ?><strong><?php _e('Exclusions', 'custom-menu-wizard'); ?></strong>

        <div class="cmw-indented">
<?php $this->cmw_formfield_textbox( $instance, 'exclude',
                array(
                    'label' => __('Item Ids:', 'custom-menu-wizard'),
                    'fclass' => 'cmw-maxwidth-twothirds cmw-exclusions'
                ) ); ?>
        </div>

        <div class="cmw-indented">
            <label><?php _e('Level:', 'custom-menu-wizard'); ?>

                <select id="<?php echo $this->get_field_id('exclude_level'); ?>" class="cmw-exclude-level"
                    name="<?php echo $this->get_field_name('exclude_level'); ?>">
<?php $j = intval($instance['exclude_level']) > $menus['selectedLevels'] ? '' : $instance['exclude_level']; ?>
                    <option value="" <?php selected( $j, '' ); ?>>&nbsp;</option><?php
for( $i = 1; $i <= $menus['selectedLevels']; $i++ ) :
                    ?><option value="<?php echo $i; ?>" <?php selected( $j, "$i" ); ?>><?php echo $i; ?></option><?php
                    ?><option value="<?php echo $i . '-'; ?>" <?php selected( $j, $i . '-' ); ?>>&nbsp;&nbsp;&nbsp;<?php echo "$i " . __('and above', 'custom-menu-wizard'); ?></option><?php
                    ?><option value="<?php echo $i . '+'; ?>" <?php selected( $j, $i . '+' ); ?>>&nbsp;&nbsp;&nbsp;<?php echo "$i " . __('and below', 'custom-menu-wizard'); ?></option><?php
endfor; ?></select></label>
        </div>
    </div>

    <div><?php $this->cmw_assist_link(); ?><strong><?php _e('Qualifier', 'custom-menu-wizard'); ?></strong>
        <br /><label for="<?php echo $this->get_field_id('contains_current'); ?>"><?php _e('Current Item is in:', 'custom-menu-wizard'); ?></label>
        <select id="<?php echo $this->get_field_id('contains_current'); ?>"
            <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('contains_current'); ?>">
            <option value="" <?php selected( $instance['contains_current'], '' ); ?>>&nbsp;</option><?php
            ?><option value="menu" <?php selected( $instance['contains_current'], 'menu' ); ?>><?php echo _e('Menu', 'custom-menu-wizard'); ?></option><?php
            ?><option value="primary" <?php selected( $instance['contains_current'], 'primary' ); ?>><?php echo _e('Primary Filter', 'custom-menu-wizard'); ?></option><?php
            ?><option value="secondary" <?php selected( $instance['contains_current'], 'secondary' ); ?>><?php echo _e('Secondary Filter', 'custom-menu-wizard'); ?></option><?php
            ?><option value="inclusions" <?php selected( $instance['contains_current'], 'inclusions' ); ?>><?php echo _e('Inclusions', 'custom-menu-wizard'); ?></option><?php
            ?><option value="output" <?php selected( $instance['contains_current'], 'output' ); ?>><?php echo _e('Final Output', 'custom-menu-wizard'); ?></option>
        </select>
    </div>

    <?php $this->cmw_close_a_field_section(); ?>

<?php
        /**
         * v1.2.0 start collapsible section : 'Fallbacks'
         */
        $this->cmw_open_a_field_section( $instance, __('Fallbacks', 'custom-menu-wizard'), 'fs_fallbacks' ); ?>

    <div class="cmw-disableifnot-br-ci<?php $this->cmw_disableif( 'push', $isNotBranchCurrentItem ); ?>"><?php $this->cmw_assist_link(); ?>

        <div class="cmw-indented">
            <label for="<?php echo $this->get_field_id('fallback'); ?>"><strong><?php _e('If Current Item has no children:', 'custom-menu-wizard'); ?></strong></label>
            <select id="<?php echo $this->get_field_id('fallback'); ?>" class="cmw-fallback cmw-listen"
                <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('fallback'); ?>">
                <option value="" <?php selected( $instance['fallback'], '' ); ?>>&nbsp;</option><?php
                ?><option value="parent" <?php selected( $instance['fallback'], 'parent' ); ?>><?php _e('Start at : -1 (parent)', 'custom-menu-wizard'); ?></option><?php
                ?><option value="current" <?php selected( $instance['fallback'], 'current' ); ?>><?php _e('Start at : the Current Item', 'custom-menu-wizard'); ?></option><?php
                ?><option value="quit" <?php selected( $instance['fallback'], 'quit' ); ?>><?php _e('No output!', 'custom-menu-wizard'); ?></option>
            </select>

            <br /><span class="cmw-disableifnot-fb-pc<?php $this->cmw_disableif( 'push', $isNotFallbackParentCurrent ); ?>">
<?php $this->cmw_formfield_checkbox( $instance, 'fallback_siblings',
                    array(
                        'label' => '&hellip;' . __('and Include its Siblings', 'custom-menu-wizard')
                    ) ); ?>
                <br /><label><?php _e('For Depth:', 'custom-menu-wizard'); ?>

                    <select <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('fallback_depth'); ?>"
                        id="<?php echo $this->get_field_id('fallback_depth'); ?>" class="cmw-set-levels"
                        data-cmw-set-levels="1">
                        <option value="0" <?php selected( $instance['fallback_depth'] > $menus['selectedLevels'] ? 0 : $instance['fallback_depth'], 0 ); ?>>&nbsp;</option><?php
for( $i = 1; $i <= $menus['selectedLevels']; $i++ ) :
                        ?><option value="<?php echo $i; ?>" <?php selected( $instance['fallback_depth'], $i ); ?>><?php printf( _n('%d level', '%d levels', $i, 'custom-menu-wizard'), $i ); ?></option><?php
endfor; ?></select></label>
                <span class="cmw-small-block cmw-indented"><em class="cmw-colour-grey"><?php _e('Fallback Depth is Relative to Current Item!', 'custom-menu-wizard'); ?></em></span>
            </span><?php $this->cmw_disableif( 'pop' ); ?><!-- end .cmw-disableifnot-fb-pc -->
        </div>

    </div><?php $this->cmw_disableif( 'pop' ); ?><!-- end .cmw-disableifnot-br-ci -->

    <div>
        <div class="cmw-indented"><strong><?php _e('If no Current Item can be found:', 'custom-menu-wizard'); ?></strong><br />
<?php $this->cmw_formfield_checkbox( $instance, 'fallback_ci_parent',
                array(
                    'label' => __('Try items marked Parent of Current', 'custom-menu-wizard')
                ) ); ?>
            <span class="cmw-small-block cmw-indented"><em class="cmw-colour-grey"><?php _e('This is a last resort to determine a "Current Item"', 'custom-menu-wizard'); ?></em></span>
        </div>
    </div>

    <div>
        <div class="cmw-indented"><strong><?php _e('If more than 1 possible Current Item:', 'custom-menu-wizard'); ?></strong><br />
<?php $this->cmw_formfield_checkbox( $instance, 'fallback_ci_lifo',
                array(
                    'label' => __('Use the <strong>last</strong> one found', 'custom-menu-wizard')
                ) ); ?>
            <span class="cmw-small-block cmw-indented"><em class="cmw-colour-grey"><?php _e('The default is to use the first candidate found', 'custom-menu-wizard'); ?></em></span>
        </div>
    </div>

    <?php $this->cmw_close_a_field_section(); ?>

<?php
        /**
         * start collapsible section : 'Output'
         */
        $this->cmw_open_a_field_section( $instance, __('Output', 'custom-menu-wizard'), 'fs_output' ); ?>

    <div><?php $this->cmw_assist_link(); ?>

        <label class="cmw-followed-by">
            <input type="radio" <?php checked( !$instance['flat_output'] ); ?> value="0"
                id="<?php echo $this->get_field_id('flat_output'); ?>_0"
                <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('flat_output'); ?>"
                /><?php _e('Hierarchical', 'custom-menu-wizard'); ?></label>
        <label class="cmw-whitespace-nowrap">
            <input type="radio" <?php checked( $instance['flat_output'] ); ?> value="1"
                id="<?php echo $this->get_field_id('flat_output'); ?>_1"
                <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('flat_output'); ?>"
                /><?php _e('Flat', 'custom-menu-wizard'); ?></label>
    </div>

    <div>
        <strong><?php _e('Set Title from', 'custom-menu-wizard'); ?></strong>

        <div class="cmw-indented">
            <label><?php _e('Current Item:', 'custom-menu-wizard'); $j = $instance['title_current']; ?>

                <select id="<?php echo $this->get_field_id('title_current'); ?>" class="cmw-title-from cmw-set-rel-abs-levels cmw-listen"
                    name="<?php echo $this->get_field_name('title_current'); ?>">
                    <option value="" <?php selected( $j, "" ); ?>>&nbsp;</option>
                    <option value="0" <?php selected( $j, "0" ); ?>><?php _e('the Current Item', 'custom-menu-wizard'); ?></option>
<?php $j = is_numeric( $j ) ? max( min( $j, $menus['selectedLevels'] - 1 ), 1 - $menus['selectedLevels'] ) : $j; ?>
                    <optgroup label="<?php _ex('relative...', 'adjective: cf. absolute', 'custom-menu-wizard'); ?>">
                        <option value="-1" <?php selected( $j, "-1" ); ?>><?php _e('-1 level (parent)', 'custom-menu-wizard'); ?></option><?php
for( $i = -2; $i > 0 - $menus['selectedLevels']; $i-- ) :
                        ?><option value="<?php echo $i; ?>" <?php selected( $j, "$i" ); ?>><?php printf(  __('%d levels', 'custom-menu-wizard'), $i ); ?></option><?php
endfor; ?></optgroup>
                    <optgroup label="<?php _e('absolute...', 'custom-menu-wizard'); ?>">
                        <option value="1" <?php selected( $j, "1" ); ?>><?php _e('level 1 (root)', 'custom-menu-wizard'); ?></option><?php
for( $i = 2; $i < $menus['selectedLevels']; $i++ ) :
                        ?><option value="<?php echo $i; ?>" <?php selected( $j, "$i" ); ?>><?php printf( __('level %d', 'custom-menu-wizard'), $i ); ?></option><?php
endfor; ?></optgroup>
                </select></label>
        </div>
        <div class="cmw-indented">
            <label class="cmw-disableifnot-br<?php $this->cmw_disableif( 'push', $isNotByBranch ); ?>"><?php _e('Branch Item:', 'custom-menu-wizard'); $j = $instance['title_branch']; ?>

                <select id="<?php echo $this->get_field_id('title_branch'); ?>" class="cmw-title-from cmw-set-rel-abs-levels cmw-listen"
                    <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('title_branch'); ?>">
                    <option value="" <?php selected( $j, "" ); ?>>&nbsp;</option>
                    <option value="0" <?php selected( $j, "0" ); ?>><?php _e('the Branch Item', 'custom-menu-wizard'); ?></option>
<?php $j = is_numeric( $j ) ?  max( min( $j, $menus['selectedLevels'] - 1 ), 1 - $menus['selectedLevels'] ) : $j; ?>
                    <optgroup label="<?php _ex('relative...', 'adjective: cf. absolute', 'custom-menu-wizard'); ?>">
                        <option value="-1" <?php selected( $j, "-1" ); ?>><?php _e('-1 level (parent)', 'custom-menu-wizard'); ?></option><?php
for( $i = -2; $i > 0 - $menus['selectedLevels']; $i-- ) :
                        ?><option value="<?php echo $i; ?>" <?php selected( $j, "$i" ); ?>><?php printf(  __('%d levels', 'custom-menu-wizard'), $i ); ?></option><?php
endfor; ?></optgroup>
                    <optgroup label="<?php _e('absolute...', 'custom-menu-wizard'); ?>">
                        <option value="1" <?php selected( $j, "1" ); ?>><?php _e('level 1 (root)', 'custom-menu-wizard'); ?></option><?php
for( $i = 2; $i < $menus['selectedLevels']; $i++ ) :
                        ?><option value="<?php echo $i; ?>" <?php selected( $j, "$i" ); ?>><?php printf( __('level %d', 'custom-menu-wizard'), $i ); ?></option><?php
endfor; ?></optgroup>
                </select></label><?php $this->cmw_disableif( 'pop' ); ?><!-- end .cmw-disableifnot-br -->
        </div>

        <div class="cmw-indented">&hellip; <?php _e('and', 'custom-menu-wizard'); ?>:
<?php $this->cmw_formfield_checkbox( $instance, 'title_linked',
                array(
                    'label' => __('Make it a Link', 'custom-menu-wizard')
                ) ); ?></div>
    </div>

    <div><strong><?php _e('Change UL to OL', 'custom-menu-wizard'); ?></strong><br />
<?php $this->cmw_formfield_checkbox( $instance, 'ol_root',
            array(
                'label' => __('Top Level', 'custom-menu-wizard'),
                'lclass' => 'cmw-followed-by'
            ) ); ?>
<?php $this->cmw_formfield_checkbox( $instance, 'ol_sub',
            array(
                'label' => __('Sub-Levels', 'custom-menu-wizard'),
                'lclass' => 'cmw-whitespace-nowrap'
            ) ); ?></div>

    <?php $this->cmw_close_a_field_section(); ?>

<?php
        /**
         * start collapsible section : 'Container'
         */
        $this->cmw_open_a_field_section( $instance, __('Container', 'custom-menu-wizard'), 'fs_container' ); ?>

    <div><?php $this->cmw_formfield_textbox( $instance, 'container',
            array(
                'label' => __('Element:', 'custom-menu-wizard'),
                'desc' => __('Eg. div or nav; leave empty for no container', 'custom-menu-wizard')
            ) ); ?></div>

    <div><?php $this->cmw_formfield_textbox( $instance, 'container_id',
            array(
                'label' => __('Unique ID:', 'custom-menu-wizard'),
                'desc' => __('An optional ID for the container', 'custom-menu-wizard')
            ) ); ?></div>

    <div><?php $this->cmw_formfield_textbox( $instance, 'container_class',
            array(
                'label' => __('Class:', 'custom-menu-wizard'),
                'desc' => __('Extra class for the container', 'custom-menu-wizard')
            ) ); ?></div>

    <?php $this->cmw_close_a_field_section(); ?>

<?php
        /**
         * start collapsible section : 'Classes'
         */
        $this->cmw_open_a_field_section( $instance, __('Classes', 'custom-menu-wizard'), 'fs_classes' ); ?>

    <div><?php $this->cmw_formfield_textbox( $instance, 'menu_class',
            array(
                'label' => __('Menu Class:', 'custom-menu-wizard'),
                'desc' => __('Class for the list element forming the menu', 'custom-menu-wizard')
            ) ); ?></div>

    <div><?php $this->cmw_formfield_textbox( $instance, 'widget_class',
            array(
                'label' => __('Widget Class:', 'custom-menu-wizard'),
                'desc' => __('Extra class for the widget itself', 'custom-menu-wizard')
            ) ); ?></div>

    <?php $this->cmw_close_a_field_section(); ?>

<?php
        /**
         * start collapsible section : 'Links'
         */
        $this->cmw_open_a_field_section( $instance, __('Links', 'custom-menu-wizard'), 'fs_links' ); ?>

    <div><?php $this->cmw_formfield_textbox( $instance, 'before',
            array(
                'label' => __('Before the Link:', 'custom-menu-wizard'),
                'desc' =>__( htmlspecialchars('Text/HTML to go before the </a> of the link') , 'custom-menu-wizard'),
                'fclass' => 'widefat'
            ) ); ?></div>

    <div><?php $this->cmw_formfield_textbox( $instance, 'after',
            array(
                'label' => __('After the Link:', 'custom-menu-wizard'),
                'desc' => __( htmlspecialchars('Text/HTML to go after the </a> of the link') , 'custom-menu-wizard'),
                'fclass' => 'widefat'
            ) ); ?></div>

    <div><?php $this->cmw_formfield_textbox( $instance, 'link_before',
            array(
                'label' => __('Before the Link Text:', 'custom-menu-wizard'),
                'desc' => __('Text/HTML to go before the link text', 'custom-menu-wizard'),
                'fclass' => 'widefat'
            ) ); ?></div>

    <div><?php $this->cmw_formfield_textbox( $instance, 'link_after',
            array(
                'label' => __('After the Link Text:', 'custom-menu-wizard'),
                'desc' => __('Text/HTML to go after the link text', 'custom-menu-wizard'),
                'fclass' => 'widefat'
            ) ); ?></div>

    <?php $this->cmw_close_a_field_section(); ?>

<?php
        /**
         * v3.1.0 start collapsible section : 'Alternative'
         */
        $this->cmw_open_a_field_section( $instance, __('Alternative', 'custom-menu-wizard'), 'fs_alternative' ); ?>

    <div><?php $this->cmw_assist_link(); ?>

        <label for="<?php echo $this->get_field_id('switch_if'); ?>" class="cmw-followed-by"><?php _e('On condition:', 'custom-menu-wizard'); ?></label>
        <br /><select id="<?php echo $this->get_field_id('switch_if'); ?>" class="cmw-switchable cmw-listen"
                <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('switch_if'); ?>">
            <option value="" <?php selected( $instance['switch_if'], '' ); ?>>&nbsp;</option><?php
            ?><option value="current" <?php selected( $instance['switch_if'], 'current' ); ?>><?php _e('Current Item is in...', 'custom-menu-wizard'); ?></option><?php
            ?><option value="no-current" <?php selected( $instance['switch_if'], 'no-current' ); ?>><?php _e('Current Item is NOT in...', 'custom-menu-wizard'); ?></option><?php
            ?><option value="no-output" <?php selected( $instance['switch_if'], 'no-output' ); ?>><?php _e('No Output from...', 'custom-menu-wizard'); ?></option>
        </select>

        <select id="<?php echo $this->get_field_id('switch_at'); ?>" class="cmw-switchable cmw-listen"
                <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('switch_at'); ?>">
            <option value="" <?php selected( $instance['switch_at'], '' ); ?>>&nbsp;</option><?php
            ?><option value="menu" <?php selected( $instance['switch_at'], 'menu' ); ?>><?php echo _e('Menu', 'custom-menu-wizard'); ?></option><?php
            ?><option value="primary" <?php selected( $instance['switch_at'], 'primary' ); ?>><?php echo _e('Primary Filter', 'custom-menu-wizard'); ?></option><?php
            ?><option value="secondary" <?php selected( $instance['switch_at'], 'secondary' ); ?>><?php echo _e('Secondary Filter', 'custom-menu-wizard'); ?></option><?php
            ?><option value="inclusions" <?php selected( $instance['switch_at'], 'inclusions' ); ?>><?php echo _e('Inclusions', 'custom-menu-wizard'); ?></option><?php
            ?><option value="output" <?php selected( $instance['switch_at'], 'output' ); ?>><?php echo _e('Final Output', 'custom-menu-wizard'); ?></option>
        </select>

        <br /><label class="cmw-disableifnot-sw<?php $this->cmw_disableif( 'push', $isNotSwitchable ); ?>"><?php _e('Then switch settings to:', 'custom-menu-wizard'); ?>

            <br /><textarea rows="3" cols="20" <?php $this->cmw_disableif(); ?> id="<?php echo $this->get_field_id('switch_to'); ?>"
            name="<?php echo $this->get_field_name('switch_to'); ?>"
            class="widefat"><?php echo $instance['switch_to']; ?></textarea>
        </label><?php $this->cmw_disableif( 'pop' ); ?><!-- end .cmw-disableifnot-sw -->
        <span class="cmw-small-block cmw-indented"><em class="cmw-colour-grey">Enter/Paste a [cmwizard.../] shortcode</em></span>

    </div>

    <?php $this->cmw_close_a_field_section(); ?>

    <div class="cmw-mock-fieldset"><?php _e('Shortcodes', 'custom-menu-wizard'); ?></div>
    <div class="cmw-the-shortcodes">
        <div class="cmw-small-block"><em class="cmw-colour-grey"><?php _e('The equivalent shortcode for this configuration...', 'custom-menu-wizard'); ?></em></div>
        <div class="cmw-shortcode-nojs cmw-small-block"><?php _e('With Javascript disabled, this is only guaranteed to be accurate when you <em>initially enter</em> Edit mode!', 'custom-menu-wizard'); ?></div>
        <div class="cmw-shortcode-wrap"><code class="widget-<?php echo $this->id_base; ?>-shortcode ui-corner-all"
            title="<?php esc_attr_e('stand-alone shortcode', 'custom-menu-wizard'); ?>"><?php echo self::cmw_shortcode( array_merge( $instance, array( 'menu' => $menus['selectedMenu'] ) ) ); ?></code></div>
<?php if( is_numeric( $this->number ) && $this->number > 0 ) : ?>
        <div class="cmw-small-block"><em class="cmw-colour-grey"><?php _e('This <u>specific widget</u> can also be included using...', 'custom-menu-wizard'); ?></em></div>
        <div class="cmw-shortcode-wrap"><code class="widget-<?php echo $this->id_base; ?>-shortcode cmw-instance-shortcode ui-corner-all"
            title="<?php esc_attr_e('dependent shortcode', 'custom-menu-wizard'); ?>">[cmwizard widget=<?php echo $this->number; ?>/]</code></div>
<?php endif; ?>
    </div>

</div>

<?php

        if( $this->_cmw_accessibility ){
            wp_localize_script(
                Custom_Menu_Wizard_Plugin::$script_handle,
                __CLASS__,
                array( 'trigger' => '#' . $this->get_field_id('menu') )
            );
        }

    } //end form()

    /**
     * sanitizes/updates the widget settings sent from the backend admin
     *
     * @filters : custom_menu_wizard_wipe_on_update        false
     *
     * @param array $new_instance New widget settings
     * @param array $old_instance Old widget settings
     * @return array Sanitized widget settings
     */
    public function update( $new_instance, $old_instance ) {

        //call the legacy update method for updates to existing widgets that don't have a version number (old format)...
        if( empty( $new_instance['cmwv'] ) ){
            return $this->cmw_legacy_update( $new_instance, $old_instance );
        }

        return self::cmw_settings(
            $new_instance,
            //allow a filter to return true, whereby any previous settings (now possibly unused) will be wiped instead of being allowed to remain...
            //eg. add_filter( 'custom_menu_wizard_wipe_on_update', [filter_function], 10, 1 ) => true
            apply_filters( 'custom_menu_wizard_wipe_on_update', false ) ? array() : $old_instance,
            __FUNCTION__ );

    } //end update()

    /**
     * produces the widget HTML at the front end
     *
     * @filters : custom_menu_wizard_nav_params           array of params that will be sent to wp_nav_menu(), array of instance settings, id base
     *            custom_menu_wizard_settings_pre_widget  array of instance settings, id base
     *            custom_menu_wizard_title_link_atts      array of link attributes, title text, array of instance settings, id base
     *            custom_menu_wizard_widget_output        HTML output string, array of instance settings, id base, $args
     *
     * @param object $args Widget arguments
     * @param array $instance Configuration for this widget instance
     */
    public function widget( $args, $instance ) {

        //call the legacy widget method for producing existing widgets that don't have a version number (old format)...
        if( !empty( $instance ) && empty( $instance['cmwv'] ) ){
            $this->cmw_legacy_widget( $args, $instance );
            return;
        }

        //if $instance is empty - as is the case when adding a new widget instance in the Customizer! -
        //then find the first eligible custom menu and use that as the menu...
        if( empty( $instance ) ){
            $i = 0;
            $menu = $this->cmw_get_custom_menus( $i );
            $menu = reset( $menu );
            if( !empty( $menu ) ){
                $instance['menu'] = $menu->term_id;
            }
        }

        //sanitize $instance...
        $instance = self::cmw_settings( $instance, array(), __FUNCTION__ );
        //holds information determined by the walker...
        $this->_cmw_walker = array();

        //allow a filter to amend the instance settings prior to producing the widget output...
        //eg. add_filter( 'custom_menu_wizard_settings_pre_widget', [filter_function], 10, 2 ) => $instance (array)
        $instance = apply_filters( 'custom_menu_wizard_settings_pre_widget', $instance, $this->id_base );

        //fetch menu...
        if( !empty( $instance['menu'] ) ){
            $menu = wp_get_nav_menu_object( $instance['menu'] );

            //no menu, no output...
            if ( !empty( $menu ) ){

                //unless told not to, put the shortcode equiv. into a data item...
                //NB: to turn this off (example):
                //    add_filter( 'custom_menu_wizard_settings_pre_widget', 'cmw_no_cmws', 10, 2 );
                //    function cmw_no_cmws( $instance, $id_base ){ $instance['cmws_off'] = true; return $instance; }
                $dataCMWS = empty( $instance['cmws_off'] ) ? " data-cmws='" . esc_attr( self::cmw_shortcode( $instance, true ) ) . "'" : '';

                if( !empty( $instance['container_class'] ) ){
                    //the menu-[menu->slug]-container class gets applied by WP UNLESS an alternative
                    //container class is supplied in the params - I'm going to set the param such that
                    //this instance's container class (if specified) gets applied IN ADDITION TO the
                    //default one...
                    $instance['container_class'] = "menu-{$menu->slug}-container {$instance['container_class']}";
                }

                $instance['menu_class'] = preg_split( '/\s+/', $instance['menu_class'], -1, PREG_SPLIT_NO_EMPTY );
                //add cmw-alternate-maybe & cmw-fellback-maybe classes to the menu and we'll remove or replace later...
                $instance['menu_class'][] = 'cmw-alternate-maybe';
                $instance['menu_class'][] = 'cmw-fellback-maybe';
                $instance['menu_class'] = implode( ' ', $instance['menu_class'] );

                $walker = new Custom_Menu_Wizard_Walker;
                $params = array(
                    'menu' => $menu,
                    'container' => empty( $instance['container'] ) ? false : $instance['container'],
                    'container_id' => $instance['container_id'],
                    'menu_class' => $instance['menu_class'],
                    'echo' => false,
                    'fallback_cb' => false,
                    'before' => $instance['before'],
                    'after' => $instance['after'],
                    'link_before' => $instance['link_before'],
                    'link_after' => $instance['link_after'],
                    'depth' => $instance['flat_output'] ? -1 : $instance['depth'],
                    'walker' =>$walker,
                    //widget specific stuff...
                    '_custom_menu_wizard' => $instance
                    );
                //for the walker's use...
                $params['_custom_menu_wizard']['_walker'] = array();
                //set wrapper to UL or OL...
                if( $instance['ol_root'] ){
                    $params['items_wrap'] = '<ol id="%1$s" class="%2$s" data-cmwv="' . $instance['cmwv'] . '"' . $dataCMWS . '>%3$s</ol>';
                }else{
                    $params['items_wrap'] = '<ul id="%1$s" class="%2$s" data-cmwv="' . $instance['cmwv'] . '"' . $dataCMWS . '>%3$s</ul>';
                }
                //add a container class...
                if( !empty( $instance['container_class'] ) ){
                    $params['container_class'] = $instance['container_class'];
                }

                //add my filters...
                add_filter('custom_menu_wizard_walker_items', array( $this, 'cmw_filter_walker_items' ), 10, 2);

                //allow a filter to amend the wp_nav_menu() params prior to calling it...
                //eg. add_filter( 'custom_menu_wizard_nav_params', [filter_function], 10, 3 ) => $params (array)
                //NB: wp_nav_menu() is in wp-includes/nav-menu-template.php
                $out = wp_nav_menu( apply_filters( 'custom_menu_wizard_nav_params', $params, $instance, $this->id_base ) );

                //remove my filters...
                remove_filter('custom_menu_wizard_walker_items', array( $this, 'cmw_filter_walker_items' ), 10, 2);

                //only put something out if there is something to put out...
                if( !empty( $out ) ){

                    //check to see if the settings have been changed, either as a result of invoking an alternative
                    //configuration, or due to the application of a custom_menu_wizard_walker_change_settings filter...
                    if( !empty( $this->_cmw_walker['instances'] ) ){
                        $instance = $this->_cmw_walker['instances']['new'];
                    }

                    //title from : priority is current -> current root -> branch -> branch root...
                    //note that none actually have to be present in the results
                    //v3.1.4 : used to get just the title string passed back, now get the menu item element!
                    //v3.1.5 : now just gets a single element, not all the possibilities
                    if( !empty( $this->_cmw_walker['get_title_from'] )
                            && !empty( $this->_cmw_walker['get_title_from']->title ) ){
                        //allow the widget_title filter to override...
                        $title = apply_filters( 'widget_title', $this->_cmw_walker['get_title_from']->title, $instance, $this->id_base );
                        //if we've been asked for a linked title...
                        if( $instance['title_linked'] ){
                            $n = array(
                                'title'  => empty( $this->_cmw_walker['get_title_from']->attr_title ) ? '' : $this->_cmw_walker['get_title_from']->attr_title,
                                'target' => empty( $this->_cmw_walker['get_title_from']->target )     ? '' : $this->_cmw_walker['get_title_from']->target,
                                'rel'    => empty( $this->_cmw_walker['get_title_from']->xfn )        ? '' : $this->_cmw_walker['get_title_from']->xfn,
                                'href'   => empty( $this->_cmw_walker['get_title_from']->url )        ? '' : $this->_cmw_walker['get_title_from']->url,
                                'class'  => 'cmw-linked-widget-title'
                            );
                            $n = apply_filters( 'custom_menu_wizard_title_link_atts', $n, $this->_cmw_walker['get_title_from'], $instance, $this->id_base );
                            $atts = '';
                            foreach ( (array)$n as $i => $j ) {
                                if ( !empty( $j ) ) {
                                    $j = ( $i === 'href' ) ? esc_url( $j ) : esc_attr( $j );
                                    $atts .= ' ' . $i . '="' . $j . '"';
                                }
                            }
                            if( !empty( $atts ) ){
                                $title = '<a' . $atts . '>' . $title . '</a>';
                            }
                        }
                    }
                    if( empty( $title ) ){
                        $title = $instance['hide_title'] ? '' : apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
                    }

                    //remove/replace the cmw-fellback-maybe class...
                    $out = str_replace(
                        array(
                            'cmw-fellback-maybe',
                            'cmw-alternate-maybe'
                        ),
                        array(
                            empty( $this->_cmw_walker['fellback'] ) ? '' : 'cmw-fellback-' . $this->_cmw_walker['fellback'],
                            empty( $this->_cmw_walker['alternative'] ) ? '' : 'cmw-invoked-alternative'
                        ),
                        $out );

                    //try to add widget_class (if specified) to before_widget...
                    if( !empty( $instance['widget_class'] ) && !empty( $args['before_widget'] ) ){
                        //$args['before_widget'] is usually just a DIV start-tag, with an id and a class; if it
                        //gets more complicated than that then this may not work as expected...
                        if( preg_match( '/^<[^>]+?class=["\']/', $args['before_widget'] ) > 0 ){
                            //...already has a class attribute : prepend mine...
                            $args['before_widget'] = preg_replace( '/(class=["\'])/', '$1' . $instance['widget_class'] . ' ', $args['before_widget'], 1 );
                        }else{
                            //...doesn't currently have a class : add class attribute...
                            $args['before_widget'] = preg_replace( '/^(<\w+)(\s|>)/', '$1 class="' . $instance['widget_class'] . '"$2', $args['before_widget'] );
                        }
                    }

                    if( !empty( $title ) ){
                        $out = $args['before_title'] . $title . $args['after_title'] . $out;
                    }
                    $out = $args['before_widget'] . $out . $args['after_widget'];
                    //allow a filter to modify the entire output...
                    //eg. add_filter( 'custom_menu_wizard_widget_output', [filter_function], 10, 4 ) => $output (HTML string)
                    //NB 4th parameter ($args) added at v3.0.3
                    echo apply_filters( 'custom_menu_wizard_widget_output', $out, $instance, $this->id_base, $args );
                }
            }
        }

    } //end widget()

    /**
     * outputs an assist anchor
     */
    public function cmw_assist_link(){

        //don't really need to worry about the id for non-javascript enabled usage because the css hides the
        //button, but it doesn't hurt so I've left it in...
        $hashid = $this->get_field_id( 'cmw' . ++$this->_cmw_hash_ct );
        ?><a class="widget-<?php echo $this->id_base; ?>-assist button" id="<?php echo $hashid; ?>" href="#<?php echo $hashid; ?>"><?php _e('assist', 'custom-menu-wizard'); ?></a><?php

    }

    /**
     * outputs the HTML to close off a collapsible/expandable group of settings
     */
    public function cmw_close_a_field_section(){

        ?></div><?php

    } //end cmw_close_a_field_section()

    /**
     * either pushes, pops, or echoes last of, the disabled attributes array
     * note that if accessibility mode is on, nothing should get disabled!
     * as of 3.1.0, nothing gets disabled, just coloured grey (incl. legacy versions)!
     *
     * @param string $action 'pop' or 'push'
     * @param boolean $test What to push
     */
    public function cmw_disableif( $action = 'echo', $test = false ){

        if( !isset( $this->_cmw_disableif ) ){
            $this->_cmw_disableif = array( '' );
        }
        if( $action == 'push' ){
            if( $test && !$this->_cmw_accessibility ){
                //append disabled attribute...
                //v3.1.0 : nothing gets disabled, including any legacy stuff!
//              $this->_cmw_disableif[] = 'disabled="disabled"';
                $this->_cmw_disableif[] = '';
                //and echo disabled class...
                echo ' cmw-colour-grey';
            }else{
                //append a copy of current last element (maintaining status quo)...
                $e = array_slice( $this->_cmw_disableif, -1 );
                $this->_cmw_disableif[] = $e[0];
            }
        }elseif( $action == 'pop' ){
            //remove last element (if count is greater than 1, so it is never left totally empty by mistake)...
            if( count( $this->_cmw_disableif ) > 1 ){
                array_pop( $this->_cmw_disableif );
            }
        }else{
            //echo last element...
            $e = array_slice( $this->_cmw_disableif, -1 );
            echo $e[0];
        }

    }

    /**
     * v1.2.1 stores any walker-determined information back into the widget instance
     * gets run by the walker, on the filtered array of menu items, just before running parent::walk()
     * only gets run *if* there are menu items found
     *
     * @param array $items Filtered menu items
     * @param object $args
     * @return array Menu items
     */
    public function cmw_filter_walker_items( $items, $args ){

        if( !empty( $args->_custom_menu_wizard['_walker'] ) ){
            $this->_cmw_walker = $args->_custom_menu_wizard['_walker'];
        }
        return $items;

    } //end cmw_filter_walker_items()

    /**
     * output a checkbox field
     *
     * @param array $instance Contains current field value
     * @param string $field Field name
     * @param array $params Attribute values
     */
    public function cmw_formfield_checkbox( &$instance, $field, $params ){

        $labelClass = empty( $params['lclass'] ) ? '' : $params['lclass'];
        $fieldClass = empty( $params['fclass'] ) ? '' : $params['fclass'];
        $disabling = !empty( $labelClass ) && isset( $params['disableif'] );
?>

<label class="<?php echo $labelClass; if( $disabling ){ $this->cmw_disableif( 'push', $params['disableif'] ); } ?>">
    <input type="checkbox" <?php $this->cmw_disableif(); ?> value="1" <?php
        ?>id="<?php echo $this->get_field_id( $field ); ?>" class="<?php echo $fieldClass; ?>" <?php
        ?>name="<?php echo $this->get_field_name( $field ); ?>" <?php checked($instance[ $field ]); ?> /><?php echo $params['label']; ?></label>
<?php   if( $disabling ) :
            $this->cmw_disableif( 'pop' );
        endif;
        if( !empty( $params['desc'] ) ) : ?>
<span class="cmw-small-block"><em class="cmw-colour-grey"><?php echo $params['desc']; ?></em></span>

<?php endif;

    } // end cmw_formfield_checkbox()

    /**
     * output a text input field
     *
     * @param array $instance Contains current field value
     * @param string $field Field name
     * @param array $params Attribute values
     */
    public function cmw_formfield_textbox( &$instance, $field, $params ){

        $fieldClass = empty( $params['fclass'] ) ? '' : $params['fclass'];

        if( !empty( $params['label'] ) ) : ?>

<label for="<?php echo $this->get_field_id( $field ); ?>"><?php echo $params['label']; ?></label>
<?php endif; ?>
<input type="text" <?php $this->cmw_disableif(); ?> value="<?php echo $instance[ $field ]; ?>" <?php
    ?>id="<?php echo $this->get_field_id( $field ); ?>" class="<?php echo $fieldClass; ?>" <?php
    ?>name="<?php echo $this->get_field_name( $field ); ?>" />
<?php if( !empty( $params['desc'] ) ) : ?>
<span class="cmw-small-block"><em class="cmw-colour-grey"><?php echo $params['desc']; ?></em></span>

<?php endif;

    } // end cmw_formfield_textbox()

    /**
     * gets menus (in name order) and their items, returning empty array if there are none (or if none have items)
     *
     * @param integer $selectedMenu (by reference) The instance setting to check against for a menu to be "selected"
     * @return array
     */
    public function cmw_get_custom_menus( &$selectedMenu ){

        $findSM = $selectedMenu > 0;
        $menus = wp_get_nav_menus( array( 'orderby' => 'name' ) );
        if( !empty( $menus ) ){
            foreach( $menus as $i => $menu ){
                //find the menu's items, then remove any menus that have no items...
                //note : sending a huge number through to the sorter should prevent orphans being
                //       appended to the returned array.
                //       but also note that if the entire menu is orphans, the sorter will appoint
                //       the first item in $elements as "root"!
                //no longer need to check for all orphans (no root) because the hierarchy sort
                //will create one if there weren't any before!
                $menus[ $i ]->_items = $this->_cmw_hierarchy->walk( wp_get_nav_menu_items( $menu->term_id ), 65532 );
                if( empty( $menus[ $i ]->_items ) ){
                    unset( $menus[ $i ] );
                }elseif( $findSM && $selectedMenu == $menu->term_id ){
                    $findSM = false;
                }
            }
        }
        //if findSM is TRUE then we were looking for a specific menu and failed to find it (or it had no eligible items)...
        if( $findSM ){
            //clear selectedMenu...
            $selectedMenu = 0;
            //this would be the place to flag a warning!
        }

        return empty( $menus ) ? array() : array_values( $menus );

    } // end cmw_get_custom_menus()

    /**
     * gets the various option, optgroups, max levels, etc, from the available custom menus (if any)
     *
     * @param integer $selectedMenu The instance setting to check against for a menu to be "selected"
     * @param integer $selectedItem The instance setting to check against for an menu item to be "selected"
     * @return array|boolean
     */
    public function cmw_scan_menus( $selectedMenu, $selectedItem ){

        //create the options for the menu select & branch select...
        // IE is a pita when it comes to SELECTs because it ignores any styling on OPTGROUPs and OPTIONs, so I'm using
        // a copy from which the javascript can pick the relevant OPTGROUP
        $rtn = array(
            'maxlevel' => 1,                                 //maximum number of levels (across all menus)
            'names' => array(),                              //HTML of OPTIONs, for selecting a menu (returned as a string)
            'optgroups' => array(),                          //HTML of OPTGROUPs & contained OPTIONs, for selecting an item (returned as a string)
            'selectedOptgroup' => array(''),                 //HTML of currently selected menu's OPTGROUP and its OPTIONs (returned as string)
            'selectedBranchName' => __('the Current Item', 'custom-menu-wizard'),  //title of currently selected menu item
            'selectedLevels' => 1                            //number of levels in the currently selected menu
            );

        //couple of points:
        // - if there's no currently selected menu (eg. it's a new, unsaved form) then use the first menu found that has eligible items
        // - if there is a currently selected menu, but that menu is no longer available (no longer exists, or now has no eligible items)
        //   then, again, use the first menu found that does have items. PROBLEM : this means that the widget's instance settings
        //   won't match what the widget is currently displaying! this situation is not unique to this function because it can
        //   also occur for things like depth, but it does raise the question of whether the user should be informed that what
        //   is being presented does not match the current saved settings?
        //   Note that also applies to selected item (ie. the menu still exists but the currently selected item within that menu does not).

        $ct = 0;
        $sogCt = 0;
        $itemindents = $menu = $item = NULL;
        //note that fetching the menus can clear selectedMenu!
        foreach( $this->cmw_get_custom_menus( $selectedMenu ) as $i => $menu ){
            $maxgrplevel = 1;
            $itemindents = array( '0' => 0 );
            $menuGrpOpts = '';
            //don't need to check for existence of items because if there were none then the menu wouldn't be here!
            foreach( $menu->_items as $item ){
                //exclude orphans!
                if( isset( $itemindents[ $item->menu_item_parent ] ) ){
                    $title = $item->title;
                    $level = $itemindents[ $item->menu_item_parent ] + 1;

                    $itemindents[ $item->ID ] = $level;
                    $rtn['maxlevel'] = max( $rtn['maxlevel'], $level );
                    $maxgrplevel = max( $maxgrplevel, $level );

                    //if there is no currently selected menu AND this is the first found item for this menu then
                    //set this menu as the currently selected menu (being the first one found with an eligible item)...
                    if( empty( $selectedMenu ) && empty( $menuGrpOpts ) ){
                        $selectedMenu = $menu->term_id;
                    }
                    //only if THIS is the currently selected menu do we determine "selected" for each menu item...
                    if( $selectedMenu == $menu->term_id ){
                        $selected = selected( $selectedItem, $item->ID, false );
                        if( !empty( $selected ) ){
                            $rtn['selectedBranchName'] = $title;
                            $selected .= ' ';
                        }
                        $rtn['selectedOptgroup'][ $sogCt ] .= '<option value="' . $item->ID . '" ' . $selected . 'data-cmw-level="' . $level . '" data-cmw-type="' . $item->type_label . '">';
                        $rtn['selectedOptgroup'][ $sogCt ] .= str_repeat( '&nbsp;', ($level - 1) * 3 ) . esc_attr( $title ) . '</option>';
                    }
                    //don't set "selected" on the big list...
                    $menuGrpOpts .= '<option value="' . $item->ID . '" data-cmw-level="' . $level . '" data-cmw-type="' . $item->type_label . '">';
                    $menuGrpOpts .= str_repeat( '&nbsp;', ($level - 1) * 3 ) . esc_attr( $title ) . '</option>';
                }
            }

            //should never be empty, but check nevertheless...
            if( !empty( $menuGrpOpts ) ){
                $rtn['names'][ $ct ] = '<option ' . selected( $selectedMenu, $menu->term_id, false ) . ' value="' . $menu->term_id . '">' . $menu->name . '</option>';
                $rtn['optgroups'][ $ct ]  = '<optgroup label="' . $menu->name . '" data-cmw-optgroup-index="' . $ct . '" data-cmw-max-level="' . $maxgrplevel . '">';
                $rtn['optgroups'][ $ct ] .= $menuGrpOpts;
                $rtn['optgroups'][ $ct ] .= '</optgroup>';
                //if this menu is selected, then store this optgroup as the selected optgroup, and the number of levels it has...
                if( $selectedMenu == $menu->term_id ){
                    $rtn['selectedOptgroup'][ $sogCt ] = '<optgroup label="' . $menu->name . '" data-cmw-optgroup-index="' . $ct . '" data-cmw-max-level="' . $maxgrplevel . '">' . $rtn['selectedOptgroup'][ $sogCt ] . '</optgroup>';
                    $rtn['selectedOptgroup'][ ++$sogCt ] = '';
                    $rtn['selectedLevels'] = $maxgrplevel;
                }elseif( $this->_cmw_accessibility ){
                    //if accessibility is on then the selected groups need to contain *all* the groups otherwise, with javascript disabled, the
                    //user will not be able to select menu items from a switched menu without saving first. if javascript is not disabled, then
                    //the script should initially remove any optgroups not immediately required...
                    $rtn['selectedOptgroup'][ $sogCt ] = $rtn['optgroups'][ $ct ];
                    $rtn['selectedOptgroup'][ ++$sogCt ] = '';
                }
                $ct++;
            }
        }
        unset( $itemindents, $menu, $item );

        if( empty( $rtn['names'] ) ){
            $rtn = false;
        }else{
            $rtn['names'] = implode( '', $rtn['names'] );
            $rtn['optgroups'] = implode( '', $rtn['optgroups'] );
            $rtn['selectedOptgroup'] = implode( '', $rtn['selectedOptgroup'] );
            if( $this->_cmw_accessibility ){
                //reset levels of selected optgroup to be the max levels of any group...
                $rtn['selectedLevels'] = $rtn['maxlevel'];
            }
            //send the currently selected menu id back (may be different from the value when passed
            //in, if this is a new instance or if a menu set for an existing instance has been deleted)
            $rtn['selectedMenu'] = $selectedMenu;
        }
        return $rtn;

    }

    /**
     * outputs the HTML to begin a collapsible/expandable group of settings
     *
     * @param array $instance
     * @param string $text Label
     * @param string $fname Field name
     */
    public function cmw_open_a_field_section( &$instance, $text, $fname ){

        $hashid = $this->get_field_id( 'cmw' . ++$this->_cmw_hash_ct );
?>

<a class="widget-<?php echo $this->id_base; ?>-fieldset dashicons-before<?php echo $instance[$fname] ? ' cmw-collapsed-fieldset' : ''; ?>"
    id="<?php echo $hashid; ?>" href="#<?php echo $hashid; ?>"><?php echo $text; ?></a>
<input id="<?php echo $this->get_field_id($fname); ?>" class="cmw-display-none cmw-fieldset-state"
    name="<?php echo $this->get_field_name($fname); ?>" type="checkbox" value="1" <?php checked( $instance[$fname] ); ?> />
<div class="cmw-fieldset<?php echo $instance[$fname] ? ' cmw-start-fieldset-collapsed' : ''; ?>">

<?php

    } //end cmw_open_a_field_section()

    /**
     * sanitizes the widget settings for update(), widget() and form()
     *
     * @param array $from_instance Widget settings
     * @param array $base_instance Old widget settings or an empty array
     * @param string Name of the calling method
     * @return array Sanitized widget settings
     */
    public static function cmw_settings( $from_instance, $base_instance = false, $method = 'widget' ){

/* old (pre v3) settings...
        //switches...
        'include_ancestors' => 0                   : replaced by ancestors
        'include_parent' => 0                      : replaced by ancestors
        'include_parent_siblings' => 0             : replaced by ancestor_siblings
        'title_from_parent' => 0                   : replaced by title_from_branch
        'fallback_no_ancestor' => 0                : no longer applicable
        'fallback_include_parent' => 0             : no longer applicable
        'fallback_include_parent_siblings' => 0    : no longer applicable (but "sort of" replicated by fallback_siblings)
        'fallback_no_children' => 0                : replaced by fallback
        'fallback_nc_include_parent' => 0          : no longer applicable
        'fallback_nc_include_parent_siblings' => 0 : no longer applicable
        //integers...
        'filter_item' => -2                        : replaced by branch
        'start_level' => 1                         : replaced by level & branch_start
*/

        $instance = is_array( $base_instance ) ? $base_instance : array();

        //switches : values are defaults...
        foreach( array(
                'allow_all_root'                    => 0, //v3.0.0
                'depth_rel_current'                 => 0,
                'fallback_ci_lifo'                  => 0, //v3.1.5 changes determination of current item from first-found to last-found
                'fallback_ci_parent'                => 0, //v3.1.0 enables fallback determination of current item to item having current_item_parent set
                'fallback_siblings'                 => 0, //v3.0.0 sort of replaces fallback_include_parent_siblings
                'flat_output'                       => 0,
                'hide_title'                        => 0,
                'siblings'                          => 0, //v3.0.0 replaces include_parent_siblings
                'include_root'                      => 0, //v3.0.0 ; v3.0.4 replaced/expanded by include_level DEPRECATED
                //v3.1.5 : the title_from_* fields are now DEPRECATED and have been replace with string fields title_branch and title_current
                'title_from_branch'                 => 0, //v3.0.0 replaces title_from_parent DEPRECATED
                'title_from_branch_root'            => 0, //v3.0.0 added DEPRECATED
                'title_from_current'                => 0, // DEPRECATED
                'title_from_current_root'           => 0, //v3.0.0 added DEPRECATED
                'title_linked'                      => 0, //v3.1.4 added
                'ol_root'                           => 0,
                'ol_sub'                            => 0,
                //field section collapsed toggles...
                'fs_filters'                        => 1, //v3.0.0 replaces fs_filter and now starts out collapsed
                'fs_fallbacks'                      => 1,
                'fs_output'                         => 1,
                'fs_container'                      => 1,
                'fs_classes'                        => 1,
                'fs_links'                          => 1,
                'fs_alternative'                    => 1  //v3.1.0
                ) as $k => $v ){

            if( $method == 'update' ){
                //store as 0 or 1...
                $instance[ $k ] = empty( $from_instance[ $k ] ) ? 0 : 1;
            }else{
                //use internally as boolean...
                $instance[ $k ] = isset( $from_instance[ $k ] ) ? !empty( $from_instance[ $k ] ) : !empty( $v );
            }
        }

        //integers : values are minimums (defaults are the values maxed against 0)...
        foreach( array(
                'ancestors'         => -9999, //v3.0.0 replaces include_ancestors, but with levels (relative & absolute)
                'ancestor_siblings' => -9999, //v3.0.0 also has levels (relative & absolute)
                'depth'             => 0,
                'branch'            => -999999,  //v3.0.0 replaces filter_item, but without current parent|root item, v3.2.4 allows negative
                'menu'              => 0,
                'level'             => 1,  //v3.0.0 replace start_level (for a level filter)
                'fallback_depth'    => 0   //v3.0.0 added
                ) as $k => $v ){

            $instance[ $k ] = isset( $from_instance[ $k ]) ? max( $v, intval( $from_instance[ $k ] ) ) : max( $v, 0 );
        }

        //strings : values are defaults...
        foreach( array(
                'title'             => '',
                'filter'            => '',  //v3.0.0 changed from integer ('', 'branch', 'items'), where empty is equiv. to 'level' (was level=0, branch=1, items=-1)
                'branch_start'      => '',  //v3.0.0 replace start_level (for a branch filter)
                'start_mode'        => '',  //v3.0.0 forces branch_start to use entire level ('', 'level')
                'title_branch'      => '',  //v3.1.5 replace title_from_branch/branch_root ('', 0 or a signed? number)
                'title_current'     => '',  //v3.1.5 replace title_from_current/current_root ('', 0 or a signed? number)
                'contains_current'  => '',  //v3.0.0 changed from switch ('', 'menu', 'primary', 'secondary', 'inclusions' or 'output')
                'container'         => 'div',
                'container_id'      => '',
                'container_class'   => '',
                'exclude_level'     => '',  //v3.0.0 (1 or more digits, possibly with an appended '-' or '+')
                'fallback'          => '',  //v3.0.0 replace fallback_no_children ('', 'parent', 'current', 'quit')
                'include_level'     => '',  //v3.0.4 (1 or more digits, possibly with an appended '-' or '+')
                'switch_if'         => '', //v3.1.0 ('', 'current', 'no-current', 'no-output')
                'switch_at'         => '', //v3.1.0 (same as for contains_current)
                'switch_to'         => '', //v3.1.0 (a [cmwizard .../] shortcode)
                'menu_class'        => 'menu-widget',
                'widget_class'      => '',
                'cmwv'              => Custom_Menu_Wizard_Plugin::$version
                ) as $k => $v ){

            $instance[ $k ] = isset( $from_instance[ $k ] ) ? strip_tags( trim( (string)$from_instance[ $k ] ) ) : $v;
            if( $method == 'form' ){
                //escape strings...
                $instance[ $k ] = esc_attr( trim( $instance[ $k ] ) );
            }
        }
        if( $method == 'widget' && !empty( $instance['switch_to'] ) ){
            $instance['switch_to'] = apply_filters( 'custom_menu_wizard_sanitize_alternative', $instance['switch_to'] );
        }

        //html strings : values are defaults...
        foreach( array(
                'before'       => '',
                'after'        => '',
                'link_before'  => '',
                'link_after'   => ''
                ) as $k => $v ){

            $instance[ $k ] = isset( $from_instance[ $k ] ) ? trim( (string)$from_instance[ $k ] ) : $v;
            if( $method == 'form' ){
                //escape html strings...
                $instance[ $k ] = esc_html( trim( $instance[ $k ] ) );
            }
        }

        //csv strings : values are defaults...
        foreach( array(
                'exclude'  => '',  //v3.0.0 added
                'items'    => ''
                ) as $k => $v ){

            $inherits = array();
            $instance[ "_$k" ] = array();
            $instance[ $k ] = isset( $from_instance[ $k ] ) ? trim( (string)$from_instance[ $k ] ) : $v;
            foreach( preg_split('/[,\s]+/', $instance[ $k ], -1, PREG_SPLIT_NO_EMPTY ) as $i ){
                //values can be just digits (maybe with leading '-'), or digits followed by a '+' (for inheritance)...
                if( preg_match( '/^(-?\d+)(\+?)$/', $i, $m ) > 0 ){
                    $i = intval( $m[1] );
                    if( $i != 0 ){
                        if( !empty( $m[2] ) ){
                            $inherits[] = $i;
                            $i = $i . '+';
                        }
                        if( !in_array( "$i", $instance[ "_$k" ] ) ){
                            $instance[ "_$k" ][] = "$i";
                        }
                    }
                }
            }
            if( !empty( $inherits ) ){
                $instance[ "_$k" ] = array_diff( $instance[ "_$k" ], $inherits );
            }
            unset( $inherits );
            //just store as comma-separated...
            $instance[ $k ] = implode( ',', $instance[ "_$k" ] );
            //can dump the underbar versions if called from update()...
            if( $method == 'update' ){
                unset( $instance[ "_$k" ] );
            }
        }

        //v3.0.4 : v3.0.* back compat...
        //include_root was a boolean, but has been replaced with include_level, and the equiv. of include_root On is include_level=1...
        if( $instance['include_root'] && empty( $instance['include_level'] ) ){
            $instance['include_level'] = '1';
        }
        unset( $instance['include_root'] );

        //v3.1.5 : back compat...
        //the 4 title_from_branch/current[_root] fields were booleans, but they're now DEPRECATED
        //and have been replaced by 2 string fields, title_branch & title_current
        if( $instance['title_branch'] === '' ){
            if( !empty( $instance['title_from_branch_root'] ) ){
                $instance['title_branch'] = 1;
            }
            if( !empty( $instance['title_from_branch'] ) ){
                $instance['title_branch'] = 0;
            }
        }
        if( $instance['title_current'] === '' ){
            if( !empty( $instance['title_from_current_root'] ) ){
                $instance['title_current'] = 1;
            }
            if( !empty( $instance['title_from_current'] ) ){
                $instance['title_current'] = 0;
            }
        }
        unset( $instance['title_from_branch'],
            $instance['title_from_branch_root'],
            $instance['title_from_current'],
            $instance['title_from_current_root'] );

        return $instance;

    } //end cmw_settings()

    /**
     * returns the shortcode equivalent of the current settings (not called by legacy code!)
     *
     * @param array $instance
     * @param boolean $asJSON Requests response in JSON format, for the data-cmws attribute
     * @return string
     */
    public static function cmw_shortcode( $instance, $asJSON=false ){

        $args = array(
            'menu' => $instance['menu']
        );
        $byBranch = $instance['filter'] == 'branch';
        $byItems = $instance['filter'] == 'items';
        $byLevel = !$byBranch && !$byItems;

        //take notice of the widget's hide_title flag...
        if( !empty( $instance['title'] ) && !$instance['hide_title'] ){
            $args['title'] = array( $instance['title'] );
        }
        //byLevel is the default (no branch & no items), as is level=1, so we only *have* to specify level if it's greater than 1...
        if( $byLevel && $instance['level'] > 1 ){
            $args['level'] = $instance['level'];
        }
        //specifying branch sets byBranch, overriding byLevel...
        if( $byBranch ){
            //use the alternative for 0 ("current") because it's more self-explanatory...
            $args['branch'] = $instance['branch'] == 0 ? 'current' : $instance['branch'];
            //start_at only *has* to be specified if not empty...
            if( !empty( $instance['branch_start'] ) ){
                $args['start_at'] = array( $instance['branch_start'] );
            }
            //start_mode may be brought into play by a fallback so always specify it...
            if( $instance['start_mode'] == 'level' ){
                $args['start_mode'] = 'level';
            }
            //allow_all_root is only applicable to byBranch...
            //NB this could be refined further, in that it only comes into play if
            //   (a) start_mode is set to level, or
            //   (b) there is a no-kids fallback set that produces output AND asks for siblings
            //but that gets a bit fussy so I'm leaving it as-is.
            if( $instance['allow_all_root'] ){
                $args['allow_all_root'] = 1;
            }
        }
        //specifying items set byItems, overriding byLevel & byBranch...
        if( $byItems ){
            $args['items'] = $instance['_items'];
        }
        //depth is not relevant to byItems...
        else{
            //depth if greater than 0...
            if( $instance['depth'] > 0 ){
                $args['depth'] = $instance['depth'];
            }
            //depth relative to current item is only applicable if depth is not unlimited...
            if( $instance['depth_rel_current'] && $instance['depth'] > 0 ){
                $args['depth_rel_current'] = 1;
            }
        }
        //fallbacks...
        //no children : branch = current item...
        if( $byBranch && $instance['branch'] == 0 ){
            if( !empty( $instance['fallback'] ) ){
                $args['fallback'] = array( $instance['fallback'] );
                if( $args['fallback'] != 'quit' ){
                    if( $instance['fallback_siblings'] ){
                        $args['fallback'][] = '+siblings';
                    }
                    if( $instance['fallback_depth'] > 0 ){
                        $args['fallback'][] = $instance['fallback_depth'];
                    }
                }
            }
        }
        //branch ancestor inclusions...
        if( $byBranch && !empty( $instance['ancestors'] ) ){
            $args['ancestors'] = $instance['ancestors'];
            //only ancestor-siblings if ancestors...
            if( !empty( $instance['ancestor_siblings'] ) ){
                $args['ancestor_siblings'] = $instance['ancestor_siblings'];
            }
        }
        //inclusions by level...
        if( !empty( $instance['include_level'] ) ){
            $args['include_level'] = array( $instance['include_level'] );
        }
        //exclusions by id...
        if( !empty( $instance['_exclude'] ) ){
            $args['exclude'] = $instance['_exclude'];
        }
        //...and by level...
        if( !empty( $instance['exclude_level'] ) ){
            $args['exclude_level'] = array( $instance['exclude_level'] );
        }
        //title from...
        $n = array();
        if( $instance['title_current'] !== '' ){
            if( $instance['title_current'] == '0' ){
                $n[] = 'current';
            }else{
                $n[] = 'current' . $instance['title_current'];
            }
        }
        if( $byBranch && $instance['title_branch'] !== '' ){
            if( $instance['title_branch'] == '0' ){
                $n[] = 'branch';
            }else{
                $n[] = 'branch' . $instance['title_branch'];
            }
        }
        if( !empty( $n ) ){
            $args['title_from'] = $n;
            //...title_linked is only relevant if title_from is set...
            if( $instance['title_linked'] ){
                $args['title_linked'] = 1;
            }
        }
        //switches...
        foreach( array('siblings', 'flat_output', 'ol_root', 'ol_sub', 'fallback_ci_parent', 'fallback_ci_lifo') as $n ){
            if( $instance[ $n ] ){
                $args[ $n ] = 1;
            }
        }
        //strings...
        foreach( array(
                'contains_current' => '',
                'container' => 'div',
                'container_id' => '',
                'container_class' => '',
                'menu_class' => 'menu-widget',
                'widget_class' => ''
                ) as $n => $v ){
            if( $instance[ $n ] != $v ){
                $args[ $n ] = array( $instance[ $n ] );
            }
        }
        foreach( array(
                'wrap_link' => 'before',
                'wrap_link_text' => 'link_before'
                ) as $n => $v ){
            if( preg_match( '/^<(\w+)/', $instance[ $v ], $m ) > 0 ){
                $args[ $n ] = array( $m[1] );
            }
        }
        //alternative...
        if( !empty( $instance['switch_if'] ) && !empty( $instance['switch_at'] ) ){
            $args['alternative'] = array( $instance['switch_if'], $instance['switch_at'] );
            $content = apply_filters( 'custom_menu_wizard_sanitize_alternative', $instance['switch_to'] );
        }
        //build the shortcode...
        $m = array();
        foreach( $args as $n => $v ){
            //array indicates join (with comma sep) & surround it in double quotes, otherwise leave 'as-is'...
            if( $asJSON ){
                $m[ $n ] = is_array( $v ) ? implode( ',', $v ) : $v;
            }else{
                $m[] = is_array( $v ) ? $n . '="' . implode( ',', $v ) . '"' : $n . '=' . $v;
            }
        }
        unset( $args );

        //NB at v3.0.0, the shortcode changed from custom_menu_wizard to cmwizard (the previous version is still supported)
        //for JSON, don't output content...
        return $asJSON ? json_encode( $m ) : '[cmwizard ' . implode( ' ', $m ) . ( empty( $content ) ? '/]' : ']' . $content . '[/cmwizard]' );

    } //end cmw_shortcode()



    /*======================
     * LEGACY CODE (v2.1.0)
     *======================*/

    /**
     * produces the legacy version of the backend admin form(s)
     *
     * @filters : custom_menu_wizard_prevent_legacy_updates        false
     *
     * @param array $instance Widget settings
     */
    public function cmw_legacy_form( $instance ) {

        //sanitize $instance...
        $instance = $this->cmw_legacy_settings( $instance, array(), 'form' );

        //if no populated menus exist, suggest the user go create one...
        if( ( $menus = $this->cmw_scan_menus( $instance['menu'], $instance['filter_item'] ) ) === false ) : ?>

<p class="widget-<?php echo $this->id_base; ?>-no-menus">
    <?php printf( wp_kses( __('No populated menus have been created yet! <a href="%s">Create one...</a>', 'custom-menu-wizard'), array('a'=>array('href'=>array())) ), admin_url('nav-menus.php') ); ?>
</p>

<?php
            return;
        endif;

        //set up some simple booleans for use at the disableif___ classes...
        $isShowSpecific = $instance['filter'] < 0; // disableif-ss (IS show specific items)
        $isNotChildrenOf = $instance['filter'] < 1; // disableif (is NOT Children-of)
        $isNotCurrentRootParent = $isNotChildrenOf || $instance['filter_item'] >= 0; // disableifnot-rp (is NOT Children-of Current Root/Parent)
        $isNotCurrentItem = $isNotChildrenOf || $instance['filter_item'] != 0; // disableifnot-ci (is NOT Children-of Current Item)

?>

<div id="<?php echo $this->get_field_id('onchange'); ?>"
        class="widget-<?php echo $this->id_base; ?>-onchange"
        data-cmw-instance-version='2.1.0'
        data-cmw-dialog-nonce='<?php echo wp_create_nonce( 'cmw-find-shortcodes' ); ?>'
        data-cmw-dialog-id='<?php echo $this->get_field_id('dialog'); ?>'
        data-cmw-legacy='true'>
<?php
    /**
     * Legacy warning...
     */
?>
    <p class="cmw-legacy-warn">
        <a class="widget-<?php echo $this->id_base; ?>-legacy-close cmw-legacy-close" title="<?php _e('Dismiss', 'custom-menu-wizard'); ?>" href="#">X</a>
        <em><?php _e('This is an old version of the widget!', 'custom-menu-wizard'); ?>
<?php
        //allow a filter to return true, whereby updates to legacy widgets are disallowed...
        //eg. apply_filter( 'custom_menu_wizard_prevent_legacy_updates', [filter function], 10, 1 ) => true
        if( apply_filters( 'custom_menu_wizard_prevent_legacy_updates', false ) ) :
?>
        <br /><?php _e('Any changes you make will NOT be Saved!', 'custom-menu-wizard'); ?>
<?php
        endif;
?>
        <br /><?php _e('Please consider creating a new instance of the widget to replace this one.', 'custom-menu-wizard'); ?>
        <a href="<?php echo $this->_cmw_legacy_warnreadmore; ?>" target="_blank"><?php _e('read more', 'custom-menu-wizard'); ?></a></em>
    </p>

<?php

        /**
         * permanently visible section : Title (with Hide) and Menu
         */
?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'custom-menu-wizard') ?></label>
        <?php $this->cmw_formfield_checkbox( $instance, 'hide_title',
            array(
                'label' => _x('Hide', 'verb', 'custom-menu-wizard'),
                'lclass' => 'alignright'
            ) ); ?>
        <?php $this->cmw_formfield_textbox( $instance, 'title',
            array(
                'desc' => __('Title can be set, but need not be displayed', 'custom-menu-wizard'),
                'fclass' => 'widefat cmw-widget-title'
            ) ); ?>
    </p>

    <p>
        <?php $this->cmw_assist_link(); ?>
        <label for="<?php echo $this->get_field_id('menu'); ?>"><?php _e('Select Menu:', 'custom-menu-wizard'); ?></label>
        <select id="<?php echo $this->get_field_id('menu'); ?>" <?php $this->cmw_disableif(); ?>
                class="cmw-select-menu cmw-listen" name="<?php echo $this->get_field_name('menu'); ?>">
            <?php echo $menus['names']; ?>
        </select>
    </p>

<?php
        /**
         * start collapsible section : 'Filter'
         */
        $this->cmw_open_a_field_section( $instance, __('Filter', 'custom-menu-wizard'), 'fs_filter' );
?>
    <p><?php $this->cmw_assist_link(); ?>
        <label>
            <input id="<?php echo $this->get_field_id('filter'); ?>_0" class="cmw-showall cmw-listen" <?php $this->cmw_disableif(); ?>
                name="<?php echo $this->get_field_name('filter'); ?>" type="radio" value="0" <?php checked( $instance['filter'], 0 ); ?> />
            <?php _e('Show all', 'custom-menu-wizard'); ?></label>
        <br /><label>
            <input id="<?php echo $this->get_field_id('filter'); ?>_1" class="cmw-listen" <?php $this->cmw_disableif(); ?>
                name="<?php echo $this->get_field_name('filter'); ?>" type="radio" value="1" <?php checked( $instance['filter'], 1 ); ?> />
            <?php _e('Children of:', 'custom-menu-wizard'); ?></label>
        <select id="<?php echo $this->get_field_id('filter_item'); ?>" class="cmw-childrenof cmw-assist-items cmw-listen"
                name="<?php echo $this->get_field_name('filter_item'); ?>" <?php $this->cmw_disableif(); ?>>
            <option value="0" <?php selected( $instance['filter_item'], 0 ); ?>><?php _e('Current Item', 'custom-menu-wizard'); ?></option>
            <option value="-2" <?php selected( $instance['filter_item'], -2 ); ?>><?php _e('Current Root Item', 'custom-menu-wizard'); ?></option>
            <option value="-1" <?php selected( $instance['filter_item'], -1 ); ?>><?php _e('Current Parent Item', 'custom-menu-wizard'); ?></option>
            <?php echo $menus['selectedOptgroup']; ?>
        </select>
        <br /><label>
            <input id="<?php echo $this->get_field_id('filter'); ?>_2" class="cmw-showspecific cmw-listen" <?php $this->cmw_disableif(); ?>
                name="<?php echo $this->get_field_name('filter'); ?>" type="radio" value="-1" <?php checked( $instance['filter'], -1 ); ?> />
            <?php _e('Items:', 'custom-menu-wizard'); ?></label>
        <?php $this->cmw_formfield_textbox( $instance, 'items',
            array(
                'fclass' => 'cmw-setitems'
            ) ); ?>

        <select id="<?php echo $this->get_field_id('filter_item_ignore'); ?>" disabled="disabled"
                class='cmw-off-the-page' name="<?php echo $this->get_field_name('filter_item_ignore'); ?>">
            <?php echo $menus['optgroups']; ?>
        </select>
    </p>

    <p class="cmw-disableif-ss<?php $this->cmw_disableif( 'push', $isShowSpecific ); ?>">
        <label for="<?php echo $this->get_field_id('start_level'); ?>"><?php _e('Starting Level:', 'custom-menu-wizard'); ?></label>
        <select id="<?php echo $this->get_field_id('start_level'); ?>" <?php $this->cmw_disableif(); ?>
            class="cmw-start-level" name="<?php echo $this->get_field_name('start_level'); ?>">
<?php for( $i = 1; $i <= $menus['selectedLevels']; $i++ ) : ?>
            <option value="<?php echo $i; ?>" <?php selected( $instance['start_level'] > $menus['selectedLevels'] ? 1 : $instance['start_level'], $i ); ?>><?php echo $i; ?></option>
<?php endfor; ?>
        </select>
        <span class="cmw-small-block"><em><?php _e('Level to start testing items for inclusion', 'custom-menu-wizard'); ?></em></span>
    </p><?php $this->cmw_disableif( 'pop' ); ?><!-- end .cmw-disableif-ss -->

    <p class="cmw-disableif-ss<?php $this->cmw_disableif( 'push', $isShowSpecific ); ?>">
        <label for="<?php echo $this->get_field_id('depth'); ?>"><?php _e('For Depth:', 'custom-menu-wizard'); ?></label>
        <select id="<?php echo $this->get_field_id('depth'); ?>" class="cmw-depth"
                <?php $this->cmw_disableif(); ?> name="<?php echo $this->get_field_name('depth'); ?>">
            <option value="0" <?php selected( $instance['depth'] > $menus['selectedLevels'] ? 0 : $instance['depth'], 0 ); ?>><?php _e('unlimited', 'custom-menu-wizard'); ?></option>
<?php for( $i = 1; $i <= $menus['selectedLevels']; $i++ ) : ?>
            <option value="<?php echo $i; ?>" <?php selected( $instance['depth'], $i ); ?>><?php printf( _n('%d level', '%d levels', $i, 'custom-menu-wizard'), $i ); ?></option>
<?php endfor; ?>
        </select>
        <span class="cmw-small-block"><em><?php _e('Relative to first Filter item found, <strong>unless</strong>&hellip;', 'custom-menu-wizard'); ?></em></span>
        <?php $this->cmw_formfield_checkbox( $instance, 'depth_rel_current',
            array(
                'label' => __('Relative to Current Item <small><em>(if found)</em></small>', 'custom-menu-wizard')
            ) ); ?>
    </p><?php $this->cmw_disableif( 'pop' ); ?><!-- end .cmw-disableif-ss -->

    <?php $this->cmw_close_a_field_section(); ?>

<?php
        /**
         * v1.2.0 start collapsible section : 'Fallbacks'
         */
        $this->cmw_open_a_field_section( $instance, __('Fallbacks', 'custom-menu-wizard'), 'fs_fallbacks' );
?>
    <p class="cmw-disableifnot-rp<?php $this->cmw_disableif( 'push', $isNotCurrentRootParent ); ?>"><?php $this->cmw_assist_link(); ?>
        <span class="cmw-small-block"><strong><?php _e( 'If &quot;Children of&quot; is <em>Current Root / Parent Item</em>, and no ancestor exists' , 'custom-menu-wizard'); ?> :</strong></span>
        <?php $this->cmw_formfield_checkbox( $instance, 'fallback_no_ancestor',
            array(
                'label' => __('Switch to Current Item, and', 'custom-menu-wizard')
            ) ); ?>
        <br /><?php $this->cmw_formfield_checkbox( $instance, 'fallback_include_parent',
            array(
                'label' => __('Include Parent...', 'custom-menu-wizard')
            ) ); ?>
        <?php $this->cmw_formfield_checkbox( $instance, 'fallback_include_parent_siblings',
            array(
                'label' => __('with Siblings', 'custom-menu-wizard'),
                'lclass' => 'cmw-whitespace-nowrap'
            ) ); ?>
    </p><?php $this->cmw_disableif( 'pop' ); ?><!-- end .cmw-disableifnot-rp -->

    <p class="cmw-disableifnot-ci<?php $this->cmw_disableif( 'push', $isNotCurrentItem ); ?>">
        <span class="cmw-small-block"><strong><?php _e( 'If &quot;Children of&quot; is <em>Current Item</em>, and current item has no children' , 'custom-menu-wizard'); ?> :</strong></span>
        <?php $this->cmw_formfield_checkbox( $instance, 'fallback_no_children',
            array(
                'label' => __('Switch to Current Parent Item, and', 'custom-menu-wizard')
            ) ); ?>
        <br />
        <?php $this->cmw_formfield_checkbox( $instance, 'fallback_nc_include_parent',
            array(
                'label' => __('Include Parent...', 'custom-menu-wizard')
            ) ); ?>
        <?php $this->cmw_formfield_checkbox( $instance, 'fallback_nc_include_parent_siblings',
            array(
                'label' => __('with Siblings', 'custom-menu-wizard'),
                'lclass' => 'cmw-whitespace-nowrap'
            ) ); ?>
    </p><?php $this->cmw_disableif( 'pop' ); ?><!-- end .cmw-disableifnot-ci -->

    <?php $this->cmw_close_a_field_section(); ?>

<?php
        /**
         * start collapsible section : 'Output'
         */
        $this->cmw_open_a_field_section( $instance, __('Output', 'custom-menu-wizard'), 'fs_output' );
?>
    <p><?php $this->cmw_assist_link(); ?>
        <label>
            <input id="<?php echo $this->get_field_id('flat_output'); ?>_0" name="<?php echo $this->get_field_name('flat_output'); ?>"
                type="radio" value="0" <?php checked(!$instance['flat_output']); ?> <?php $this->cmw_disableif(); ?> />
            <?php _e('Hierarchical', 'custom-menu-wizard'); ?></label>
        &nbsp;<label class="cmw-whitespace-nowrap">
            <input id="<?php echo $this->get_field_id('flat_output'); ?>_1" name="<?php echo $this->get_field_name('flat_output'); ?>"
                type="radio" value="1" <?php checked($instance['flat_output']); ?> <?php $this->cmw_disableif(); ?> />
            <?php _e('Flat', 'custom-menu-wizard'); ?></label>
    </p>

    <p>
        <?php $this->cmw_formfield_checkbox( $instance, 'contains_current',
            array(
                'label' => __('Must Contain &quot;Current&quot; Item', 'custom-menu-wizard'),
                'desc' => __('Checks both Filtered and Included items', 'custom-menu-wizard')
            ) ); ?>
    </p>

    <p class="cmw-disableif<?php $this->cmw_disableif( 'push', $isNotChildrenOf ); ?>">
        <?php $this->cmw_formfield_checkbox( $instance, 'include_parent',
            array(
                'label' => __('Include Parent...', 'custom-menu-wizard')
            ) ); ?>
        <?php $this->cmw_formfield_checkbox( $instance, 'include_parent_siblings',
            array(
                'label' => __('with Siblings', 'custom-menu-wizard'),
                'lclass' => 'cmw-whitespace-nowrap'
            ) ); ?>
        <br /><?php $this->cmw_formfield_checkbox( $instance, 'include_ancestors',
            array(
                'label' => __('Include Ancestors', 'custom-menu-wizard')
            ) ); ?>
        <br /><?php $this->cmw_formfield_checkbox( $instance, 'title_from_parent',
            array(
                'label' => __('Title from Parent', 'custom-menu-wizard'),
                'desc' => __('Only if the &quot;Children of&quot; Filter returns items', 'custom-menu-wizard')
            ) ); ?>
    </p><?php $this->cmw_disableif( 'pop' ); ?><!-- end .cmw-disableif -->

    <p>
        <?php $this->cmw_formfield_checkbox( $instance, 'title_from_current',
            array(
                'label' => __('Title from &quot;Current&quot; Item', 'custom-menu-wizard'),
                'desc' => __('Lower priority than &quot;Title from Parent&quot;', 'custom-menu-wizard')
            ) ); ?>
    </p>

    <p>
        <?php _e('Change UL to OL:', 'custom-menu-wizard'); ?>
        <br /><?php $this->cmw_formfield_checkbox( $instance, 'ol_root',
            array(
                'label' => __('Top Level', 'custom-menu-wizard')
            ) ); ?>
        &nbsp;
        <?php $this->cmw_formfield_checkbox( $instance, 'ol_sub',
            array(
                'label' => __('Sub-Levels', 'custom-menu-wizard')
            ) ); ?>
    </p>

    <?php $this->cmw_close_a_field_section(); ?>

<?php
        /**
         * start collapsible section : 'Container'
         */
        $this->cmw_open_a_field_section( $instance, __('Container', 'custom-menu-wizard'), 'fs_container' );
?>
    <p>
        <?php $this->cmw_formfield_textbox( $instance, 'container',
            array(
                'label' => __('Element:', 'custom-menu-wizard'),
                'desc' => __('Eg. div or nav; leave empty for no container', 'custom-menu-wizard')
            ) ); ?>
    </p>
    <p>
        <?php $this->cmw_formfield_textbox( $instance, 'container_id',
            array(
                'label' => __('Unique ID:', 'custom-menu-wizard'),
                'desc' => __('An optional ID for the container', 'custom-menu-wizard')
            ) ); ?>
    </p>
    <p>
        <?php $this->cmw_formfield_textbox( $instance, 'container_class',
            array(
                'label' => __('Class:', 'custom-menu-wizard'),
                'desc' => __('Extra class for the container', 'custom-menu-wizard')
            ) ); ?>
    </p>

    <?php $this->cmw_close_a_field_section(); ?>

<?php
        /**
         * start collapsible section : 'Classes'
         */
        $this->cmw_open_a_field_section( $instance, __('Classes', 'custom-menu-wizard'), 'fs_classes' );
?>
    <p>
        <?php $this->cmw_formfield_textbox( $instance, 'menu_class',
            array(
                'label' => __('Menu Class:', 'custom-menu-wizard'),
                'desc' => __('Class for the list element forming the menu', 'custom-menu-wizard')
            ) ); ?>
    </p>
    <p>
        <?php $this->cmw_formfield_textbox( $instance, 'widget_class',
            array(
                'label' => __('Widget Class:', 'custom-menu-wizard'),
                'desc' => __('Extra class for the widget itself', 'custom-menu-wizard')
            ) ); ?>
    </p>

    <?php $this->cmw_close_a_field_section(); ?>

<?php
        /**
         * start collapsible section : 'Links'
         */
        $this->cmw_open_a_field_section( $instance, __('Links', 'custom-menu-wizard'), 'fs_links' );
?>
    <p>
        <?php $this->cmw_formfield_textbox( $instance, 'before',
            array(
                'label' => __('Before the Link:', 'custom-menu-wizard'),
                'desc' => __( htmlspecialchars('Text/HTML to go before the <a> of the link') , 'custom-menu-wizard'),
                'fclass' => 'widefat'
            ) ); ?>
    </p>
    <p>
        <?php $this->cmw_formfield_textbox( $instance, 'after',
            array(
                'label' => __('After the Link:', 'custom-menu-wizard'),
                'desc' => __( htmlspecialchars('Text/HTML to go after the <a> of the link') , 'custom-menu-wizard'),
                'fclass' => 'widefat'
            ) ); ?>
    </p>
    <p>
        <?php $this->cmw_formfield_textbox( $instance, 'link_before',
            array(
                'label' => __('Before the Link Text:', 'custom-menu-wizard'),
                'desc' => __('Text/HTML to go before the link text', 'custom-menu-wizard'),
                'fclass' => 'widefat'
            ) ); ?>
    </p>
    <p>
        <?php $this->cmw_formfield_textbox( $instance, 'link_after',
            array(
                'label' => __('After the Link Text:', 'custom-menu-wizard'),
                'desc' => __('Text/HTML to go after the link text', 'custom-menu-wizard'),
                'fclass' => 'widefat'
            ) ); ?>
    </p>

    <?php $this->cmw_close_a_field_section(); ?>

</div>
<?php

    }   //end cmw_legacy_form()

    /**
     * sanitizes the widget settings for cmw_legacy_update(), cmw_legacy_widget() and cmw_legacy_form()
     *
     * @param array $from_instance Widget settings
     * @param array $base_instance Old widget settings or an empty array
     * @param string $method Name suffix of the calling method
     * @return array Sanitized widget settings
     */
    public function cmw_legacy_settings( $from_instance, $base_instance, $method = 'update' ){

        $instance = is_array( $base_instance ) ? $base_instance : array();

        //switches...
        foreach( array(
                'hide_title' => 0,
                'contains_current' => 0, //v2.0.0 added
                'depth_rel_current' => 0, //v2.0.0 added
                'fallback_no_ancestor' => 0, //v1.1.0 added
                'fallback_include_parent' => 0, //v1.1.0 added
                'fallback_include_parent_siblings' => 0, //v1.1.0 added
                'fallback_no_children' => 0, //v1.2.0 added
                'fallback_nc_include_parent' => 0, //v1.2.0 added
                'fallback_nc_include_parent_siblings' => 0, //v1.2.0 added
                'flat_output' => 0,
                'include_parent' => 0,
                'include_parent_siblings' => 0, //v1.1.0 added
                'include_ancestors' => 0,
                'title_from_parent' => 0,
                'title_from_current' => 0, //v1.2.0 added
                'ol_root' => 0,
                'ol_sub' => 0,
                //field section toggles...
                'fs_filter' => 0,
                'fs_fallbacks' => 1, //v1.2.0 added
                'fs_output' => 1,
                'fs_container' => 1,
                'fs_classes' => 1,
                'fs_links' => 1
                ) as $k => $v ){

            if( $method == 'form' ){
                $instance[ $k ] = isset( $from_instance[ $k ] ) ? !empty( $from_instance[ $k ] ) : !empty( $v );
            }elseif( $method == 'widget' ){
                $instance[ $k ] = !empty( $from_instance[ $k ] );
            }else{
                $instance[ $k ] = empty( $from_instance[ $k ] ) ? 0 : 1;
            }

        }

        //strings...
        foreach( array(
                'title' => '',
                'items' => '', //v2.0.0 added
                'container' => 'div',
                'container_id' => '',
                'container_class' => '',
                'menu_class' => 'menu-widget',
                'widget_class' => ''
                ) as $k => $v ){

            if( $method == 'form' ){
                $instance[ $k ] = isset( $from_instance[ $k ] ) ? esc_attr( trim( $from_instance[ $k ] ) ) : $v;
            }elseif( $method == 'widget' ){
                $instance[ $k ] = isset( $from_instance[ $k ] ) ? trim( $from_instance[ $k ] ) : $v; //bug in 2.0.2 fixed!
            }else{
                $instance[ $k ] = isset( $from_instance[ $k ] ) ? strip_tags( trim( $from_instance[ $k ] ) ) : $v;
            }

        }

        //html strings...
        foreach( array(
                'before' => '',
                'after' => '',
                'link_before' => '',
                'link_after' => ''
                ) as $k => $v ){

            if( $method == 'form' ){
                $instance[ $k ] = isset( $from_instance[ $k ] ) ? esc_html( trim( $from_instance[ $k ] ) ) : $v;
            }elseif( $method == 'widget' ){
                $instance[ $k ] = empty( $from_instance[ $k ] ) ? $v : trim( $from_instance[ $k ] );
            }else{
                $instance[ $k ] = isset( $from_instance[ $k ] ) ? trim( $from_instance[ $k ] ) : $v;
            }

        }

        //integers...
        foreach( array(
                'depth' => 0,
                'filter' => -1, //v2.0.0 changed from switch
                'filter_item' => -2, //v1.1.0 changed from 0
                'menu' => 0,
                'start_level' => 1
                ) as $k => $v ){

            if( $method == 'form' ){
                $instance[ $k ] = isset( $from_instance[ $k ]) ? max( $v, intval( $from_instance[ $k ] ) ) : max($v, 0);
            }elseif( $method == 'widget' ){
                $instance[ $k ] = max( $v, intval( $from_instance[ $k ] ) );
            }else{
                $instance[ $k ] = isset( $from_instance[ $k ]) ? max( $v, intval( $from_instance[ $k ] ) ) : $v;
            }

        }

        //items special case...
        if( $method == 'update' && !empty( $instance['items'] ) ){
            $sep = preg_match( '/(^\d+$|,)/', $instance['items'] ) > 0 ? ',' : ' ';
            $a = array();
            foreach( preg_split('/[,\s]+/', $instance['items'], -1, PREG_SPLIT_NO_EMPTY ) as $v ){
                $i = intval( $v );
                if( $i > 0 ){
                    $a[] = $i;
                }
            }
            $instance['items'] = implode( $sep, $a );
        }

        //v1.2.1 holds information determined by the walker...
        $this->_cmw_walker = array();

        return $instance;

    }   //end cmw_legacy_settings()

    /**
     * updates the widget settings sent from the legacy backend admin
     *
     * @filters : custom_menu_wizard_prevent_legacy_updates        false
     * @filters : custom_menu_wizard_wipe_on_update                false
     *
     * @param array $new_instance New widget settings
     * @param array $old_instance Old widget settings
     * @return array Sanitized widget settings
     */
    public function cmw_legacy_update( $new_instance, $old_instance ){

        //allow a filter to return true, whereby updates to legacy widgets are disallowed...
        //eg. apply_filter( 'custom_menu_wizard_prevent_legacy_updates', [filter function], 10, 1 ) => true
        if( !apply_filters( 'custom_menu_wizard_prevent_legacy_updates', false ) ){
            return $this->cmw_legacy_settings(
                $new_instance,
                //allow a filter to return true, whereby any previous settings (now possibly unused) will be wiped instead of being allowed to remain...
                //eg. add_filter( 'custom_menu_wizard_wipe_on_update', [filter_function], 10, 1 ) => true
                apply_filters( 'custom_menu_wizard_wipe_on_update', false ) ? array() : $old_instance,
                'update' );
        }else{
            //prevent the save!...
            return false;
        }

    } //end cmw_legacy_update()

    /**
     * produces the legacy widget HTML at the front end
     *
     * @filters : custom_menu_wizard_nav_params           array of params that will be sent to wp_nav_menu(), array of instance settings, id base
     *            custom_menu_wizard_settings_pre_widget  array of instance settings, id base
     *            custom_menu_wizard_widget_output        HTML output string, array of instance settings, id base, $args
     *
     * @param object $args Widget arguments
     * @param array $instance Configuration for this widget instance
     */
    public function cmw_legacy_widget( $args, $instance ) {

        //sanitize $instance...
        $instance = $this->cmw_legacy_settings( $instance, array(), 'widget' );

        //allow a filter to amend the instance settings prior to producing the widget output...
        //eg. add_filter( 'custom_menu_wizard_settings_pre_widget', [filter_function], 10, 2 ) => $instance (array)
        $instance = apply_filters( 'custom_menu_wizard_settings_pre_widget', $instance, $this->id_base );

        //fetch menu...
        if( !empty($instance['menu'] ) ){
            $menu = wp_get_nav_menu_object( $instance['menu'] );

            //no menu, no output...
            if ( !empty( $menu ) ){

                if( !empty( $instance['widget_class'] ) ){
                    //$args['before_widget'] is usually just a DIV start-tag, with an id and a class; if it
                    //gets more complicated than that then this may not work as expected...
                    if( preg_match( '/^<[^>]+?class=["\']/', $args['before_widget'] ) > 0 ){
                        $args['before_widget'] = preg_replace( '/(class=["\'])/', '$1' . $instance['widget_class'] . ' ', $args['before_widget'], 1 );
                    }else{
                        $args['before_widget'] = preg_replace( '/^(<\w+)(\s|>)/', '$1 class="' . $instance['widget_class'] . '"$2', $args['before_widget'] );
                    }
                }

                if( !empty( $instance['container_class'] ) ){
                    $instance['container_class'] = "menu-{$menu->slug}-container {$instance['container_class']}";
                }

                $instance['menu_class'] = preg_split( '/\s+/', $instance['menu_class'], -1, PREG_SPLIT_NO_EMPTY );
                if( $instance['fallback_no_ancestor'] || $instance['fallback_no_children'] ){
                    //v1.2.1 add a cmw-fellback-maybe class to the menu and we'll remove or replace it later...
                    $instance['menu_class'][] = 'cmw-fellback-maybe';
                }
                $instance['menu_class'] = implode( ' ', $instance['menu_class'] );

                $walker = new Custom_Menu_Wizard_Walker;
                $params = array(
                    'menu' => $menu,
                    'container' => empty( $instance['container'] ) ? false : $instance['container'], //bug in 2.0.2 fixed!
                    'container_id' => $instance['container_id'],
                    'menu_class' => $instance['menu_class'],
                    'echo' => false,
                    'fallback_cb' => false,
                    'before' => $instance['before'],
                    'after' => $instance['after'],
                    'link_before' => $instance['link_before'],
                    'link_after' => $instance['link_after'],
                    'depth' => empty( $instance['flat_output'] ) ? $instance['depth'] : -1,
                    'walker' =>$walker,
                    //widget specific stuff...
                    '_custom_menu_wizard' => $instance
                    );
                //for the walker's use...
                $params['_custom_menu_wizard']['_walker'] = array();

                if( $instance['ol_root'] ){
                    $params['items_wrap'] = '<ol id="%1$s" class="%2$s">%3$s</ol>';
                }
                if( !empty( $instance['container_class'] ) ){
                    $params['container_class'] = $instance['container_class'];
                }

                add_filter('custom_menu_wizard_walker_items', array( $this, 'cmw_filter_walker_items' ), 10, 2);

                //allow a filter to amend the wp_nav_menu() params prior to calling it...
                //eg. add_filter( 'custom_menu_wizard_nav_params', [filter_function], 10, 3 ) => $params (array)
                //NB: wp_nav_menu() is in wp-includes/nav-menu-template.php
                $out = wp_nav_menu( apply_filters( 'custom_menu_wizard_nav_params', $params, $instance, $this->id_base ) );

                remove_filter('custom_menu_wizard_walker_items', array( $this, 'cmw_filter_walker_items' ), 10, 2);

                //only put something out if there is something to put out...
                if( !empty( $out ) ){

                    //title from : 'from parent' has priority over 'from current'...
                    //note that 'parent' is whatever you are getting the children of and therefore doesn't apply to a ShowAll, whereas
                    //'current' is the current menu item (as determined by WP); also note that neither parent nor current actually has
                    //to be present in the results
                    if( $instance['title_from_parent'] && !empty( $this->_cmw_walker['parent_title'] ) ){
                        $title = $this->_cmw_walker['parent_title'];
                    }
                    if( empty( $title ) && $instance['title_from_current'] && !empty( $this->_cmw_walker['current_title'] ) ){
                        $title = $this->_cmw_walker['current_title'];
                    }
                    if( empty( $title ) ){
                        $title = $instance['hide_title'] ? '' : $instance['title'];
                    }

                    //remove/replace the cmw-fellback-maybe class...
                    $out = str_replace(
                        'cmw-fellback-maybe',
                        empty( $this->_cmw_walker['fellback'] ) ? '' : 'cmw-fellback-' . $this->_cmw_walker['fellback'],
                        $out );

                    if ( !empty($title) ){
                        $out = $args['before_title'] . apply_filters('widget_title', $title, $instance, $this->id_base) . $args['after_title'] . $out;
                    }
                    $out = $args['before_widget'] . $out . $args['after_widget'];
                    //allow a filter to modify the entire output...
                    //eg. add_filter( 'custom_menu_wizard_widget_output', [filter_function], 10, 4 ) => $output (HTML string)
                    echo apply_filters( 'custom_menu_wizard_widget_output', $out, $instance, $this->id_base, $args );
                }
            }
        }

    } //end cmw_legacy_widget()

} //end of class
?>