<?php
/*
Plugin Name:	Link Hopper
Plugin URI:		http://www.fergusweb.net/software/linkhopper/
Description:	Provides an easy interface to mask outgoing links using <code>site.com/hop/XXXXXX</code> syntax.  Configure hops via wp-admin.
Version:		1.4
Author:			Anthony Ferguson
Author URI:		http://www.fergusweb.net
*/


/**
Note: We COULD call a logging script before doing wp_redirect

Not sure how to store that data though.
	Could be a row an the _options table, a simple integer increment (click counter)
	Could store as custom post-types to include more comprehensive data (date/time of click, user agent, IP, logged-in user, etc)

Not sure about referencing back history data either.  The hop_name is prone to change.  Would need to store a combo of hop_name+hop_url maybe?

*/

new LinkHopper();


class LinkHopper {
	public	$nonce			= 'link_hopper_opts';
	public	$option_key		= 'optLinkHopper';
	public	$opts			= false;
	
	
	/**
	 *	Constructor
	 */
	function __construct() {
		$this->load_options();
		add_action('template_redirect', array(&$this,'hijack_and_redirect'));
		add_action('admin_menu', array(&$this,'admin_menu'));
	}
	
	
	/**
	 *	Option helper functions
	 */
	function load_options() {
		$this->opts = get_option($this->option_key);
		if (!$this->opts)	$this->default_options();
		return $this->opts;
	}
	function save_options($options = false) {
		if (!$options) { $options = $this->opts; }
		update_option($this->option_key, $options);
	}
	function default_options() {
		$this->opts = array(
			'baseURL'	=> 'hop',
			'hops'		=> array(
				'google'	=> 'http://www.google.com'
			),
		);
	}
	
	
	/**
	 *	If applicable, hijack the page request and perform redirect
	 */
	function hijack_and_redirect() {
		$request = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$hop_base = trailingslashit(trailingslashit(home_url()).$this->opts['baseURL']);
		// Only run if this is a hop URL
		if (substr($request,0,strlen($hop_base)) != $hop_base)	return false;
		
		$hop_key = str_ireplace($hop_base, '', $request);								// Figure out our request token
		if(substr($hop_key, -1) == '/')		$hop_key = substr($hop_key, 0, -1);			// Remove trailing slash
		
		// Do we have a hop for this key?
		if (array_key_exists($hop_key, $this->opts['hops'])) {
			// Call logging script here?
			
			// Perform redirect (302 = temporary redirect)
			wp_redirect( $this->opts['hops'][$hop_key], 302 );
			exit;
		}
	}
	
	
	/**
	 *	Admin Config
	 */
	function admin_menu() {
		$hook = add_management_page('LinkHopper Config', 'Link Hopper', 'manage_options', basename(__FILE__), array(&$this,'admin_settings'));
		add_action("load-$hook", array(&$this,'admin_enqueue'));
		add_filter( 'plugin_action_links', array(&$this,'add_plugin_config_link'), 10, 2 );
	}
	
	function add_plugin_config_link($links, $file) {
		static $this_plugin;
		if (!$this_plugin)
			$this_plugin = plugin_basename(__FILE__);
		if ($file == $this_plugin) {
			$settings_link = '<a href="tools.php?page=linkhopper.php">' . __('Configure') . '</a>';
			array_unshift( $links, $settings_link ); // before other links
		}
		return $links;
	}
	
	function admin_enqueue() {
		wp_enqueue_script('jquery-validate', ((is_ssl())?'https':'http').'://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.min.js', array('jquery'));
	}
	
