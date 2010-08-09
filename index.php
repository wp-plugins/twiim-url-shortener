<?PHP
/*
Plugin Name: Twi.im URL Shortener
Plugin URI: http://twi.im
Description: Shorten URLs for all your posts automatically with the twi.im plugin
Author: Twi.im
Version: 0.6.1
Author URI: http://twi.im/contact.php
*/

include('twi.im.php');



function twiim_display($content){

	// this is where we'll display the bio

	

	//$options['page'] = get_option('twiim_hash');

	$options['twiim_display'] = get_option('twiim_display');

	$options['twiim_pages'] = get_option('twiim_pages');

	$options['twiim_homepage'] = get_option('twiim_homepage');
	
	$options['twiim_css'] = get_option('twiim_css');

	$link = get_permalink();

	

	// Display on Homepage?

	if(is_front_page() && $options['twiim_homepage'] != 'checked'){

		return $content;	
		exit();
	}

	// Display on Pages?

	if(is_page() && $options['twiim_pages'] != 'checked'){

		return $content;	
		exit();
	}

	$twiim_link = create_twiim($link);

	$twiim = 

		'<div id="twiim-box">
		<div id="twiim-inner">
<a href="http://twi.im">
			<img src="'.get_site_url().'/wp-content/plugins/twiim-url-shortener/img/logo.png" width="70px" id="twiim-img">
</a>

			<input type="text" value="'.$twiim_link.'" name="theurl" size="35" readonly="readonly" onclick="select();">

		</div></div>';

		

	// this is where we'll style our box	
	if(isset($options['twiim_css']) && $options['twiim_css'] != ''){
		$twiim .= '<style type=\'text/css\'>'.$options['twiim_css'].'</style>';
	} else {
		$twiim .= '<style type=\'text/css\'>

			#twiim-box {
				width: 97%;
				border-top: 1px solid #888;
				margin: 0 auto;
			}
			#twiim-inner {
				width: 350px;
				margin: 0 auto;	
				margin-top: 10px;
			}
			#twiim-img {
				vertical-align: -25%;
			}
		</style>';
	}
		

			// Display results

			if($options['twiim_display'] == 'bottom'){

				return $content . $twiim;
				exit();
			} elseif($options['twiim_display'] == 'top'){

				return $twiim . $content;
				exit();
			} else {

				return $content;
				exit();
			}

}





// Create Admin menu Settings

function twiim_settings(){

	// this is where we'll display our admin options

	if ($_POST['action'] == 'update'){

		update_option('twiim_hash', $_POST['twiim_hash']);

		update_option('twiim_pages', $_POST['twiim_pages']);

		update_option('twiim_homepage', $_POST['twiim_homepage']);

		update_option('twiim_display', $_POST['twiim_display']);



		$message = '<div id="message" class="updated fade"><p><strong>Options Saved!</strong></p></div>';

	}

	

	if($_POST['redo'] == '1'){

		//generate_all_twiims();

		$message = '<div id="message" class="updated fade"><p><strong>Twi.im\'s Generated!</strong></p></div>';



	}

	

	#$_POST['twiim_hash'] = get_option('twiim_hash');

	$options['hash'] = get_option('twiim_hash');

	$options['twiim_pages'] = get_option('twiim_pages');

	$options['twiim_homepage'] = get_option('twiim_homepage');

	$options['display'] = get_option('twiim_display');
	
	$options['twiim_css'] = get_option('twiim_css');

	

	echo '

	<div class="wrap">

		'.$message.'

		<div id="icon-options-general" class="icon32"><br /></div>

		<h2>Twi.im Settings</h2>

		

		<form method="post" action="">

		<input type="hidden" name="action" value="update" />

		

		<h3>Display Options</h3>

	';

	

	if($options['display'] == 'bottom'){

		$display = '<option value="top" name="top">Top of Posts</option><option value="bottom" name="bottom" selected>Bottom</option><option value="none">None</option>';

	} elseif($options['display'] == 'none') {

		$display = '<option value="top">Top of Posts</option><option value="bottom">Bottom</option><option value="none" selected>None</option>';	

	} else {

		$display = '<option value="top" selected>Top of Posts</option><option value="bottom">Bottom</option><option value="none">None</option>';	

	}

	

	echo '

		Display at: <select name="twiim_display">'.$display.'</select><br /><br />

		

		Display on Pages: <input type="checkbox" name="twiim_pages" value="checked" '.$options['twiim_pages'].'/><br /><br />

		

		Display on Homepage: <input type="checkbox" name="twiim_homepage" value="checked" '.$options['twiim_homepage'].'/><br /><br />

				

		<!-- <h3>Your Twi.im Hash</h3>

		Hash: <input name="twiim_hash" type="text" size="30" id="twiim_hash" value=""/> <a href="#" id="more-link" onclick="document.getElementById(\'more-info\').style.display = \'block\'; document.getElementById(\'more-link\').style.display = \'none\';">(More Info)</a><br /> -->

		

		<div style="display: none;" id="more-info">

			<p><em>This is optional and allows you to link all your automatically generated links to your twi.im account.</em></p>

		</div>

		<h3>Custom CSS</h3>
			<a href="#" id="css-link" onclick="document.getElementById(\'css-info\').style.display = \'block\'; document.getElementById(\'css-link\').style.display = \'none\';">More Info</a>
		<br />	
			<textarea rows="9" cols="50">
				'.$options['twiim_css'].'
			</textarea>
		<br />
		
		<div style="display: none;" id="css-info">
			<p>
				<em>This is the default CSS</em>
				
				<blockquote>
					#twiim-box {
						width: 97%;
						border-top: 1px solid #888;
						margin: 0 auto;
					}
					
					#twiim-inner {
						width: 350px;
						margin: 0 auto;	
						margin-top: 10px;
					}
					
					#twiim-img {
						vertical-align: -25%;
					}
				</blockquote>
			</p>
		</div>


		<br />

		<input type="submit" class="button-primary" value="Save Changes" />

		</form>

		

		<!-- <h3>Recreate Twi.im\'s</h3>

		<form method="post" action="">

			<input type="hidden" name="redo" value="1">

			<input type="submit" class="button-primary" value="Create Twi.im\'s for all URLs">

		</form> -->

		

	</div>';

}



function twiim_admin_menu(){

	// this is where we add our plugin to the admin menu

	add_options_page('Twiim Settings', 'Twiim Settings', 9, basename(__FILE__), 'twiim_settings');

}



add_action('the_content', 'twiim_display');

add_action('admin_menu', 'twiim_admin_menu');

//add_action('wp_head', 'twiim_style');



?>