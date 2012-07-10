<?php
/*
Plugin Name: Favicon Manager
Plugin URI: http://www.digitalramble.com/favicon-manager-wordpress-plugin/
Description: Adds your favicon to your headers and/or rss feeds. 
Version: 0.1
Author: Digital Ramble
Author URI: http://www.digitalramble.com
*/


/*
Copyright (C) 2006 Cindy Moore

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

http://www.gnu.org/licenses/gpl.txt

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

*/   

function get_favicon_type($name)
{
  if (preg_match("/\.gif$/i", $name))
  {
    return "gif";
  }
  if (preg_match("/\.ico$/i", $name))
  {
    return "x-icon";
  }
  if (preg_match("/\.jp[e]?g$/i", $name))
  {
    return "jpg";
  }
  if (preg_match("/\.png$/i", $name))
  {
    return "png";
  }
  return "";
}

function create_favicon_uri($favicon_location)
{
  // if an absolute location entered, don't try to add the site url...
  if (preg_match("/^http/", $favicon_location))
  {
    $favicon_url=$favicon_location;
  }
  else
  {
    $favicon_url= get_settings('siteurl') . '/' . $favicon_location;
  }
  return $favicon_url;
}

// if we've stored a favicon location in the database, retrieve it
// and put it into the headers.  the type of the favicon is determined from
// it's name; if unknown, take a trusting leap (and omit the type attribute;
// hey if it doesn't work, the user can go back to the option panel and
// fix the favicon name...)
// if no location stored, then exit quietly and do nothing at all
function add_favicon_to_headers() 
{
  $favicon_location=create_favicon_uri(get_option('fm_favicon_location'));
  if ($favicon_location) 
  {
    $favicon_type=get_favicon_type($favicon_location);
    if ($favicon_type)
    {
      print '	<link rel="icon" href="'. $favicon_location .'" type="image/'. $favicon_type .'" />';
      print "\n";
      print '	<link rel="shortcut icon" href="'. $favicon_location .'" type="image/'. $favicon_type .'" />';
      print "\n";
    }
    else
    {
      echo '	<link rel="icon" href="'. $favicon_location .'" />';
      print "\n";
      echo '	<link rel="shortcut icon" href="'. $favicon_location .'" />';
      print "\n";
    }
  }
}


// insert favicon into header using WP hooks
add_action('wp_head', 'add_favicon_to_headers');



// if the user has chosen to add the image to the atom feed then do so
// need to check both that the user checked the box and entered an image
// if either condition missing, then silently exit without printing anything
function add_image_to_atom_feed()
{
  if (get_option('fm_atom_feed_option'))
  {
    $favicon_location=create_favicon_uri(get_option('fm_favicon_location'));
    if ($favicon_location)
    {
      echo "<icon>". $favicon_location ."</icon>\n";
    }
  }
}



// if the user has chosen to add the image to the rss2 feed then do so
// need to check both that the user checked the box and entered an image
// if either condition missing, then silently exit without printing anything
function add_image_to_rss2_feed()
{
  if (get_option('fm_rss2_feed_option'))
  {
    $favicon_location=create_favicon_uri(get_option('fm_favicon_location'));
    if ($favicon_location)
    {
      echo "<image>\n";
      echo "  <link>". get_bloginfo_rss('url') ."</link>\n";
      echo "  <url>". $favicon_location ."</url>\n";
      echo "  <title>". get_bloginfo_rss('name') ."</title>\n";
      echo "</image>\n";
    }
  }
}

// insert image into rss2 feed 
add_action('rss2_head', 'add_image_to_rss2_feed');

// and into atom's feed
add_action('atom_head', 'add_image_to_atom_feed');



// options menu


// add the saved items to the database if not already there
function favicon_mgr_add_options()
{
	add_option('fm_favicon_location', '');
	add_option('fm_rss2_feed_option', false);
	add_option('fm_atom_feed_option', false);
}
// call to actually set up
favicon_mgr_add_options();


