<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://ijas.me/
 * @since      1.0.0
 *
 * @package    Wp_Admin_Columns_Organizer
 * @subpackage Wp_Admin_Columns_Organizer/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Admin_Columns_Organizer
 * @subpackage Wp_Admin_Columns_Organizer/includes
 * @author     Jacob <jacob@ijas.me>
 */
class Wp_Admin_Columns_Organizer {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Admin_Columns_Organizer_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'wp-admin-columns-organizer';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_Admin_Columns_Organizer_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_Admin_Columns_Organizer_i18n. Defines internationalization functionality.
	 * - Wp_Admin_Columns_Organizer_Admin. Defines all hooks for the admin area.
	 * - Wp_Admin_Columns_Organizer_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-admin-columns-organizer-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-admin-columns-organizer-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-admin-columns-organizer-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-admin-columns-organizer-public.php';

		$this->loader = new Wp_Admin_Columns_Organizer_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Admin_Columns_Organizer_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wp_Admin_Columns_Organizer_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wp_Admin_Columns_Organizer_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		//add_filter( "manage_{$this->screen->id}_columns", array( $this, 'get_columns' ), 0 );
		//		$views = apply_filters( "views_{$this->screen->id}", $views );
		//			$this->_actions = apply_filters( "bulk_actions-{$this->screen->id}", $this->_actions );
		//		$_sortable = apply_filters( "manage_{$this->screen->id}_sortable_columns", $sortable_columns );
		//			$actions = apply_filters( 'user_row_actions', $actions, $user_object );
		//					$r .= apply_filters( 'manage_users_custom_column', '', $column_name, $user_object->ID );

		// USER ID
		
		//$this->loader->add_filter( 'manage_users_columns', $plugin_admin, 'filter_columns_users' );
		//add_filter( 'manage_users_columns', 'filter_columns_users', 10, 1 );
		//$this->loader->add_filter( 'manage_users_custom_column', $plugin_admin, 'filter_custom_column_users', 10, 3 );
		//add_filter( 'manage_users_custom_column', 'filter_custom_column_users', 10, 3 );
		//add_action( 'current_screen', 'set_default_user_sort' );
		
		// USER ID


		// USER REGISTERED
		
		//$this->loader->add_filter( 'manage_users_columns', $plugin_admin, 'filter_columns_users_registered' );
		//add_filter( 'manage_users_columns', 'filter_columns_users_registered', 10, 1 );
		
		//$this->loader->add_filter( 'manage_users_custom_column', $plugin_admin, 'filter_custom_column_users_registered', 10, 3 );
		//add_filter( 'manage_users_custom_column', 'filter_custom_column_users_registered', 10, 3 );
		
		//$this->loader->add_action( 'current_screen', $plugin_admin, 'set_default_user_sort_registered' );
		//add_action( 'current_screen', 'set_default_user_sort_registered' );
		//$this->loader->add_filter( 'manage_users_sortable_columns', $plugin_admin, 'add_registerd_to_sortable_columns' );
		
		//add_filter( "manage_users_sortable_columns", 'add_registerd_to_sortable_columns' ,10,1 );

		// USER REGISTERED
		$this->loader->add_action( 'current_screen', $plugin_admin, 'set_default_user_sort' );
		$this->loader->add_filter( 'manage_users_sortable_columns', $plugin_admin, 'add_extra_sortable_columns' );
		$this->loader->add_filter( 'manage_users_columns', $plugin_admin, 'filter_users_columns' );
		$this->loader->add_filter( 'manage_users_custom_column', $plugin_admin, 'filter_custom_columns_values', 10, 3 );


		$this->loader->add_action( 'admin_menu', $plugin_admin, 'users_columns_settings' );
		
		//$this->loader->add_filter( 'pre_user_query', $plugin_admin, 'meta_query_sort', 10, 1 );
		
		//do_action_ref_array( 'pre_user_query', array( &$this ) );
		//
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_Admin_Columns_Organizer_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wp_Admin_Columns_Organizer_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