	function admin_settings() {
		// Save Settings
		if (isset($_POST['SaveSettings'])) {
			if (!wp_verify_nonce($_POST['_wpnonce'], $this->nonce)) {	echo '<div class="updated"><p>Invalid security.</p></div>'."\n"; return; }
			// Sanitize POST data
			$_POST = stripslashes_deep($_POST);
			// Save Base URL
			if(substr($_POST['base_url'], 0, 1) == '/')		$_POST['base_url'] = substr($_POST['base_url'], 1);				// Remove leading slash
			if(substr($_POST['base_url'], -1) == '/')		$_POST['base_url'] = substr($_POST['base_url'], 0, -1);			// Remove trailing slash
			$this->opts['baseURL'] = $_POST['base_url'];
			// Start fresh
			$this->opts['hops'] = array();
			foreach ($_POST['hop_name'] as $id => $hop_name) {
				// Skip if both blank
				if (!$_POST['hop_name'][$id] && !$_POST['hop_url'][$id])	continue;
				// Strip slashes from start/end of hop name
				if(substr($hop_name, 0, 1) == '/')		$hop_name = substr($hop_name, 1);				// Remove leading slash
				if(substr($hop_name, -1) == '/')		$hop_name = substr($hop_name, 0, -1);			// Remove trailing slash
				// Add to array
				$this->opts['hops'][$hop_name] = $_POST['hop_url'][$id];
			}
			// Now go through Delete array and remove seleted
			if (is_array($_POST['hop_delete']))
			foreach ($_POST['hop_delete'] as $delete_key) {
				if (array_key_exists($delete_key, $this->opts['hops']))	unset($this->opts['hops'][$delete_key]);
			}
			// Now save changes, and show feedback
			$this->save_options();
			echo '<div class="updated"><p>Settings have been saved.</p></div>'."\n";
		}
		
		echo '<div class="wrap">'."\n";
		echo '<h2>LinkHopper Configuration</h2>'."\n";
		
		// Permalink warning
		if (!get_option('permalink_structure')) {
			echo '<div class="error">'.
				'<a href="options-permalink.php" class="button-secondary" style="float:right; margin:5px 5px 5px 25px;">Settings</a>'.
				'<p><strong>Warning</strong> - LinkHopper won\'t work unless you have a non-default permalink setting.</p>'.
				'</div>';
		}
		
		// Form Output
		?>
		<form class="plugin_settings metabox-holder" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
		<?php echo wp_nonce_field($this->nonce); ?>
        

<div class="postbox">
	<h3 class="hndle">Settings</h3>
	<div class="inside">
		<p class="baseurl"><label><span>Base URL</span>
        	/<input type="text" name="base_url" value="<?php echo esc_attr($this->opts['baseURL']); ?>" />/</label></p>
		<p class="description">Recommend you use a single word here, like "hop" or "out".</p>
	</div>
</div>

<table class="widefat">
	<thead><tr><th>Hop Name</th><th>Destination URL</th><th>Delete?</th><th><a class="button-secondary addrow">Add Row</a></th></tr></thead>
    <?php
	foreach ($this->opts['hops'] as $name => $desc) {
		$this->admin_linkhopper_row($name, $desc);
	}
	$this->admin_linkhopper_row();
	$this->admin_linkhopper_row();
	?>

</table>
<p style="padding:15px 0 15px 10em;"><input type="submit" class="button-primary" name="SaveSettings" value="Save Settings" /></p>
        
        </form>
        
<style><!--
.postbox h3.hndle, .postbox h3.hndle:hover { cursor:default; color:#464646; }
p.baseurl label span { display:block; width:6em; float:left; padding-top:4px; }
p.baseurl label input { width:6em; margin:0 4px; }
table td.name { width:10em; }
table td.delete, table td.test { width:5em; text-align:center; }
table td.delete label { display:block; width:100%; height:100%; }
--></style>
<script type="text/javascript"><!--
jQuery(document).ready(function($) {
	$('table.widefat a.addrow').click(function(e) {
		$(this).closest('table').find('tbody tr:last-child').clone().appendTo( row = $(this).closest('table').find('tbody') );
		$(this).closest('table').find('tbody tr:last-child input').val('');
	});
});
--></script>
        <?php
		echo '</div><!-- wrap -->'."\n";
	}
	
	function admin_linkhopper_row($name='', $destination='') {
		$delete_tickbox = (!$name) ? '&nbsp;' : '<label><input class="delete" type="checkbox" name="hop_delete[]" value="'.esc_attr($name).'" /></label>';
		$test_link = (!$name) ? '&nbsp;' : '<a target="blank" href="'.home_url().'/'.$this->opts['baseURL'].'/'.$name.'">Test</a>';
		
		?>
	<tr>
    	<td class="name"><input type="text" class="widefat" name="hop_name[]" value="<?php echo esc_attr($name); ?>" /></td>
    	<td class="desc"><input type="text" class="widefat" name="hop_url[]" value="<?php echo esc_attr($destination); ?>" /></td>
        <td class="delete"><?php echo $delete_tickbox; ?></td>
		<td class="test"><?php echo $test_link; ?></td>
    </tr>
        <?php
	}
	
}


?>