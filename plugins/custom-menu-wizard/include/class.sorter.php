<?php
/*
 * Custom Menu Wizard plugin
 *
 * Custom Menu Wizard Sorter class
 * NB: Walker_Nav_Menu class is in wp-includes/nav-menu-template.php, and is itself an
 *     extension of the Walker class (wp-includes/class-wp-walker.php).
 *
 *     This is for ensuring that nav items are in a proper hierarchical structure, ie. children
 *     immediately follow their parent (plugins like Gecka Submenu tack nav items onto the
 *     end of the items list, regardless of where the parent item lies in the list), the theory
 *     being that however WordPress sorts out the hierarchy should be good enough for me!
 */
class Custom_Menu_Wizard_Sorter extends Walker_Nav_Menu {

    /**
     * Traverse elements to create list from elements.
     * This cut down version merely grabs the original element into a new array
     *
     * @param object $element           Data object.
     * @param array  $children_elements List of elements to continue traversing.
     * @param int    $max_depth         Max depth to traverse.
     * @param int    $depth             Depth of current element.
     * @param array  $args              An array of arguments.
     * @param string $output            Passed by reference. Used to append additional content.
     */
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

        if ( ! $element ) {
            return;
        }

        $id_field = $this->db_fields['id'];
        $id       = $element->$id_field;

        if( !is_array( $output ) ){
            $output = array();
        }
        $output[] = $element;

        // descend only when the depth is right and there are childrens for this element
        if ( ( $max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[ $id ] ) ) {

            foreach ( $children_elements[ $id ] as $child ){

                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
            }
            unset( $children_elements[ $id ] );
        }

    } //end display()

    /**
     * Sort array of elements hierarchically.
     *
     * @param array $elements  An array of elements.
     * @param int   $max_depth The maximum hierarchical depth (default, unlimited).
     * @return array The elements in proper hierarchical order.
     */
    public function walk( $elements, $max_depth = 0 ) {

        //NB : any orphan elements (and that includes children of orphans) get appended to the
        //     output array in the order that they are placed in the original array (ie. regardless
        //     of menu_order) BUT *only* if $max_depth is zero! If $max_depth is anything other than
        //     zero then all orphans (and their children) are ignored (ie. discarded).
        $output = parent::walk( $elements, $max_depth );

        //always return an array...
        return is_array( $output ) ? $output : array();

    } //end walk()

} //end Custom_Menu_Wizard_Sorter class
