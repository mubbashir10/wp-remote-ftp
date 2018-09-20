<?php

namespace M10Plugin\WpRemoteFtp;

/**
 * Class: Options
 */
class Options
{
	/**
	 * ftp remote server address
	 */
	protected $server;
	/**
	 * ftp username
	 */
	protected $username;
	/**
	 * ftp password
	 */
	protected $password;

	public function __construct()
	{
		$this->init();
	}

	/**
	 * bind plugin to admin hooks
	 */
	public function init()
	{

		/**
		 * It runs after the basic admin panel menu structure is in place.
		 * It is used to add menus and sub menus
		 * https://codex.wordpress.org/Plugin_API/Action_Reference/admin_menu
		 */
		add_action('admin_menu', [$this, 'wp_remote_ftp_add_menu']);

		/**
		 * It runs when admin dashboard is accessed
		 * https://codex.wordpress.org/Plugin_API/Action_Reference/admin_init
		 */
		add_action('admin_init', [$this, 'wp_remote_ftp_register_admin_options']);

		/**
		 * It is used to include js/css
		 * https://codex.wordpress.org/Plugin_API/Action_Reference/admin_head
		 */
		add_action('admin_head', [$this, 'wp_remote_ftp_load_assets']);
	}

	/**
	 * adding scripts and styles
	 * https://developer.wordpress.org/reference/functions/wp_enqueue_style/
	 */
	public function wp_remote_ftp_load_assets(){
		wp_enqueue_style('wp-remote-ftp-grid', WP_REMOTE_FTP_PLUGIN_URL.'assets/css/grid.css');
		wp_enqueue_style('wp-remote-ftp-css', WP_REMOTE_FTP_PLUGIN_URL.'assets/css/style.css');
		wp_enqueue_script('wp-remote-ftp-js-script', WP_REMOTE_FTP_PLUGIN_URL.'assets/js/script.js', array( 'jquery' ) );
	}
		
	/**
	 * Actual wordpress dashboard admin entrymenu entry
	 * https://developer.wordpress.org/reference/functions/add_menu_page/
	 */
	public function wp_remote_ftp_add_menu()
	{
		add_menu_page('WP Remote FTP', 'WP Remote FTP', 'manage_options', 'wp-remote-ftp', [$this, 'wp_remote_ftp_admin_options'], 'dashicons-networking');
	}
	

	/**
	 * register wp admin options
	 * https://developer.wordpress.org/reference/functions/register_setting/
	 */
	public function wp_remote_ftp_register_admin_options()
	{
		register_setting('wp_remote_ftp_login_details', 'ftp_server');
		register_setting('wp_remote_ftp_login_details', 'ftp_username');
		register_setting('wp_remote_ftp_login_details', 'ftp_password');
	}
	
	/**
	 * admin options page
	 */
	public function wp_remote_ftp_admin_options()
	{
		/**
		 * minimum permission required to set options
		 * from admin dashboard
		 */
		if (!current_user_can('manage_options'))
			wp_die(__('You do not have sufficient permissions to access this page.'));
	?>
		<!--settings page content-->
		<div class="m10-backend-wrapper">
			<img src="<?php echo (WP_REMOTE_FTP_PLUGIN_URL.'assets/img/admin_options_icon.png') ?>" alt="" class="icon"><h1>M10 Remote FTP</h1>
			<hr>
			<p class='slogan'>a simple plugin to handle files on remote server via ftp (version <?php echo WP_REMOTE_FTP_VERSION; ?>)</p>
			<form method="post" action="options.php">
				<?php settings_fields('wp_remote_ftp_login_details'); ?>
				<?php do_settings_sections('wp_remote_ftp_login_details'); ?>
				<div class="content grid grid-pad">
					<div class="col-1-2">
						<br><br>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">FTP Server Name</th>
								<td><input type="text" name="ftp_server" value="<?php echo esc_attr(get_option('ftp_server')); ?>" /></td>
							</tr>
							<tr valign="top">
								<th scope="row">FTP Username</th>
								<td><input type="text" name="ftp_username" value="<?php echo esc_attr(get_option('ftp_username')); ?>" /></td>
							</tr>
							<tr valign="top">
								<th scope="row">FTP Password</th>
								<td><input type="password" name="ftp_password" value="<?php echo esc_attr(get_option('ftp_password')); ?>" /></td>
							</tr>
						</table>
					<?php submit_button(); ?>
					</div>
					<div class="signature col-1-2">
						<h2>Thank you!</h2>
						<p>Hello! I am Mubbashir10, professional Web Developer and UI/UX Designer. I would like to thank you for installing M10 Remote FTP plugin. This plugin is quite helpful if you want your users to upload data to a remote FTP Server.</p>
						<p>If you have any query related to the plugin or if you just want to say 'Hi' then please feel free to get in touch with me:</p>
						<p><strong>Web:</strong> <a href='http// mubbashir10.com'>mubbashir10.com</a><br>
						<strong>Email:</strong> <a href='mailto:mubbashir10@gmail.com'>mubbashir10@gmail.com</a><br>
					</div>
				</div>
			</form>
		</div>
	<?php
	}

	/**
	 * attempt login with ftp credentials
	 */
	public function wp_remote_ftp_login()
	{	
		$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
		$login = ftp_login($ftp_conn, $ftp_username, $ftp_password);
	}
}
	