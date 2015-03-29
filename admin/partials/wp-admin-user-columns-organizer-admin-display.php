<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://ijas.me/
 * @since      1.0.0
 *
 * @package    Wp_Admin_Columns_Organizer
 * @subpackage Wp_Admin_Columns_Organizer/admin/partials
 */

$nonce = $_REQUEST['user_columns_sort_nonce'];

$options = get_option( 'wp_admin_columns_organizer' );

if ( empty( $options ) ) {
	$options = array();
	$options['default_user_column_sort'] = 'none';
	$options['default_user_column_sort_direction'] = 'none';
	$options['extra_user_columns'] = array();
}
if ( wp_verify_nonce( $nonce, 'user_columns_sort_nonce' ) ) {
		
	$options['default_user_column_sort'] = $_POST['default_user_column_sort'];
	$options['extra_user_columns'] = $_POST['extra_user_columns'];
	$options['default_user_column_sort_direction'] = $_POST['default_user_column_sort_direction'];
	update_option( 'wp_admin_columns_organizer', $options );
}
else {
	$nonce = wp_create_nonce( 'user_columns_sort_nonce' );
}
	//print_r( $options );


global $wpdb;
// WordPress User Meta - distinct meta keys query
$distinct_user_meta = $wpdb->get_results( 'SELECT DISTINCT meta_key FROM '. $wpdb->prefix . 'usermeta');
foreach ( $distinct_user_meta as $user_meta ) {
	$extra_user_columns_user_meta[] = 'usermeta_'.$user_meta->meta_key;
}
// WordPress User Meta - distinct meta keys query

// BuddyPress XProfile Fields
$bp_xprofile_fields = $wpdb->get_results( 'SELECT name FROM '. $wpdb->prefix . 'bp_xprofile_fields WHERE parent_id = "0"');
foreach ( $bp_xprofile_fields as $xprofile_field ) {
	$xprofile_key = str_replace(' ', '_', $xprofile_field->name );
	$extra_user_columns_bp_xprofile_meta[] = 'bp_'.$xprofile_key;
}
// BuddyPress XProfile Fields

//$updated = $wpdb->query('UPDATE '.$wpdb->prefix.'usermeta SET meta_key="abeo_invite_code" WHERE meta_key="abeo_invite_system_invite_code"');
//echo $updated;
?>

<h1>User Columns Organizer</h1>

<form id="user_columns_sort_form" method="POST" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
	<label for="default_user_column_sort">Default Column Sort</label>
	<select name="default_user_column_sort">
		<?php $user_sort_columns = array( 'none', 'username', 'name', 'email' );
		if ( !empty( $options['extra_user_columns'] ) ) {
			$user_sort_columns = array_merge( $user_sort_columns, $options['extra_user_columns'] );
		}
		foreach ( $user_sort_columns as $column ) {
			if ( strpos($column, 'bp_') === false && strpos( $column, 'usermeta_') === false ) {
				$column_nice_name = str_replace(array('_', '-', 'usermeta', 'bp' ), ' ', $column);
				if ( $options['default_user_column_sort'] === $column ) {
					echo '<option value="'.$column.'" selected>'.ucwords($column_nice_name).'</option>';
				}
				else {
					echo '<option value="'.$column.'">'.ucwords($column_nice_name).'</option>';
				}	
			} 
			
		}
		?>
	</select>
	<br/>
	<label for="default_user_column_sort">Default Column Sort Direction</label>
	<select name="default_user_column_sort_direction">
		<option value="none" <?php if ( empty( $options['default_user_column_sort_direction'] ) || $options['default_user_column_sort_direction'] === 'none' ) echo 'selected' ?>>-----</option>
		<option value="asc" <?php if ( $options['default_user_column_sort_direction'] === 'asc' ) echo 'selected' ?>>Ascending</option>
		<option value="desc" <?php if ( $options['default_user_column_sort_direction'] === 'desc' ) echo 'selected' ?>>Descending</option>
	</select>
	<br /><br />
	<label for="extra_user_columns">Extra Columns</label>
	<br />
	<?php $user_extra_columns = array( 'id', 'user_registered' );
	$user_extra_columns = array_merge( $user_extra_columns, $extra_user_columns_user_meta );
	$user_extra_columns = array_merge( $user_extra_columns, $extra_user_columns_bp_xprofile_meta );

	foreach ( $user_extra_columns as $column ) {
		$column_nice_name = str_replace(array('_', '-', 'usermeta', 'bp' ), ' ', $column);
		//$column_nice_name = str_replace('Usermeta', '', $column_nice_name );
		//$column_nice_name = str_replace('userid', 'User ID', $column );
		$prefix = '';
		if ( strpos( $column, 'bp_') !== false ) {
			$prefix = 'BuddyPress Profile Meta - ';
		}
		if ( strpos( $column, 'usermeta_') !== false ) {
			$prefix = 'WordPress User Meta - ';
		}
		if ( in_array( $column, $options['extra_user_columns'] ) ) {
			echo '<input type="checkbox" name="extra_user_columns[]" value="'.$column.'" checked /> '. $prefix . ' ' . ucwords($column_nice_name).'<br/>';
		}
		else {
			echo '<input type="checkbox" name="extra_user_columns[]" value="'.$column.'" /> '. $prefix . ' ' . ucwords($column_nice_name).'<br/>';
		}
	}
	?>
	<br />
	<input type="hidden" name="user_columns_sort_nonce" value="<?php echo $nonce; ?>" />
	<input type="submit" name="submit_user_columns_sort_form" />
</form>