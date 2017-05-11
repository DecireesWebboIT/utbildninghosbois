<?php
	function Rich_Web_Tabs_ID($atts, $content = null)
	{
		$atts = shortcode_atts(
			array(
				"id" => "1"
			),$atts
		);
		return Rich_Web_Draw_Short_Tabs($atts['id']);
	}
	add_shortcode('Rich_Web_Tabs', 'Rich_Web_Tabs_ID');
	function Rich_Web_Draw_Short_Tabs($Tabs_ID)
	{
		ob_start();	
			$args = shortcode_atts(array('name' => 'Widget Area','id' => '','description' => '','class' => '','before_widget' => '','after_widget' => '','before_title' => '','AFTER_TITLE' => '','widget_id' => '','widget_name' => 'Rich-Web Tabs'), $Tabs_ID, 'Rich_Web_Tabs' );
			$Rich_Web_Tabs = new Rich_Web_Tabs;

			$instance = array('Rich_Web_Tabs' => $Tabs_ID);
			$Rich_Web_Tabs->widget($args,$instance);	
			$cont[] = ob_get_contents();
		ob_end_clean();	
		return $cont[0];		
	}
?>