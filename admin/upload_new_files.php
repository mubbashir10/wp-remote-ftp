<?php

	//adding sub-menu item
	function upload_new_files_menu() {
			add_submenu_page('m10-remote-ftp-settings', 'M10 Remote FTP', 'Upload New Files', 'read', 'm10-remote-ftp-upload-new-files', 'display_upload_new_files_form');
	}
	add_action( 'admin_menu', 'upload_new_files_menu' );

	//upload new files screen
	function display_upload_new_files_form(){

	    echo "<div class='m10-backend-wrapper'>";
		echo "<img src='".plugin_dir_url( __FILE__ )."../resources/img/upload_new_files_icon.png' alt='' class='icon'><h1>Upload New Files</h1>";
		echo "<hr>";
	    echo "<p class='slogan'>here you can upload your files</p>";
	    echo "<div class='content'>";
	    echo "<h3>Instructions:</h3><br>";
	    echo "<ul>";
	    echo "<li>1) For multiple files (or files from single project) compress (.zip) your files and upload the compressed (.zip) file</li>";
	    echo "<li>2) Your filenames will be converted to lowercase</li>";
		echo "<li>3) Spaces in your filenames will be replaced by dashes</li>";
		echo "<li>4) Uploading files with same filenames will overwrite the previously uploaded files</li>";
		echo "<li>5) You can access all your files from <strong>Go Back to My Files</strong> tab</li>";
	    echo "</ul>";
	    echo "<br><br>";
		echo "<p><strong>Tip: </strong><a href='http://www.wikihow.com/Make-a-Zip-File' target='_blank'>click here to learn how you can make a compressed (.zip) file</a></p>";
		echo "<br><br>";
		echo "<form enctype='multipart/form-data' method='post'>";
		echo "<label><hr>Select Your File(s):</label>&nbsp;";
		echo "<input name='uploads[]' multiple='multiple' type='file' /><br><br>";
		echo "<a class='button light' href='admin.php?page=m10-remote-ftp-upload-my-files' style='float:right;'>&lt;&lt;Go Back to My Files</a>";
		echo "<input type='submit' name='u-btn' id='u-btn' class='button dark' value='Upload Files'>";
		echo "</form>";
		echo "</div>";
		echo "</div>";
		
	}

	//saving new file
	function save_new_file(){

		//getting data
		global $ftp_server;
		global $ftp_username;
		global $ftp_password;
		global $ftp_email;
		$user_id = get_current_user_id();
		$user_meta = get_user_meta($user_id);
		$user_directory = $user_meta['company_name'][0];
		$user_directory = preg_replace('/\s+/', '_', $user_directory);
		$user_directory	= strtolower($user_directory); 
		
		

		//handling post request
		if(isset($_POST['u-btn'])){

			//opening ftp connection
			$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
			$login = ftp_login($ftp_conn, $ftp_username, $ftp_password);

			//only upload if files are selected
			if(!empty($_FILES['uploads']['name'][0])){

				foreach ($_FILES['uploads']['name'] as $f => $name){

					//filenam
					$file = $_FILES["uploads"]["name"][$f];
					$file_u = preg_replace('/\s+/', '_', $file);
					$file_u = strtolower($file_u);

					//saving files
					$remote_file_path = $user_directory."/".$file_u;
					if(ftp_put($ftp_conn, $remote_file_path, $_FILES["uploads"]["tmp_name"][$f],FTP_ASCII))
						add_action('admin_notices', 'show_success_notice');
					else
						add_action('admin_notices', 'show_failure_notice');
				}	

				//closing ftp connection
				ftp_close($ftp_conn);

				//sending notification email to admin
				if (!current_user_can( 'administrator' )){
			        $to = $ftp_email;
			        $subject = 'New Files Uploaded at Swan Printing FTP';
			        $message = "Hello Admin,<br>
								<br>We hope you are doing really good. This email is sent to you to inform you that user <strong>'" .wp_get_current_user()->display_name . "'</strong> registered at Swan Printing website has uploaded new files.
								<br><br>Thanks!";
			        wp_mail( $to, $subject, $message, "Content-Type: text/html; charset=UTF-8\r\n");
			    }
			}
			else
				add_action('admin_notices', 'show_warning_notice');
		}
	}
	add_action('admin_init', 'save_new_file');

	//success notice
	function show_success_notice() {
    
	    echo "<div class='notice notice-success is-dismissible'>";
		echo "<p>";
		echo "Your files have been uploaded successfully!";
		echo "</p>";
		echo "</div>";
    
	}

	//warning notice
	function show_warning_notice() {
    
	    echo "<div class='notice notice-warning is-dismissible'>";
		echo "<p>";
		echo "No file selected. Please select some files to upload!";
		echo "</p>";
		echo "</div>";
    
	}

	//failure notice
	function show_failure_notice() {
    
	    echo "<div class='notice notice-error is-dismissible'>";
		echo "<p>";
		echo "Error occurred while uploading your files!";
		echo "</p>";
		echo "</div>";
    
	}

?>
