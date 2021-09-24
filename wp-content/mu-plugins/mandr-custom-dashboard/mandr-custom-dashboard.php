<?php
/**
 * Plugin Name: M&R Group Custom Dashboard
 * Plugin URI: http://www.mandr-group.com
 * Description: Removes unnecessry dashboard widgets and adds custom M&R newsfeed widget to all M&R developed websites
 * Version: 1.0.3
 * Author: Josh Mallard & Will Hawthorne
 * Author URI: http://www.mandr-group.com
 */
 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
class MandR_Dashboard {
	
	/**
	 * Plugin version for cache busting
	 */
	const VERSION = '1.0.3';
	
	/**
	 * Unique identifier
	 */
	protected $plugin_slug = 'mandr_custom_dash';
	
	/**
	 * Instance of this class
	 */
	protected static $instance = null;
	
	/**
	 * Return an instance of this class.
	 */
	public static function get_instance() {
	
	// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	
	/**
	 * Initiate plugin by getting the custom dashboard functions
	 */
	private function __construct() {
		
		/**
		 * Enqueue the styling for the M&R feed
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'rss_feed_style' ) );
		
		/**
		 * Hook the dashboard widget functions to the dashboard setup hook
		 */
		add_action( 'wp_dashboard_setup', array( $this, 'clean_dashboard' ) );
		add_action( 'wp_dashboard_setup', array( $this, 'mandr_dashboard_feed' ) );
		add_filter( 'admin_footer_text', array( $this, 'mandr_admin_footer' ) );
	}
	
	/**
	 * Removes unneeded dashboard widgets for a cleaner admin experience
	 */
	public function clean_dashboard() {
		
		// Normal
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
		
		// Side
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
		
	}
	
	/**
	 * Builds and sets up the M&R feed built by William Haun
	 */
	public function mandr_dashboard_feed() {
		
		add_meta_box( 'mandrfeed_widget', 'Latest News from M&R Marketing', array($this, 'mandr_dashboard_feed_build'), 'dashboard', 'normal', 'high' );
	
	}
	
	/** 
	 * M&R feed built by William Haun
	 */
	public function mandr_dashboard_feed_build() {

		$rss = fetch_feed('https://www.mandr-group.com/feed/');

		if (!is_wp_error($rss)) { // Checks that the object is created correctly
    		// Figure out how many total items there are, but limit it to 3.
   			$maxitems = $rss->get_item_quantity(5);
    		// Build an array of all the items, starting with element 0 (first element).
    		$rss_items = $rss->get_items(0, $maxitems);
		}

		if (!empty($maxitems)) {
		?>
    		<div class="rss-widget">
       			<ul>
					<?php
    				// Loop through each feed item and display each item as a hyperlink.
    				foreach ($rss_items as $item) {
 					?>
            			<li><a class="rsswidget" href='<?php echo $item->get_permalink(); ?>'><?php echo $item->get_title(); ?></a> <span class="rss-date"><?php echo $item->get_date('j F Y'); ?></span></li>
					<?php } ?>
                    	<li><a class="button" href="https://www.mandr-group.com/blog/" target="_blank"> More from M&R &raquo;</a></li>
        		</ul>
    		</div>
		<?php
		}
	}
	
	/**
	 * Change footer credits
	 */	
	public function mandr_admin_footer() {
		echo 'Thank you for creating your web site with <a href="https://www.mandr-group.com/" target="_blank">M&amp;R Marketing</a>';
	}
	
	/**
	 * Setup admin rss style to be enqueued
	 */
	public function rss_feed_style() {
		wp_enqueue_style( 'rss-style', plugins_url( 'assets/admin/admin.css', __FILE__ ));	
	}
}

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
	add_action( 'plugins_loaded', array( 'MandR_Dashboard', 'get_instance' ) );
}