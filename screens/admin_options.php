<?php

	//adding menu item
	function m10_remote_ftp_menu(){
		add_menu_page( 'M10 Remote FTP', 'M10 Remote FTP', 'manage_options', 'm10-remote-ftp-settings', 'm10_remote_ftp_settings_page', 'dashicons-portfolio');
	}
	add_action( 'admin_menu', 'm10_remote_ftp_menu' );

	//registering options
	function register_m10_remote_ftp_settings(){
		register_setting( 'm10_remote_ftp_settings_group', 'ftp_server_name' );
		register_setting( 'm10_remote_ftp_settings_group', 'ftp_username' );
		register_setting( 'm10_remote_ftp_settings_group', 'ftp_password' );
	}
	add_action( 'admin_init', 'register_m10_remote_ftp_settings' );

	//settings screen
	function m10_remote_ftp_settings_page(){

		//checking permissions
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

	?>
		<!--settings page content-->
		<div class="m10-backend-wrapper">
			<img src="<?php echo (plugin_dir_url( __FILE__ ).'../resources/img/admin_options_icon.png') ?>" alt="" class="icon"><h1>M10 Remote FTP</h1>
			<hr>
			<p class='slogan'>simple registration and remote ftp file upload (v1.0)</p>
			<form method="post" action="options.php">
			    <?php settings_fields('m10_remote_ftp_settings_group'); ?>
			    <?php do_settings_sections('m10_remote_ftp_settings_group'); ?>
			    <div class="content grid grid-pad">
			    	<div class="col-1-2">
			    		<br><br>
					    <table class="form-table">
					        <tr valign="top">
						        <th scope="row">FTP Server Name</th>
						        <td><input type="text" name="ftp_server_name" value="<?php echo esc_attr( get_option('ftp_server_name') ); ?>" /></td>
					        </tr>
					        <tr valign="top">
						        <th scope="row">FTP Username</th>
						        <td><input type="text" name="ftp_username" value="<?php echo esc_attr( get_option('ftp_username') ); ?>" /></td>
					        </tr>
					        <tr valign="top">
						        <th scope="row">FTP Password</th>
						        <td><input type="password" name="ftp_password" value="<?php echo esc_attr( get_option('ftp_password')); ?>" /></td>
					        </tr>
					    </table>
				    <?php submit_button(); ?>
				    </div>
			    	<div class="signature col-1-2">
						<h2>Thank you!</h2>
						<p>Hello! I am Mubbashir10, professional Web Developer and UI/UX Designer. I would like to thank you for installing M10 Remote FTP plugin. This plugin is quite helpful if you want your users to upload data to a remote FTP Server.</p>
						<p>If you have any query related to the plugin or if you just want to say 'Hi' then please feel free to get in touch with me:</p>
						<p><strong>Web:</strong> <a href='http://mubbashir10.com'>mubbashir10.com</a><br>
						<strong>Email:</strong> <a href='mailto:mubbashir10@gmail.com'>mubbashir10@gmail.com</a><br>
			    	</div>
				</div>
			</form>
		</div>
<?php } ?>