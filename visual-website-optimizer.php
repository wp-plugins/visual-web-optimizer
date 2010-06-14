<?php
/*
Plugin Name: Visual Website Optimizer
Plugin URI: http://comluv.com
Description: Visual Website Optimizer is the world's easiest to use A/B, split and multivariate testing tool. Simply enable the plugin and start running tests on your Wordpress website without doing any other code changes. Visit <a href="http://visualwebsiteoptimizer.com/">Visual Website Optimizer</a> for more details.
Author: Andy Bailey
Version: 1.0.2
Author URI: http://fiddyp.co.uk

This relies on the actions being present in the themes header.php and footer.php
* header.php code before the closing </head> tag
* 	wp_head();
*
* footer.php code before </body> (maybe before last </div>)
* 	do_action('wp_footer');
* 	
*/

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

$clhf_header_script = '
<!-- Start Top Visual Website Optimizer Code -->
<script type=\'text/javascript\'>
var _vis_opt_account_id = VWO_ID;
var _vis_opt_protocol = ((\'https:\' == document.location.protocol) ? \'https://\' : \'http://\');
document.write(\'<script src=\"\' + _vis_opt_protocol + \'s3.amazonaws.com/wingify/vis_opt.js\" type=\"text/javascript\">\' + \'<\\/s\' + \'cript>\');
</script>
<script type=\'text/javascript\'>
if(typeof(_vis_opt_top_initialize) == "function") { document.write(\'<script src=\"\' + _vis_opt_protocol + \'dev.visualwebsiteoptimizer.com/deploy/js_visitor_settings.php?v=1&a=\'+_vis_opt_account_id+\'&url=\'+encodeURIComponent(document.URL)+\'&random=\'+Math.random()+\'\" type=\"text/javascript\">\' + \'<\\/s\' + \'cript>\'); }
</script>
<script type=\'text/javascript\'>
if(typeof(_vis_opt_settings_loaded) == "boolean" && typeof(_vis_opt_top_initialize) == "function"){ _vis_opt_top_initialize(); }
</script>
<!-- End Top Visual Website Optimizer Code -->
';

$clhf_footer_script = '
<!-- Start Bottom Visual Website Optimizer Code -->
<script type=\'text/javascript\'>
if(typeof(_vis_opt_settings_loaded) == "boolean" && typeof(_vis_opt_bottom_initialize) == "function")
{_vis_opt_bottom_initialize();}
</script>
<!-- End Bottom Visual Website Optimizer Code -->
';

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action ( 'wp_footer', 'clhf_footercode',10 );
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
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//
function clhf_headercode(){
	// runs in the header
	global $clhf_header_script;
	$vwo_id = get_option('vwo_id');
	if($vwo_id){
		// only output if options were saved
		echo str_replace('VWO_ID',$vwo_id,$clhf_header_script);
	}
	
}
function clhf_footercode(){
	// runs in the footer
	global $clhf_footer_script;
	$vwo_id = get_option('vwo_id');
	if($vwo_id){
		// only output if header was done
		echo $clhf_footer_script;
	}
}
//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//
// options page
function clhf_plugin_options() {
  echo '<div class="wrap">';?>
	<h2>Visual Website Optimizer</h2>
	<p>You need to have a <a href="http://visualwebsiteoptimizer.com/">Visual Website Optimizer</a> account in order to use this plugin. This plugin inserts the neccessary code into your Wordpress site automatically without you having to touch anything. In order to use the plugin, you need to enter your VWO Account ID in the field below:</p>																		
	<form method="post" action="options.php">
	<?php settings_fields( 'clhf_vwo_options' ); ?>
	<table class="form-table">
        <tr valign="top">
        <th scope="row">Your VWO Account ID</th>
        <td><input type="text" name="vwo_id" value="<?php echo get_option('vwo_id'); ?>" /></td>
        </tr>
	</table>
	<p class="submit">
	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
	<p>Your Account ID (a number) can be found in <i>Settings</i> area (top-left, just under the logo) after you <a href="https://dev.visualwebsiteoptimizer.com/login.php">login</a> into your Visual Website Optimizer account</a>. 
	<div style="padding: 5px; border-top: 1px solid #000000; border-left: 1px solid #000000; border-bottom: 1px solid #cccccc; border-right: 1px solid #cccccc; display:none">
		<?php
		global $clhf_header_script;
		echo str_replace(array('VWO_ID',"\n"),array('<span class="updated">Your ID Here</span>','<br>'),htmlspecialchars($clhf_header_script));
		?>		
	</div>
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