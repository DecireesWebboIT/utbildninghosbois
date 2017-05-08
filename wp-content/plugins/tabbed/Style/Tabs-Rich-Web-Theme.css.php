<?php
	if(!defined('ABSPATH')) exit;
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
?>
<style type="text/css">
	.Rich_Web_Tabs_Add_Theme { position: absolute; right: 10px; bottom: 10px; padding: 5px 10px;	background: #47bde5; cursor: pointer; border: none; box-shadow: 0px 0px 2px #47bde5; color: #fff; text-shadow:1px 1px 1px #000000; width: initial; height:30px; transition:all 0.3s linear; }
	.Rich_Web_Tabs_AddAnim_Theme { width:0px !important; padding:0px !important; transition:all 0s linear; }
	.Rich_Web_Tabs_Save_Theme,.Rich_Web_Tabs_Update_Theme,.Rich_Web_Tabs_Cancel_Theme { position: absolute; right: 10px; bottom: 10px; padding: 0px; background: #47bde5; cursor: pointer; border: none; box-shadow: 0px 0px 2px #47bde5; color: #fff; text-shadow:1px 1px 1px #000000; width:0px; height:30px; transition:all 0.3s linear; }
	.Rich_Web_Tabs_SaveAnim_Theme { padding: 5px 10px !important; width: initial !important; right:80px !important; transition:all 0s linear; } 
	.Rich_Web_Tabs_Save_Theme:hover,.Rich_Web_Tabs_Cancel_Theme:hover,.Rich_Web_Tabs_Update_Theme:hover,.Rich_Web_Tabs_Add_Theme:hover { color: #fff; background:#30a9d1; box-shadow: 0px 0px 2px #30a9d1; }
	.Rich_Web_Tabs_CancelAnim_Theme { padding: 5px 10px !important; width: initial !important; transition:all 0s linear; }
	.Rich_Web_Tabs_Content_Theme { position: relative; width: 99%; }
	.Rich_Web_Tabs_Content_Data1_Theme { position:absolute; top:0%; left:0%; width:100% !important; margin-top:10px;	z-index:1; }
	.Rich_Web_Tabs_Content_Table_Theme { width: 100%; background-color: #fff; text-align: center; text-shadow:1px 1px 1px #000000; padding: 1px; color: #fff; }
	.Rich_Web_Tabs_Content_Table_Tr_Theme { background:#30a9d1; }
	.Rich_Web_Tabs_Content_Table_Theme td:nth-child(1) { width:10%; }
	.Rich_Web_Tabs_Content_Table_Theme td:nth-child(2) { width:60%; }
	.Rich_Web_Tabs_Content_Table_Theme td:nth-child(3) { width:30%; }
	.Rich_Web_Tabs_Content_Table2_Theme { width: 100%; background-color: #fff; margin-top:10px; text-align: center; text-shadow:0px 0px 0px #000000; padding: 1px; color: #34383c; }
	.Rich_Web_Tabs_Content_Table_Tr2_Theme { background:#f1f1f1; }
	.Rich_Web_Tabs_Content_Table_Tr2_Theme:nth-child(even) { background:#ffffff; }
	.Rich_Web_Tabs_Content_Table_Tr2_Theme:hover { background-color: #e9e9e9; }
	.Rich_Web_Tabs_Content_Table2_Theme td:nth-child(1) { width:10%; }
	.Rich_Web_Tabs_Content_Table2_Theme td:nth-child(2) { width:60%; }
	.Rich_Web_Tabs_Content_Table2_Theme td:nth-child(3) { width:10%; cursor:pointer; }
	.Rich_Web_Tabs_Content_Table2_Theme td:nth-child(4) { width:10%; cursor:pointer; }
	.Rich_Web_Tabs_Content_Table2_Theme td:nth-child(5) { width:10%; cursor:pointer; }
	.Rich_Web_Tabs_Edit { color:#ff0000; }
	.Rich_Web_Tabs_Del { color:#00a0d2; }
	.Rich_Web_Tabs_Copy { color: #02b424; }
	.Rich_Web_Tabs_Content_Data2_Theme { position:absolute; top:0%; left:0%; width:100% !important; margin-top:10px; z-index:1; display:none; }
	.Rich_Web_Tabs_Content_Table3_Theme { position:relative; width: 100%; padding: 1px; background-color: #fff; text-align: center; color: #000; font-size: 12px; margin-bottom:15px; }
	.Rich_Web_Tabs_Content_Table3_Theme tr { background:rgba(255,255,255,.9); height: 35px; }
	.Rich_Web_Tabs_Content_Table3_Theme tr:nth-child(even) { background: #f1f1f1; }
	.Rich_Web_Tabs_Content_Table3_Theme tr td { width: 25%; cursor: default; }
	.Rich_Web_Tabs_Content_Table3_Theme input[type=text], .Rich_Web_Tabs_Content_Table3_Theme select { width: 70%; }
	.Rich_Web_Tabs_T_Pro { font-weight: 900; color: #ff0000; font-size: 14px; margin-left: 5px; cursor: default; }

	/* Switch */
	.switch { position: relative; display: block; vertical-align: top; width: 80px;	height: 25px; padding: 3px; margin:auto; margin-top: -3px; background: linear-gradient(to bottom, #eeeeee, #FFFFFF 25px); background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF 25px); border-radius: 18px; box-shadow: inset 0 -1px white, inset 0 1px 1px rgba(0, 0, 0, 0.05); cursor: pointer; }
	.switch-input {	position: absolute;	top: 0;	left: 0; opacity: 0; }
	.switch-label {	position: relative; display: block;	height: inherit; font-size: 10px; text-transform: uppercase; background: #ff0000; border-radius: inherit; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.12), inset 0 0 2px rgba(0, 0, 0, 0.15); }
	.switch-label:before, .switch-label:after {	position: absolute; top: 50%; margin-top: -.5em; line-height: 1; -webkit-transition: inherit; -moz-transition: inherit; -o-transition: inherit;	transition: inherit; }
	.switch-label:before { content: attr(data-off); right: 11px; color: #ff0000; }
	.switch-label:after { content: attr(data-on); left: 11px; color: #FFFFFF; opacity: 0; }
	.switch-input:checked ~ .switch-label {	background: #E1B42B; }
	.switch-input:checked ~ .switch-label:before { opacity: 0; }
	.switch-input:checked ~ .switch-label:after { opacity: 1; }
	.switch-handle { position: absolute; top: 4px; left: 4px; width: 28px; height: 28px; background: linear-gradient(to bottom, #FFFFFF 40%, #f0f0f0); background-image: -webkit-linear-gradient(top, #FFFFFF 40%, #f0f0f0); border-radius: 100%; box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2); }
	.switch-handle:before {	content: ""; position: absolute; top: 50%; left: 50%; margin: -6px 0 0 -6px; width: 12px; height: 12px; background: linear-gradient(to bottom, #eeeeee, #FFFFFF); background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF); border-radius: 6px; box-shadow: inset 0 1px rgba(0, 0, 0, 0.02); }
	.switch-input:checked ~ .switch-handle { left: 74px; box-shadow: -1px 1px 5px rgba(0, 0, 0, 0.2); }
	.switch-light {	padding: 0;	background: #FFF; background-image: none; }
	.switch-light .switch-label { background: #FFF;	border: solid 2px #ff0000; box-shadow: none; }
	.switch-light .switch-label:after { color: #79e271; }
	.switch-light .switch-label:before { right: inherit; left: 11px; }
	.switch-light .switch-handle { top: 5px; left: 55px; background: #ff0000; width: 20px; height: 20px; box-shadow: none; }
	.switch-light .switch-handle:before { background: #fe8686; }
	.switch-light .switch-input:checked ~ .switch-label { background: #FFF; border-color: #79e271; }
	.switch-light .switch-input:checked ~ .switch-handle { left: 55px; box-shadow: none; background: #79e271 }
	.switch-light .switch-input:checked ~ .switch-handle:before { background: rgba(255,255,255,0.7); }
	.switch-label, .switch-handle {	transition: All 0.3s ease; -webkit-transition: All 0.3s ease; -moz-transition: All 0.3s ease; -o-transition: All 0.3s ease; }
	/* Switch */
</style>