// create hook for new submenu
add_action('admin_menu', 'favicon_mgr_admin_menu');

// title of page, name of option in menu bar, which function lays out the html
function favicon_mgr_admin_menu()
{
  add_options_page(__('Favicon Manager Options'), __('Favicons'), 5, basename(__FILE__), 'favicon_mgr_options_page');
}

// html layout for option page, plus detection/update on new settings
function favicon_mgr_options_page()
{
  $updated = false;

  // did the user enter a new/changed location?
  if (isset($_POST['fm_favicon_location']))
  {
    $fm_favicon_location = $_POST['fm_favicon_location'];
    // remember the change in the database
    update_option('fm_favicon_location', $fm_favicon_location);
    // and remember to note the update to user
    $updated = true;
  }
  // either way make sure we have the latest value at hand
  $fm_favicon_location = get_option('fm_favicon_location');


  // same deal here for the check boxes, except that they behave
  // differently from text areas -- if "unchecked" you get no input.
  // so check if the submit button was hit, then compare stored/current
  // values to see what needs to be done.

  if (isset($_POST['update_favicons']))
  {
    $original_value=get_option('fm_rss2_feed_option');
    $current_value=isset($_POST['fm_rss2_feed_option']);
    if ($original_value!=$current_value)
    {
      update_option('fm_rss2_feed_option', $current_value);
      $updated = true;
    }

    $original_value=get_option('fm_atom_feed_option');
    $current_value=isset($_POST['fm_atom_feed_option']);
    if ($original_value!=$current_value)
    {
      update_option('fm_atom_feed_option', $current_value);
      $updated = true;
    }
  }
  $fm_rss2_feed_option = get_option('fm_rss2_feed_option');
  $fm_atom_feed_option = get_option('fm_atom_feed_option');

  // notify the user that we updated something
  if ($updated)
  {
    ?>
    <div class="updated"><p><strong>Options saved.</strong></p></div>
    <?php
  }
  
  // now tack on any beginning http that might be needed
  $favicon_url=create_favicon_uri($fm_favicon_location);


  // print the form page
  ?>
  <div class="wrap">
	  <h2>Favicon Settings</h2>
	  <form name="form1" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

		  <fieldset class="options">

			  <legend>Favicon in WordPress Pages</legend>
			  <table width="100%" cellspacing="2" cellpadding="5" class="editform">
			  <tr valign="top">
				  <th width="33%" scope="row">Location:</th>
				  <td><input name="fm_favicon_location" type="text" width="60" value="<?php echo $fm_favicon_location; ?>"/>
				  <br />You can enter a pathname relative to your WordPress installation, or an absolute (starting with http) address.
				  If it worked, your icon should show up below after updating:
				  <?php if ($favicon_url) { 
				    echo '<p><img src="'. $favicon_url .'" />'; } 
				    echo "from $favicon_url</p>\n";
				  ?>
				  </td>
			  </tr>
			  </table>

			  <legend>Images in Feeds</legend>
			  <table width="100%" cellspacing="2" cellpadding="5" class="editform">
			  <tr valign="top">
				  <th width="33%" scope="row">Add to RSS2 Feed?</th>
				  <td><input name="fm_rss2_feed_option" type="checkbox" value="Y" <?php if ($fm_rss2_feed_option) { echo "checked" ;} ?> >
				  </td>
			  </tr>
			  <tr valign="top">
				  <th width="33%" scope="row">Add to Atom Feed?</th>
				  <td><input name="fm_atom_feed_option" type="checkbox" value="Y" <?php if ($fm_atom_feed_option) { echo "checked"; } ?> >
				  </td>
			  </tr>
			  </table>
		  </fieldset>

		  <p class="submit">
		    <input type="submit" name="update_favicons" value="Update Options &raquo;" />
		  </p>
	  </form>
  
  </div>
  
  <?php 
}


?>
