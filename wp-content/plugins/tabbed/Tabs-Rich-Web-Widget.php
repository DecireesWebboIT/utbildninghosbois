<?php
	class Rich_Web_Tabs extends WP_Widget
	{
		function __construct()
 	  	{
 			$params=array('name'=>'Rich-Web Tabs','description'=>'This is the widget of Rich-Web Tabs plugin');
			parent::__construct('Rich_Web_Tabs','',$params);
 	  	}
		function Tab($instance)
 		{
 			$defaults = array('Rich_Web_Tabs'=>'');
		    $instance = wp_parse_args((array)$instance, $defaults);

		   	$Rich_Web_Tabs = $instance['Rich_Web_Tabs'];
		   	?>
		   	<div>			  
			   	<p>
			   		Slider Title:
			   		<select name="<?php echo $this->get_field_name('Rich_Web_Tabs'); ?>" class="widefat">
				   		<?php
				   			global $wpdb;
							$table_name2  = $wpdb->prefix . "rich_web_Tabs_manager";
							$Rich_Web_Tabs=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name2 WHERE id > %d", 0));
				   			
				   			foreach ($Rich_Web_Tabs as $Rich_Web_Tabs1)
				   			{
				   				?> <option value="<?php echo $Rich_Web_Tabs1->id; ?>"> <?php echo $Rich_Web_Tabs1->Tabs_name; ?> </option> <?php 
				   			}
				   		?>
			   		</select>
			   	</p>
		   	</div>
		   	<?php	
 		}
 		function widget($args,$instance)
 		{
 			extract($args);
 		 	$Rich_Web_Tabs = empty($instance['Rich_Web_Tabs']) ? '' : $instance['Rich_Web_Tabs'];
 		 	global $wpdb;

 		 	$table_name   = $wpdb->prefix . "rich_web_font_family";
			$table_name1  = $wpdb->prefix . "rich_web_icons";
			$table_name2  = $wpdb->prefix . "rich_web_tabs_id";
			$table_name3  = $wpdb->prefix . "rich_web_tabs_manager";
			$table_name4  = $wpdb->prefix . "rich_web_tabs_fields";
			$table_name5  = $wpdb->prefix . "rich_web_tabs_effects_data";
			$table_name6  = $wpdb->prefix . "rich_web_tabs_effect_1";

			$Rich_Web_Tabs_Manager = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE id=%d", $Rich_Web_Tabs));
			$Rich_Web_Tabs_Fields  = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE Tabs_ID=%d", $Rich_Web_Tabs));
			$Rich_Web_Tabs_Themes  = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name5 WHERE Rich_Web_Tabs_T_T = %s", $Rich_Web_Tabs_Manager[0]->Tabs_theme));

		 	if($Rich_Web_Tabs_Themes[0]->Rich_Web_Tabs_T_Ty=='Rich_Tabs_1')
		 	{
				$Rich_Web_Tabs_Theme = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name6 WHERE Tabs_T_ID = %s", $Rich_Web_Tabs_Themes[0]->id));
		 	}
 		 	echo $before_widget; 
			?>
				<style type="text/css">
					.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?>
					{
						<?php if($Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_Al == 'center'){ ?>
  							margin: 0 auto !important;
						<?php }else if($Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_Al == 'right'){?>
  							margin-left: <?php echo 100-$Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_W;?>% !important;
						<?php }else{ ?>
							margin: 0 !important;
						<?php }?>
					}
					.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> ul.Rich_Web_Tabs_tt_tabs
					{
						background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_MBgC;?>;
						<?php if($Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_NavM == 'vertical'){ ?>
							vertical-align: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_NavAl;?>;
						<?php }else { ?>
							text-align: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_NavAl;?>;
						<?php }?>
					}
					.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> ul.Rich_Web_Tabs_tt_tabs li
					{
						<?php if($Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_NavM == 'vertical' || $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_NavM == 'accordion' ){ ?>
							margin-bottom: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_PB;?>px;
						<?php }else { ?>
							margin-right: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_PB-5;?>px;
						<?php }?>
						background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_BgC;?>;
						color: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_C;?>;
						-webkit-box-shadow: 
						    inset 0 0 6px  <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_IBSh;?>,
						          0 0 10px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_OBSh;?>; 
						-moz-box-shadow: 
						    inset 0 0 6px  <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_IBSh;?>,
						          0 0 10px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_OBSh;?>; 
						box-shadow: 
						    inset 0 0 6px  <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_IBSh;?>,
						          0 0 10px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_OBSh;?>;

						position: relative;
						/*display: block;*/
						overflow: hidden;
					}
					.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> ul.Rich_Web_Tabs_tt_tabs li:hover
					{
						background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_HBgC;?>;
						color: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_HC;?>;
					}
					.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> ul.Rich_Web_Tabs_tt_tabs li.active
					{
						background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CBgC;?>;
						color: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?>;
					}
					.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> ul.Rich_Web_Tabs_tt_tabs li:nth-last-child(1)
					{
						<?php if($Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_NavM == 'vertical' || $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_NavM == 'accordion' ){ ?>
							margin-bottom: 0px !important;
						<?php }?>
					}
					.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> ul.Rich_Web_Tabs_tt_tabs li i
					{
						font-size: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_IS;?>px;
					}
					.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> ul.Rich_Web_Tabs_tt_tabs li span
					{
						font-size: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_FS;?>px;
						font-family: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_FF;?>;
					}
					.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> div.Rich_Web_Tabs_tt_tab
					{
						<?php if($Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_NavM == 'accordion' ){ ?>
							-webkit-box-shadow: 
							    inset 0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_IBSC;?>,
							          0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_OBSC;?>; 
							-moz-box-shadow: 
							    inset 0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_IBSC;?>,
							          0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_OBSC;?>; 
							box-shadow: 
							    inset 0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_IBSC;?>,
							          0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_OBSC;?>;
							border-radius: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BR;?>px;    
							-webkit-border-radius: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BR;?>px;
							-moz-border-radius: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BR;?>px;  
							border: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BW;?>px solid <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BC;?>; 
							<?php if($Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgT=='color'){ ?>
								background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>;
							<?php }else if($Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgT=='transparent'){ ?>
								background: transparent;
							<?php }else{ ?>
								background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>;
							    background: -webkit-linear-gradient(<?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC2;?>);
							    background: -o-linear-gradient(<?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC2;?>);
							    background: -moz-linear-gradient(<?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC2;?>);
							    background: linear-gradient(<?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC2;?>);
							<?php }?> 
						<?php }?> 
						width: 100%;
					}
					.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> div.Rich_Web_Tabs_tt_container
					{
						<?php if($Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_NavM == 'horizontal' ){ ?>
							-webkit-box-shadow: 
							    inset 0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_IBSC;?>,
							          0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_OBSC;?>; 
							-moz-box-shadow: 
							    inset 0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_IBSC;?>,
							          0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_OBSC;?>; 
							box-shadow: 
							    inset 0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_IBSC;?>,
							          0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_OBSC;?>;
							border-radius: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BR;?>px;    
							-webkit-border-radius: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BR;?>px;
							-moz-border-radius: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BR;?>px;  
							border: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BW;?>px solid <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BC;?>; 
							<?php if($Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgT=='color'){ ?>
								background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>;
							<?php }else if($Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgT=='transparent'){ ?>
								background: transparent;
							<?php }else{ ?>
								background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>;
							    background: -webkit-linear-gradient( <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC2;?>);
							    background: -o-linear-gradient( <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC2;?>);
							    background: -moz-linear-gradient( <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC2;?>);
							    background: linear-gradient( <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC2;?>);
							<?php }?> 
						<?php }?>
						<?php if($Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_NavM == 'vertical'){ ?>
							-webkit-box-shadow: 
							    inset 0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_IBSC;?>,
							          0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_OBSC;?>; 
							-moz-box-shadow: 
							    inset 0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_IBSC;?>,
							          0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_OBSC;?>; 
							box-shadow: 
							    inset 0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_IBSC;?>,
							          0 0 20px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_OBSC;?>;
							border-radius: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BR;?>px;    
							-webkit-border-radius: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BR;?>px;
							-moz-border-radius: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BR;?>px;  
							border: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BW;?>px solid <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BC;?>; 
							<?php if($Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgT=='color'){ ?>
								background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>;
							<?php }else if($Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgT=='transparent'){ ?>
								background: transparent;
							<?php }else{ ?>
								background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>;
							    background: -webkit-linear-gradient(left, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC2;?>);
							    background: -o-linear-gradient(right, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC2;?>);
							    background: -moz-linear-gradient(right, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC2;?>);
							    background: linear-gradient(to right, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC;?>, <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_C_BgC2;?>);
							<?php }?> 
						<?php }?>


					}
					<?php if( $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_NavM == 'horizontal' ){ ?>
						/*****************************/
						/* Bar */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_1 {
							border: 4px solid <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_MBC;?>;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_1 li {
							padding: 18px 20px;
							overflow: visible !important;
						}
						/*****************************/
						/* Icon Box */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_2 {
							border: 2px solid <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_MBC;?>;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_2 li  {
							overflow: visible !important;
							position: relative;
							padding: 1em;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_2 li.active {
							z-index: 100;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_2 li.active::after {
							position: absolute;
							top: 100%;
							left: 50%;
							margin-left: -10px;
							width: 0;
							height: 0;
							border: solid transparent;
							border-width: 10px;
							border-top-color: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CBgC;?>;
							content: '';
							pointer-events: none;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_2 li i::before {
							position: relative;
						    display: block;
						    left: 0%;
						    text-align: center;
						}	
						/*****************************/
						/* Underline */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_3 li {
							padding: 18px 20px;
							-webkit-transition: color 0.2s;
							transition: color 0.2s;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_3 li::after {
							position: absolute;
							bottom: 0;
							left: 0;
							width: 100%;
							height: 6px;
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?>;
							content: '';
							-webkit-transition: -webkit-transform 0.3s;
							transition: transform 0.3s;
							-webkit-transform: translate3d(0,150%,0);
							transform: translate3d(0,150%,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_3 li.active::after {
							-webkit-transform: translate3d(0,0,0);
							transform: translate3d(0,0,0);
						}
						/*****************************/
						/* Triangle and Line */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_4
						{
							margin-bottom: 3px !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_4 li {
							padding: 18px 20px;
							overflow: visible !important;
							border-bottom: 1px solid <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?>;
							-webkit-transition: color 0.2s;
							transition: color 0.2s;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_4 li::after {
							position: absolute;
							top: 100%;
							left: 50%;
							width: 0;
							height: 0;
							border: solid transparent;
							content: '';
							pointer-events: none;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_4 li::before {
							position: absolute;
							top: 100%;
							left: 50%;
							width: 0;
							height: 0;
							display: block !important;
							border: solid transparent;
							content: '' !important;
							pointer-events: none;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_4 li.active::after {
							margin-left: -10px;
							border-width: 10px;
							border-top-color: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CBgC;?>;
							z-index: 100;
						}						
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_4 li.active::before {
							margin-left: -11px;
							border-width: 11px;
							border-top-color: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?>;
							z-index: 100;
						}
						/*****************************/
						/* Top Line */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_5 li {
							padding:1em;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_5 li.active {
							background: none;
							box-shadow: inset 0 3px 0 <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?> !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_5 li i::before {
							display: block;
							position: relative;
							left: 0%;
							text-align: center;
						}
						/*****************************/
						/* Falling Icon */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_6 li {
							display: inline-block;
							overflow: visible;
							padding: 1em 2em;
							-webkit-transition: color 0.3s cubic-bezier(0.7,0,0.3,1); 
							transition: color 0.3s cubic-bezier(0.7,0,0.3,1);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_6 li::before {
							position: absolute;
							display: block !important;
							bottom: 0;
							width: 100%;
							left: 0;
							height: 4px;
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?>;
							content: '';
							opacity: 0;
							-webkit-transition: -webkit-transform 0.2s ease-in;
							transition: transform 0.2s ease-in;
							-webkit-transform: scale3d(0,1,1);
							transform: scale3d(0,1,1);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_6 li.active::before {
							opacity: 1;
							-webkit-transform: scale3d(1,1,1);
							transform: scale3d(1,1,1);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_6 li i::before {
							display: block;
							position: relative;
							left: 0%;
							text-align: center;
							opacity: 0;
							-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
							transition: transform 0.2s, opacity 0.2s;
							-webkit-transform: translate3d(0,-100px,0);
							transform: translate3d(0,-100px,0);
							pointer-events: none;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_6 li.active i::before {
							opacity: 1;
							-webkit-transform: translate3d(0,0,0);
							transform: translate3d(0,0,0);
						}
						@media screen and (max-width: 58em) {
							.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_6 li i::before {
								opacity: 1;
								-webkit-transform: translate3d(0,0,0);
								transform: translate3d(0,0,0);
							}
						}
						/*****************************/
						/* Moving Line */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_7 li::before {
							position: absolute;
							display: block !important;
							bottom: 0;
							left: 0;
							width: 100% !important;
							height: 4px;
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?>;
							content: '';
							-webkit-transition: -webkit-transform 0.3s !important;
							transition: transform 0.3s !important;
							-webkit-transform: translate3d(101%,0,0);
								transform: translate3d(101%,0,0);
						}
	                	.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_7 li.active::before {
							-webkit-transform: translate3d(0%,0,0);
							transform: translate3d(0%,0,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_7 li.active{
							-webkit-transform: translate3d(0,4px,0);
							transform: translate3d(0,4px,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_7 li {
							padding: 1em 0.5em;
							margin: 0 0 5px -2px !important;
						}	
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_7 li:nth-child(1) {
							margin: 0 0 5px 0px !important;
						}					
						/*****************************/
						/* Line */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_8 li {
							padding: 0.7em 0.4em;
							box-shadow: inset 0 -2px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_C;?> !important;
							-webkit-box-shadow: inset 0 -2px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_C;?> !important;
							text-align: left;
							letter-spacing: 1px;
							-webkit-transition: color 0.3s, box-shadow 0.3s !important;
							transition: color 0.3s, box-shadow 0.3s !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_8 li:hover, .Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_8 li:focus {
							box-shadow: inset 0 -2px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_HC;?> !important;
							-webkit-box-shadow: inset 0 -2px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_HC;?> !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_8 li.active {
							box-shadow: inset 0 -2px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?> !important;
							-webkit-box-shadow: inset 0 -2px <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?> !important;
						}				
						/*****************************/
						/* Circle */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li::before {
							position: absolute;
							display: block !important;
							top: 0%;
							left: 0%;
							width: 100%;
							height: 100%;
							border: 1px solid <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?>;
							border-radius: 50%;
							content: '';
							opacity: 0;
							-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
							transition: transform 0.2s, opacity 0.2s;
							-webkit-transition-timing-function: cubic-bezier(0.7,0,0.3,1);
							transition-timing-function: cubic-bezier(0.7,0,0.3,1);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li.active::before {
							opacity: 1;
							-webkit-transform: scale3d(0.9,0.9,0.9);
							transform: scale3d(0.9,0.9,0.9);
						}

						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li {
							overflow: visible;
							-webkit-transition: color 0.3s cubic-bezier(0.7,0,0.3,1); 
							transition: color 0.3s cubic-bezier(0.7,0,0.3,1);
							padding: 1.5em; 
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li i::before {
							display: block;
							position: relative;
							left: 0%;
							text-align: center;
							-webkit-transition: -webkit-transform 0.3s cubic-bezier(0.7,0,0.3,1);
							transition: transform 0.3s cubic-bezier(0.7,0,0.3,1);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li i span {
							-webkit-transition: -webkit-transform 0.3s cubic-bezier(0.7,0,0.3,1);
							transition: transform 0.3s cubic-bezier(0.7,0,0.3,1);
							display: block;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li.active i span {
							-webkit-transform: translate3d(0,2px,0);
							transform: translate3d(0,2px,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li i::before {
							display: block;
							margin: 0;
							pointer-events: none;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li.active i::before {
							-webkit-transform: translate3d(0,-2px,0);
							transform: translate3d(0,-2px,0);
						}
						/*****************************/
						/* Line Box */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_11 li {
							-webkit-flex: none;
							flex: none;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_11 li {
							padding: 1em;
							z-index: 10;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_11 li i::after {
							position: absolute;
							top: 0;
							left: 0;
							z-index: -1;
							width: 100%;
							height: 100%;
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_C;?>;
							content: '';
							-webkit-transition: background 0.8s, -webkit-transform 0.8s !important;
							transition: background 0.8s, transform 0.8s !important;
							-webkit-transition-timing-function: ease, cubic-bezier(0.7,0,0.3,1);
							transition-timing-function: ease, cubic-bezier(0.7,0,0.3,1);
							-webkit-transform: translate3d(0,100%,0) translate3d(0,-2px,0);
							transform: translate3d(0,100%,0) translate3d(0,-2px,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_11 li:hover i::after {
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_HC;?>;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_11 li.active i::after {
							-webkit-transform: translate3d(0,0,0);
							transform: translate3d(0,0,0);
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CBgC;?>;
						}
						/*****************************/
						/* Flip */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_12 li {
							padding: 1em;							
							z-index: 10;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_12 li::after {
							position: absolute;
							top: 0;
							left: 0;
							z-index: -1;
							width: 100%;
							height: 100%;
							background-color: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_BgC;?>;
							content: '';
							-webkit-transition: -webkit-transform 0.7s, background-color 0.3s !important;
							transition: transform 0.7s, background-color 0.3s !important;
							-webkit-transform: perspective(900px) rotate3d(1,0,0,90deg);
							transform: perspective(900px) rotate3d(1,0,0,90deg);
							-webkit-transform-origin: 50% 100%;
							transform-origin: 50% 100%;
							-webkit-perspective-origin: 50% 100%;
							perspective-origin: 50% 100%;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_12 li.active{
							background-color: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_BgC;?> !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_12 li.active::after {
							background-color: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CBgC;?>;
							-webkit-transform: perspective(900px) rotate3d(1,0,0,0deg);
							transform: perspective(900px) rotate3d(1,0,0,0deg);
						}
						/*****************************/
						/* Circle Fill */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_13 li {
							overflow: hidden;
							background: none !important;
							z-index: 10;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_13 li i {
							padding: 1.5em;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_13 li::after {
							position: absolute;
							top: 0%;
							z-index: -1;
							left: 0%;
							width: 99%;
							height: 99%;
							border-radius: 50%;
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_BgC;?>;
							content: '';
							-webkit-transition: -webkit-transform 0.8s !important;
							transition: transform 0.8s !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_13 li:hover::after {
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_HBgC;?>;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_13 li.active::after {
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CBgC;?>;
							-webkit-transform: scale3d(2.5,2.5,1);
							transform: scale3d(2.5,2.5,1);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_13 li span {
							display: none;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_13 li i::before {
							display: block;
							margin: 0;
							pointer-events: none;
						}	
						/*****************************/
						/* Fill Up */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li, .Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li:hover {
							z-index: 10;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li i {
							padding: 1em 1em;
							-webkit-backface-visibility: hidden;
							backface-visibility: hidden;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li i.active {
							z-index: 100;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li i::after {
							position: absolute;
							top: 0;
							left: 0;
							z-index: -1;
							width: 100%;
							height: 100%;
							height: calc(100% + 1px);
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CBgC;?>;
							content: '';
							-webkit-transition: -webkit-transform 0.8s !important;
							transition: transform 0.8s !important;
							-webkit-transform: translate3d(0,100%,0);
							transform: translate3d(0,100%,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li.active i::after {
							-webkit-transform: translate3d(0,0,0);
							transform: translate3d(0,0,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li i span, .Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li i::before {
							-webkit-transition: -webkit-transform 0.5s;
							transition: transform 0.5s;
							-webkit-transform: translate3d(0,5px,0);
							transform: translate3d(0,5px,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li i span {
							display: block;							
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li i::before {
							display: block;
							margin: 0;
							position: relative;
							left: 0%;
							text-align: center;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li.active span {
							-webkit-transform: translate3d(0,-5px,0);
							transform: translate3d(0,-5px,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li.active i::before {
							-webkit-transform: translate3d(0,-10px,0);
							transform: translate3d(0,-10px,0);
						}
						/*****************************/
						/* Trapezoid */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li, .Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li:hover, .Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li.active {
							background: none !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li {
							-webkit-backface-visibility: hidden;
							backface-visibility: hidden;
							z-index: 10;
							margin-right: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_PB-9;?>px !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li i {
							padding: 0.5em 1em;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li i::after {
							position: absolute;
							top: 0;
							right: 0;
							bottom: 0;
							left: 0;
							z-index: -1;
							outline: 1px solid transparent;
							border-radius: 10px 10px 0 0;
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_BgC;?>;
							box-shadow: inset 0 -3px 3px rgba(0,0,0,0.05);
							content: '';
							-webkit-transform: perspective(5px) rotateX(0.93deg) translateZ(-1px);
							transform: perspective(5px) rotateX(0.93deg) translateZ(-1px);
							-webkit-transform-origin: 0 0;
							transform-origin: 0 0;
							-webkit-backface-visibility: hidden;
							backface-visibility: hidden;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li:hover i::after{
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_HBgC;?>;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li.active i::after{
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CBgC;?>;
							box-shadow: none;
						}
					<?php } else if( $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_NavM == 'vertical' ){ ?>
						/*****************************/
						/* Bar */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_1 {
							border: 4px solid <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_MBC;?>;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_1 li {
							padding: 18px 20px;
							overflow: visible !important;
						}
						/*****************************/
						/* Icon Box */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_2 {
							border: 2px solid <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_MBC;?>;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_2 li  {
							overflow: visible !important;
							position: relative;
							padding: 1em;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_2 li.active {
							z-index: 100;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_2 li.active::after {
							position: absolute;
							top: 50%;
							left: 100%;
							margin-top: -10px;
							width: 0;
							height: 0;
							border: solid transparent;
							border-width: 10px;
							border-left-color: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CBgC;?>;
							content: '';
							pointer-events: none;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_2 li i::before {
							position: relative;
						    display: block;
						    left: 0%;
						}	
						/*****************************/
						/* Underline */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_3 li {
							padding: 18px 20px;
							-webkit-transition: color 0.2s;
							transition: color 0.2s;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_3 li::after {
							position: absolute;
							bottom: 0;
							left: 0;
							width: 100%;
							height: 6px;
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?>;
							content: '';
							-webkit-transition: -webkit-transform 0.3s;
							transition: transform 0.3s;
							-webkit-transform: translate3d(0,150%,0);
							transform: translate3d(0,150%,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_3 li.active::after {
							-webkit-transform: translate3d(0,0,0);
							transform: translate3d(0,0,0);
						}
						/*****************************/
						/* Triangle and Line */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_4
						{
							margin-bottom: 3px !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_4 li {
							padding: 18px 20px;
							overflow: visible !important;
							border-right: 1px solid <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?>;
							-webkit-transition: color 0.2s;
							transition: color 0.2s;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_4 li::after {
							position: absolute;
							top: 50%;
							left: 100%;
							width: 0;
							height: 0;
							border: solid transparent;
							content: '';
							pointer-events: none;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_4 li::before {
							position: absolute;
							top: 50%;
							left: 100%;
							width: 0;
							height: 0;
							display: block !important;
							border: solid transparent;
							content: '' !important;
							pointer-events: none;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_4 li.active::after {
							margin-top: -10px;
							border-width: 10px;
							border-left-color: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CBgC;?>;
							z-index: 100;
						}						
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_4 li.active::before {
							margin-top: -11px;
							border-width: 11px;
							border-left-color: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?>;
							z-index: 100;
						}
						/*****************************/
						/* Top Line */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_5 li {
							padding:1em;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_5 li.active {
							background: none;
							box-shadow: inset 0 3px 0 <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?> !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_5 li i::before {
							display: block;
							position: relative;
							left: 0%;
						}
						/*****************************/
						/* Falling Icon */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_6 li {
							display: inline-block;
							overflow: visible;
							padding: 1em 2em;
							-webkit-transition: color 0.3s cubic-bezier(0.7,0,0.3,1); 
							transition: color 0.3s cubic-bezier(0.7,0,0.3,1);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_6 li::before {
							position: absolute;
							display: block !important;
							bottom: 0;
							width: 100%;
							left: 0;
							height: 4px;
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?>;
							content: '';
							opacity: 0;
							-webkit-transition: -webkit-transform 0.2s ease-in;
							transition: transform 0.2s ease-in;
							-webkit-transform: scale3d(0,1,1);
							transform: scale3d(0,1,1);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_6 li.active::before {
							opacity: 1;
							-webkit-transform: scale3d(1,1,1);
							transform: scale3d(1,1,1);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_6 li i::before {
							display: block;
							position: relative;
							left: 0%;
							opacity: 0;
							-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
							transition: transform 0.2s, opacity 0.2s;
							-webkit-transform: translate3d(0,-100px,0);
							transform: translate3d(0,-100px,0);
							pointer-events: none;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_6 li.active i::before {
							opacity: 1;
							-webkit-transform: translate3d(0,0,0);
							transform: translate3d(0,0,0);
						}
						@media screen and (max-width: 58em) {
							.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_6 li i::before {
								opacity: 1;
								-webkit-transform: translate3d(0,0,0);
								transform: translate3d(0,0,0);
							}
						}
						/*****************************/
						/* Moving Line */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_7 li::before {
							position: absolute;
							display: block !important;
							top: 0;
							right: 0;
							width: 4px !important;
							height: 100%;
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?>;
							content: '';
							-webkit-transition: -webkit-transform 0.3s !important;
							transition: transform 0.3s !important;
							-webkit-transform: translate3d(0,101%,0);
								transform: translate3d(0,101%,0);
						}
	                	.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_7 li.active::before {
							-webkit-transform: translate3d(0%,0,0);
							transform: translate3d(0%,0,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_7 li.active{
							-webkit-transform: translate3d(-4px,0,0);
							transform: translate3d(-4px,0,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_7 li {
							padding: 1em 0.5em;
							margin: 2px 5px 0px 0px !important;
						}						
						/*****************************/
						/* Line */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_8 li {
							padding: 0.7em 0.4em;
							box-shadow: inset -2px 0 <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_C;?> !important;
							-webkit-box-shadow: inset -2px 0 <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_C;?> !important;
							text-align: left;
							letter-spacing: 1px;
							-webkit-transition: color 0.3s, box-shadow 0.3s !important;
							transition: color 0.3s, box-shadow 0.3s !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_8 li:hover, .Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_8 li:focus {
							box-shadow: inset -2px 0 <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_HC;?> !important;
							-webkit-box-shadow: inset -2px 0 <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_HC;?> !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_8 li.active {
							box-shadow: inset -2px 0 <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?> !important;
							-webkit-box-shadow: inset -2px 0 <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?> !important;
						}				
						/*****************************/
						/* Circle */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li::before {
							position: absolute;
							display: block !important;
							top: 0%;
							left: 0%;
							width: 100%;
							height: 100%;
							border: 1px solid <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CC;?>;
							border-radius: 50%;
							content: '';
							opacity: 0;
							-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
							transition: transform 0.2s, opacity 0.2s;
							-webkit-transition-timing-function: cubic-bezier(0.7,0,0.3,1);
							transition-timing-function: cubic-bezier(0.7,0,0.3,1);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li.active::before {
							opacity: 1;
							-webkit-transform: scale3d(0.9,0.9,0.9);
							transform: scale3d(0.9,0.9,0.9);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li {
							overflow: visible;
							-webkit-transition: color 0.3s cubic-bezier(0.7,0,0.3,1); 
							transition: color 0.3s cubic-bezier(0.7,0,0.3,1);
							padding: 1.5em; 
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li i::before {
							display: block;
							position: relative;
							left: 0%;
							-webkit-transition: -webkit-transform 0.3s cubic-bezier(0.7,0,0.3,1);
							transition: transform 0.3s cubic-bezier(0.7,0,0.3,1);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li i span {
							-webkit-transition: -webkit-transform 0.3s cubic-bezier(0.7,0,0.3,1);
							transition: transform 0.3s cubic-bezier(0.7,0,0.3,1);
							display: block;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li.active i span {
							-webkit-transform: translate3d(0,2px,0);
							transform: translate3d(0,2px,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li i::before {
							display: block;
							margin: 0;
							pointer-events: none;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_9 li.active i::before {
							-webkit-transform: translate3d(0px,-2px,0);
							transform: translate3d(0px,-2px,0);
						}
						/*****************************/
						/* Line Box */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_11 li {
							-webkit-flex: none;
							flex: none;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_11 li {
							padding: 1em;
							z-index: 10;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_11 li i::after {
							position: absolute;
							top: 0;
							left: 0;
							z-index: -1;
							width: 100%;
							height: 100%;
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_C;?>;
							content: '';
							-webkit-transition: background 0.8s, -webkit-transform 0.8s !important;
							transition: background 0.8s, transform 0.8s !important;
							-webkit-transition-timing-function: ease, cubic-bezier(0.7,0,0.3,1);
							transition-timing-function: ease, cubic-bezier(0.7,0,0.3,1);
							-webkit-transform: translate3d(100%,0,0) translate3d(-2px,0,0);
							transform: translate3d(100%,0,0) translate3d(-2px,0,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_11 li:hover i::after {
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_HC;?>;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_11 li.active i::after {
							-webkit-transform: translate3d(0,0,0);
							transform: translate3d(0,0,0);
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CBgC;?>;
						}
						/*****************************/
						/* Flip */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_12 li {
							padding: 1em;							
							z-index: 10;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_12 li::after {
							position: absolute;
							top: 0;
							left: 0;
							z-index: -1;
							width: 100%;
							height: 100%;
							background-color: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_BgC;?>;
							content: '';
							-webkit-transition: -webkit-transform 0.9s, background-color 0.3s !important;
							transition: transform 0.9s, background-color 0.3s !important;
							-webkit-transform: perspective(900px) rotate3d(0,-1,0,90deg);
							transform: perspective(900px) rotate3d(0,-1,0,90deg);
							-webkit-transform-origin: 100% 0%;
							transform-origin: 100% 0%;
							-webkit-perspective-origin: 100% 0%;
							perspective-origin: 100% 0%;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_12 li.active{
							background-color: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_BgC;?> !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_12 li.active::after {
							background-color: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CBgC;?>;
							-webkit-transform: perspective(900px) rotate3d(0,-1,0,0deg);
							transform: perspective(900px) rotate3d(0,-1,0,0deg);
						}
						/*****************************/
						/* Circle Fill */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_13 li {
							overflow: hidden;
							background: none !important;
							z-index: 10;
							padding: 0px !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_13 li i {
							padding: 1.5em;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_13 li::after {
							position: absolute;
							top: 0%;
							z-index: -1;
							left: 0%;
							width: 99%;
							height: 99%;
							border-radius: 50%;
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_BgC;?>;
							content: '';
							-webkit-transition: -webkit-transform 0.8s !important;
							transition: transform 0.8s !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_13 li:hover::after {
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_HBgC;?>;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_13 li.active::after {
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CBgC;?>;
							-webkit-transform: scale3d(2.5,2.5,1);
							transform: scale3d(2.5,2.5,1);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_13 li span {
							display: none;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_13 li i::before {
							display: block;
							margin: 0;
							pointer-events: none;
						}	
						/*****************************/
						/* Fill Up */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li, .Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li:hover {
							z-index: 10;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li i {
							padding: 1em 1em;
							-webkit-backface-visibility: hidden;
							backface-visibility: hidden;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li i.active {
							z-index: 100;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li i::after {
							position: absolute;
							top: 0;
							left: 0;
							z-index: -1;
							width: 100%;
							width: 100%;
							height: 100%;
							/*height: calc(100% + 1px);*/
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CBgC;?>;
							content: '';
							-webkit-transition: -webkit-transform 0.8s !important;
							transition: transform 0.8s !important;
							-webkit-transform: translate3d(-100%,0,0);
							transform: translate3d(-100%,0,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li.active i::after {
							-webkit-transform: translate3d(0,0,0);
							transform: translate3d(0,0,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li i span, .Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li i::before {
							-webkit-transition: -webkit-transform 0.5s;
							transition: transform 0.5s;
							-webkit-transform: translate3d(0,5px,0);
							transform: translate3d(0,5px,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li i span {
							display: block;							
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li i::before {
							display: block;
							margin: 0;
							position: relative;
							left: 0%;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li.active span {
							-webkit-transform: translate3d(0,-5px,0);
							transform: translate3d(0,-5px,0);
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_14 li.active i::before {
							-webkit-transform: translate3d(0,-10px,0);
							transform: translate3d(0,-10px,0);
						}
						/*****************************/
						/* Trapezoid */
						/*****************************/
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li, .Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li:hover, .Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li.active {
							background: none !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li {
							-webkit-backface-visibility: hidden;
							backface-visibility: hidden;
							z-index: 10;
							margin-right: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_PB-9;?>px !important;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li i {
							padding: 0.5em 1em;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li i::after {
							position: absolute;
							top: 0;
							right: 0;
							bottom: 0;
							left: 0;
							z-index: -1;
							outline: 1px solid transparent;
							border-radius: 0px 0px 10px 10px;
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_BgC;?>;
							box-shadow: inset 0 -3px 3px rgba(0,0,0,0.05);
							content: '';
							-webkit-transform: perspective(5px) rotateX(0.93deg) translateZ(-1px);
							transform: perspective(5px) rotateX(0.93deg) translateZ(-1px);
							-webkit-transform-origin: 0 0;
							transform-origin: 0 0;
							-webkit-backface-visibility: hidden;
							backface-visibility: hidden;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li:hover i::after{
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_HBgC;?>;
						}
						.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?> .Rich_Web_Tabs_tabs_15 li.active i::after{
							background: <?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_S_CBgC;?>;
							box-shadow: none;
						}
					<?php }?>				
				</style>
				<div class="Rich_Web_Tabs_Tab Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?>">
		            <!-- - - - - - Tab navigation - - - - - - -->
		            <ul class="<?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_N_S;?> Rich_Web_Tabs_tt_tabs">
		            	<?php for( $i = 0; $i < count($Rich_Web_Tabs_Fields); $i++ ){ ?>
		                	<li class="<?php if($i==0){echo 'active';}?>">
		                		<i class='rich_web rich_web-<?php echo $Rich_Web_Tabs_Fields[$i]->Tabs_Subicon;?>'>
		                			<span><?php echo html_entity_decode($Rich_Web_Tabs_Fields[$i]->Tabs_Subtitle);?></span>
		                		</i>
		                	</li>
		            	<?php }?>
		            </ul>
		            <!-- - - - - Tab Content - - - - - -->
		            <div class="Rich_Web_Tabs_tt_container">
		            	<?php for( $i = 0; $i < count($Rich_Web_Tabs_Fields); $i++ ){ ?>
		                	<div class="Rich_Web_Tabs_tt_tab <?php if($i==0){echo 'active';}?>"><?php echo html_entity_decode($Rich_Web_Tabs_Fields[$i]->Tabs_Subcontent);?></div>
		            	<?php }?>
		            </div><!-- .container -->
			    </div><!-- #myTab -->
			    <script type="text/javascript">
			    	jQuery(document).ready(function(){
					    jQuery('.Rich_Web_Tabs_Tab_<?php echo $Rich_Web_Tabs;?>').turbotabs({
					    	mode: '<?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_NavM;?>',
					        animation : '<?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_CA;?>',
				            width: '<?php echo $Rich_Web_Tabs_Theme[0]->Rich_Web_Tabs_T_W;?>%',
					    }); 
					});
			    </script>
			<?php
 		 	echo $after_widget;
 		}
	}
?>