<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ijas.me/
 * @since      1.0.0
 *
 * @package    Wp_Admin_Columns_Organizer
 * @subpackage Wp_Admin_Columns_Organizer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Admin_Columns_Organizer
 * @subpackage Wp_Admin_Columns_Organizer/admin
 * @author     Jacob <jacob@ijas.me>
 */
class Wp_Admin_Columns_Organizer_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->options = get_option( 'wp_admin_columns_organizer' );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Admin_Columns_Organizer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Admin_Columns_Organizer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-admin-columns-organizer-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Admin_Columns_Organizer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Admin_Columns_Organizer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-admin-columns-organizer-admin.js', array( 'jquery' ), $this->version, false );

	}


	// USER REGISTERED
	
	/*function set_default_user_sort_registered( $current_screen ) {
		if ( $current_screen->id === 'users' && empty( $_REQUEST['orderby'] ) && empty( $_REQUEST['order'] ) ) {
			$_REQUEST['orderby'] = 'user_registered';
			$_REQUEST['order'] = 'desc';
		}
	}*/
	/*function filter_custom_column_users_registered( $output, $column_name = '', $user_id = 0 ) {
		if ( !empty( $column_name ) && $user_id !== 0 ) {
			if($column_name == 'user_registered') {
				$user = get_user_by('id',$user_id );
				$output = $user->user_registered;
			}
		}
		return $output;
	}*/
	
	// USER REGISTERED



	// USER ID
	/*function filter_custom_column_users( $output, $column_name = '', $user_id = 0 ) {
		if ( !empty( $column_name ) && $user_id !== 0 ) {
			if($column_name == 'userid') {
				$output = $user_id;
			}	
		}
		
		return $output;
	}*/

	/*function filter_columns_users( $columns ) {
		$columns['userid'] = 'User ID';
		return $columns;
	}*/
	// USER ID

	function add_extra_sortable_columns( $sortable_columns ) {
		$extra_user_columns = $this->options['extra_user_columns'];
		if ( !empty( $extra_user_columns ) ) {
			//$extra_user_columns = $this->options['extra_user_columns'];
			foreach ( $extra_user_columns  as $extra_column_index => $extra_column_name ) {
				if ( strpos( $extra_column_name, 'usermeta_' ) === false && strpos( $extra_column_name, 'bp_' ) === false ) {
					$sortable_columns[$extra_column_name] = $extra_column_name;
				}
			}
		}
		return $sortable_columns;
	}

	function filter_users_columns( $columns ) {
		$extra_user_columns = $this->options['extra_user_columns'];
		if ( !empty( $extra_user_columns ) ) {
			//$options = $this->options;
			foreach ( $extra_user_columns  as $extra_column_index => $extra_column_name ) {
				$extra_column_nice_name = str_replace( array( '_', '-', 'usermeta', 'bp' ), ' ', $extra_column_name  );
				//$extra_column_nice_name = str_replace( array( '_', '-', 'Usermeta' ), ' ', ucwords( $extra_column_name ) );
				$columns[$extra_column_name] = ucwords( $extra_column_nice_name );
			}
		}
		
		return $columns;
	}


	function set_default_user_sort( $current_screen ) {
		
		if ( $current_screen->id === 'users' && empty( $_REQUEST['orderby'] ) && empty( $_REQUEST['order'] ) ) {
			//$options = get_option( 'wp_admin_columns_organizer' );
			if ( $this->options['default_user_column_sort'] ) {
				$_REQUEST['orderby'] = $this->options['default_user_column_sort'];
				$sort_direction = !empty( $this->options['default_user_column_sort_direction'] ) ? $this->options['default_user_column_sort_direction'] : 'desc';
				$_REQUEST['order'] = $sort_direction;
			}
			
		}
	}
	function filter_custom_columns_values( $output, $column_name = '', $user_id = 0 ) {
		$user = get_user_by('id',$user_id );
		if($column_name == 'user_registered') {
			$output = $user->user_registered;
		}
		if($column_name == 'id') {
			$output = intval( $user_id );
		}
	
		if ( strpos( $column_name, 'usermeta_' ) !== false ) {
			$meta_key = str_replace('usermeta_', '', $column_name);
			$output = get_user_meta( $user_id, $meta_key, true );
		}
		if ( strpos( $column_name, 'bp_' ) !== false ) {
			$meta_key = str_replace('bp_', '', $column_name);
			$meta_key = str_replace('_', ' ', $meta_key );
			$output = xprofile_get_field_data( $meta_key, $user_id );
		}
		return $output;
	}

	function users_columns_settings( ) {
		add_users_page( 'Columns Organizer', 'Columns Organizer', 'read', 'users-columns-organizer', array( $this, 'users_columns_page') );
	}
	function users_columns_page() {
		include_once( __DIR__ . '/partials/wp-admin-user-columns-organizer-admin-display.php');
	}
	/*function meta_query_sort( $args ) {
		if ( strpos( 'usermeta_', $args->orderby ) !== false ) {
			$orderby = str_replace('usermeta_', '', $args->orderby);
			$args->orderby = 'meta_value';
			$args->meta_key = $orderby;
		}
		return $args;
	}*/

}
