<?php
/*
Plugin Name: Let It Snow!
Plugin URI: http://blog.coma.sg/odds-and-ends/let-it-snow/
Description: Snow on your Wordpress Blog based on the DHTML Snowstorm script by <cite><a href="http://www.schillmania.com/projects/snowstorm/" title="DHTML Snowstorm">Scott Schiller</a>.</cite>
Version: 2.0
Author: Aen Tan
Author URI: http://blog.coma.sg/
*/
function snow_options() {
	add_menu_page('Let It Snow!', 'Let It Snow!', 8, basename(__FILE__), 'snow_options_page');
	add_submenu_page(basename(__FILE__), 'Settings', 'Settings', 8, basename(__FILE__), 'snow_options_page');
}
?>
<?php function snow_options_page() { ?>

<div class="wrap">
    
    <div class="icon32" id="icon-options-general"><br/></div><h2>Settings for Let It Snow!</h2>

    <form method="post" action="options.php">

	    <?php
	        // New way of setting the fields, for WP 2.7 and newer
	        if(function_exists('settings_fields')){
	            settings_fields('snow-options');
	        } else {
	            wp_nonce_field('update-options');
	            ?>
	            <input type="hidden" name="action" value="update" />
	            <input type="hidden" name="page_options" value="sflakesMax,sflakesMaxActive,svMaxX,svMaxY,ssnowStick,sfollowMouse" />
	            <?php
	        }
	    ?>
	
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="sflakesMax">Max. number of flakes</label></th>
				<td>
					<input type="text" name="sflakesMax" value="<?php echo get_option('sflakesMax'); ?>" size="10" />
					<span class="description">Max. number of snowflakes that can exist on the screen at any given time.</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sflakesMaxActive">Max. number of active flakes</label></th>
				<td>
					<input type="text" name="sflakesMaxActive" value="<?php echo get_option('sflakesMaxActive'); ?>" size="10" />
					<span class="description">Sets the limit of "falling" snowflakes (ie. moving, thus considered to be "active".)</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="svMaxX">Snowfall max. speed (horizontal)</label></th>
				<td>
					<input type="text" name="svMaxX" value="<?php echo get_option('svMaxX'); ?>" size="5" />
					<span class="description">Should be 1 - 10</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="svMaxY">Snowfall max. speed (vertical)</label></th>
				<td>
					<input type="text" name="svMaxY" value="<?php echo get_option('svMaxY'); ?>" size="5" />
					<span class="description">Should be 1 - 10</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="ssnowStick">Sticky snow?</label></th>
				<td>
					<select name="ssnowStick">
                		<option <?php if (get_option('ssnowStick') == '1') echo 'selected="selected"'; ?> value="1">Yes</option>
                		<option <?php if (get_option('ssnowStick') == '0') echo 'selected="selected"'; ?> value="0">No</option> 
                	</select>
                	<span class="description">Should the snow to "stick" to the bottom of the window?</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sfollowMouse">Follow mouse?</label></th>
				<td>
					<select name="sfollowMouse">
                		<option <?php if (get_option('sfollowMouse') == '1') echo 'selected="selected"'; ?> value="1">Yes</option>
                		<option <?php if (get_option('sfollowMouse') == '0') echo 'selected="selected"'; ?> value="0">No</option> 
                	</select>
                	<span class="description">Should the snow follow the mouse movement?</span>
				</td>
			</tr>
		</table>
		<p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" class="button-primary" />
        </p>

    </form>
    
    <p>Like <em>Let It Snow!</em>? It&rsquo;s just a little pet project of mine. If you like it, do me a favor and follow me on <a href="http://twitter.com/Aen">Twitter (@Aen)</a></p>

</div>
<?php } ?>
<?php
// On access of the admin page, register these variables (required for WP 2.7 & newer)
function snow_init(){
    if(function_exists('register_setting')){
        register_setting('snow-options', 'sflakesMax');
        register_setting('snow-options', 'sflakesMaxActive'); 
        register_setting('snow-options', 'svMaxX'); 
        register_setting('snow-options', 'svMaxY');
        register_setting('snow-options', 'ssnowStick');
        register_setting('snow-options', 'sfollowMouse');
    }
}

// Only all the admin options if the user is an admin
if(is_admin()){
    add_action('admin_menu', 'snow_options');
    add_action('admin_init', 'snow_init');
}

//Set the default options when the plugin is activated
function snow_activate(){
    add_option('sflakesMax', 64);
    add_option('sflakesMaxActive', 64);
    add_option('svMaxX', 2);  
    add_option('svMaxY', 3);
    add_option('ssnowStick', 1);  
    add_option('sfollowMouse', 0);
}

register_activation_hook( __FILE__, 'snow_activate' );

function let_it_snow() {
	// Path for snow images
	$snowPath = get_option('siteurl').'/wp-content/plugins/let-it-snow/';

	$snowJS =	'<script type="text/javascript">
				sitePath = "'.$snowPath.'";
				sflakesMax = '.get_option('sflakesMax').';
				sflakesMaxActive = '.get_option('sflakesMaxActive').';
				svMaxX = '.get_option('svMaxX').';
				svMaxY = '.get_option('svMaxY').';
				ssnowStick = '.get_option('ssnowStick').';
				sfollowMouse = '.get_option('sfollowMouse').';
				</script>';

	$snowJS .= '<script type="text/javascript" src="'.$snowPath.'script/snowstorm.js"></script>'."\n";
	
	print($snowJS);
}
add_action('wp_head', 'let_it_snow');
?>