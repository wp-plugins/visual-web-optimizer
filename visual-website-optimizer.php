<?php
/*
Plugin Name: Visual Website Optimizer
Plugin URI: http://visualwebsiteoptimizer.com/
Description: Visual Website Optimizer is the world's easiest to use A/B, split and multivariate testing tool. Simply enable the plugin and start running tests on your Wordpress website without doing any other code changes. Visit <a href="http://visualwebsiteoptimizer.com/">Visual Website Optimizer</a> for more details.
Author: Andy Bailey
Version: 2.3
screenshot-1.png
screenshot-2.png
visual-website-optimizer.php
Author URI: http://fiddyp.co.uk

This relies on the actions being present in the themes header.php and footer.php
* header.php code before the closing </head> tag
* 	wp_head();
*
*/

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

$clhf_header_script_sync = '
<!-- Start Visual Website Optimizer Code -->
<script type=\'text/javascript\'>
var _vis_opt_account_id = VWO_ID;
var _vis_opt_protocol = ((\'https:\' == document.location.protocol) ? \'https://\' : \'http://\');
document.write(\'<s\' + \'cript src="\' + _vis_opt_protocol + \'dev.visualwebsiteoptimizer.com/deploy/js_visitor_settings.php?v=1&a=\'+_vis_opt_account_id+\'&url=\'+encodeURIComponent(document.URL)+\'&random=\'+Math.random()+\'" type="text/javascript">\' + \'<\/s\' + \'cript>\');
</script>
<script type=\'text/javascript\'>
if(typeof(_vis_opt_settings_loaded) == "boolean") { document.write(\'<s\' + \'cript src="\' + _vis_opt_protocol + \'d5phz18u4wuww.cloudfront.net/vis_opt.js" type="text/javascript">\' + \'<\/s\' + \'cript>\'); }
</script>
<script type=\'text/javascript\'>
if(typeof(_vis_opt_settings_loaded) == "boolean" && typeof(_vis_opt_top_initialize) == "function"){ _vis_opt_top_initialize();
vwo_$(document).ready(function() { _vis_opt_bottom_initialize(); }); }
</script>
<!-- End Visual Website Optimizer Code -->
';

$clhf_header_script_async = '
<!-- Start Visual Website Optimizer Asynchronous Code -->
<script type=\'text/javascript\'>
var _vwo_code=(function(){
var account_id=VWO_ID,
settings_tolerance=SETTINGS_TOLERANCE,
library_tolerance=LIBRARY_TOLERANCE,
use_existing_jquery=false,
f=false,d=document;return{use_existing_jquery:function(){return use_existing_jquery;},library_tolerance:function(){return library_tolerance;},finish:function(){if(!f){f=true;var a=d.getElementById(\'_vis_opt_path_hides\');if(a)a.parentNode.removeChild(a);}},finished:function(){return f;},load:function(a){var b=d.createElement(\'script\');b.src=a;b.type=\'text/javascript\';b.innerText;b.onerror=function(){_vwo_code.finish();};d.getElementsByTagName(\'head\')[0].appendChild(b);},init:function(){settings_timer=setTimeout(\'_vwo_code.finish()\',settings_tolerance);this.load(\'//dev.visualwebsiteoptimizer.com/j.php?a=\'+account_id+\'&u=\'+encodeURIComponent(d.URL)+\'&r=\'+Math.random());var a=d.createElement(\'style\'),b=\'body{opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important;}\',h=d.getElementsByTagName(\'head\')[0];a.setAttribute(\'id\',\'_vis_opt_path_hides\');a.setAttribute(\'type\',\'text/css\');if(a.styleSheet)a.styleSheet.cssText=b;else a.appendChild(d.createTextNode(b));h.appendChild(a);return settings_timer;}};}());_vwo_settings_timer=_vwo_code.init();
</script>
<!-- End Visual Website Optimizer Asynchronous Code -->
';


//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action ( 'wp_head', 'clhf_headercode',1 );
add_action( 'admin_menu', 'clhf_plugin_menu' );
add_action( 'admin_init', 'clhf_register_mysettings' );
add_action( 'admin_notices','clhf_warn_nosettings');


//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
// options page link
function clhf_plugin_menu() {
  add_options_page('Visual Website Optimizer', 'VWO', 'create_users', 'clhf_vwo_options', 'clhf_plugin_options');
}

// whitelist settings
function clhf_register_mysettings(){
	register_setting('clhf_vwo_options','vwo_id','intval');
	register_setting('clhf_vwo_options','code_type');
	register_setting('clhf_vwo_options','settings_tolerance','intval');
	register_setting('clhf_vwo_options','library_tolerance','intval');
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//
function clhf_headercode(){
	// runs in the header
	global $clhf_header_script_sync, $clhf_header_script_async;
	$vwo_id = get_option('vwo_id');
	$code_type = get_option('code_type');
	if($vwo_id){
		if($code_type == 'SYNC')
			echo str_replace('VWO_ID', $vwo_id, $clhf_header_script_sync); // only output if options were saved
		else {
			$settings_tolerance = get_option('settings_tolerance');
			if(!is_numeric($settings_tolerance)) $settings_tolerance = 2000;

			$library_tolerance = get_option('library_tolerance');
			if(!is_numeric($library_tolerance)) $library_tolerance = 1500;

			$clhf_header_script_async = str_replace('VWO_ID', $vwo_id, $clhf_header_script_async);
			$clhf_header_script_async = str_replace('SETTINGS_TOLERANCE', $settings_tolerance, $clhf_header_script_async);
			echo str_replace('LIBRARY_TOLERANCE', $library_tolerance, $clhf_header_script_async);
		}
	}
}
//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//
// options page
function clhf_plugin_options() {
  echo '<div class="wrap">';?>
	<h2>Visual Website Optimizer</h2>
	<p>You need to have a <a href="http://visualwebsiteoptimizer.com/">Visual Website Optimizer</a> account in order to use this plugin. This plugin inserts the neccessary code into your Wordpress site automatically without you having to touch anything. In order to use the plugin, you need to enter your VWO Account ID:</p>
	<form method="post" action="options.php">
	<?php settings_fields( 'clhf_vwo_options' ); ?>
	<table class="form-table">
        <tr valign="top">
            <th scope="row">Your VWO Account ID</th>
            <td><input type="text" name="vwo_id" value="<?php echo get_option('vwo_id'); ?>" /></td>
        </tr>
		<tr valign="top">
	        <th scope="row">Code (default: Asynchronous)</th>
	        <td>
		        <input style="vertical-align: text-top;" type="radio" onclick="selectCodeType();" name="code_type" id="code_type_async" value="ASYNC" <?php if(get_option('code_type')!='SYNC') echo "checked"; ?> /> Asynchronous&nbsp;&nbsp;&nbsp;
		        <input style="vertical-align: text-top;" type="radio" onclick="selectCodeType();" name="code_type" id="code_type_sync" value="SYNC" <?php if(get_option('code_type')=='SYNC') echo "checked"; ?> /> Synchronous
		        &nbsp;<a href="http://visualwebsiteoptimizer.com/split-testing-blog/asynchronous-code" target="_blank">[Help]</a>
	        </td>
        </tr>
		<tr valign="top" id='asyncOnly1' <?php if(get_option('code_type')=='SYNC') echo "style='display:none;'" ?>>
	        <th scope="row">Settings Timeout</th>
			<td style="vertical-align: middle;"><input type="text" name="settings_tolerance" value="<?php echo get_option('settings_tolerance')?get_option('settings_tolerance'):2000; ?>" />ms  (default: 2000)</td>
	    </tr>
		<tr valign="top" id='asyncOnly2' <?php if(get_option('code_type')=='SYNC') echo "style='display:none;'" ?>>
	        <th scope="row">Library Timeout</th>
			<td style="vertical-align: middle;"><input type="text" name="library_tolerance" value="<?php echo get_option('library_tolerance')?get_option('library_tolerance'):1500; ?>" />ms  (default: 1500)</td>
	    </tr>
	</table>

	<script type="text/javascript">
		function selectCodeType() {
			var code_type = 'ASYNC';
			if(document.getElementById('code_type_sync').checked)
				code_type = 'SYNC';

			if(code_type == 'ASYNC') {
				document.getElementById('asyncOnly1').style.display = 'table-row';
				document.getElementById('asyncOnly2').style.display = 'table-row';
			}
			else {
				document.getElementById('asyncOnly1').style.display = 'none';
				document.getElementById('asyncOnly2').style.display = 'none';
			}
		}
	</script>
	<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
	<p>Your Account ID (a number) can be found in <i>Settings</i> area (top-right) after you <a href="https://v2.visualwebsiteoptimizer.com">login</a> into your Visual Website Optimizer account.</p>
<?php
  echo '</div>';
}

function clhf_warn_nosettings(){
    if (!is_admin())
        return;

  $clhf_option = get_option("vwo_id");
  if (!$clhf_option || $clhf_option < 1){
    echo "<div id='vwo-warning' class='updated fade'><p><strong>Visual Website Optimizer is almost ready.</strong> You must <a href=\"options-general.php?page=clhf_vwo_options\">enter your Account ID</a> for it to work.</p></div>";
  }
}
?>