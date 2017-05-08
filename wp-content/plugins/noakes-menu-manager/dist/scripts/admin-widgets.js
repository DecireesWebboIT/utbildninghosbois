/*!
 * Admin widgets JavaScript include.
 * 
 * @since 1.4.0
 * 
 * @package Nav Menu Manager
 */
var nmm_admin_widgets_l10n=nmm_admin_widgets_l10n||{};!function(n){"use strict";n.nmm=n.nmm||{},n.nmm.data=n.nmm.data||{},n.nmm.events=n.nmm.events||{},n.nmm.admin=n.nmm.admin||{},n.nmm.admin.widgets=n.nmm.admin.widgets||{},n.extend(n.nmm.data,{sibling:"nmm-sibling"}),n.extend(n.nmm.admin.widgets,{menu_dropdowns:function(m){m="undefined"==typeof m?n('.widget[id*="'+nmm_admin_widgets_l10n.menu_id+'"]').not('[id$="__i__"]').not("."+n.nmm.events.setup):m,m.each(function(){var m=n(this).addClass(n.nmm.events.setup),d=m.find('select[id$="theme_location"]'),i=m.find('select[id$="nav_menu"]').data(n.nmm.data.sibling,d);d.data(n.nmm.data.sibling,i).add(i).change(function(){var m=n(this);if(""!==m.val()){var d=m.data(n.nmm.data.sibling);""!==d.val()&&d.fadeOut(100,function(){n(this).val("").fadeIn(100)})}}),m.find(".nmm-help-button").removeClass("nmm-disabled")})}}),n.nmm.admin.widgets.menu_dropdowns(),n.nmm.include.scroll_stop(),n(document).ready(function(){var m=function(m,d){n.nmm.admin.widgets.menu_dropdowns(d),n.nmm.admin.help_buttons(d)};m(),n(this).on("widget-added widget-updated",m)})}(jQuery);
//# sourceMappingURL=admin-widgets.js.map
