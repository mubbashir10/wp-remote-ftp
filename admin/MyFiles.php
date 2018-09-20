<?php

namespace M10Plugin\WpRemoteFtp;

/**
 * Class MyFiles
 */
class MyFiles
{

	public function __construct()
	{
		$this->init();
	}
	
	public function init()
	{
		add_action ('admin_menu', [$this, 'wp_remote_ftp_my_files_menu']);
	}

	public function wp_remote_ftp_my_files_menu()
	{
		add_submenu_page('wp-remote-ftp', 'WP Remote FTP', 'My Files', 'read', 'wp-remote-ftp-my-files', [$this, 'wp_remote_ftp_my_files']);
	}

	public function wp_remote_ftp_my_files(){
		
		//getting data
		global $ftp_server;
		global $ftp_username;
		global $ftp_password;
		$del_action_file = plugin_dir_url(__FILE__) . '../includes/delete.php';
		$rename_action_file = plugin_dir_url(__FILE__) . '../includes/rename.php';
		$resources = plugin_dir_url(__FILE__) . '../resources';
		$user_id = get_current_user_id();
		$user_meta = get_user_meta($user_id);
		$user_directory = $user_meta['company_name'][0];
		$user_directory = preg_replace('/\s+/', '_', $user_directory);
		$user_directory = strtolower($user_directory);
			
			//opening ftp connection
		$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
		$login = ftp_login($ftp_conn, $ftp_username, $ftp_password);

			//getting all files
		$filelist = ftp_nlist($ftp_conn, $user_directory);
		sort($filelist);

			//indexing
		if (isset($_GET['m10p'])) {
			$index_start = (15 * $_GET['m10p']);
		} else {
			$index_start = 0;
		}
		$index_end = $index_start + 15;

			//counting and slicing
		$file_count_total = count($filelist);
		$total_pages = ceil(($file_count_total) / (15));
		$filelist = array_slice($filelist, $index_start, $index_end, false);
		$file_count_page = count($filelist);

			//content
		echo "<div class='m10-backend-wrapper'>";
		echo "<img src='" . plugin_dir_url(__FILE__) . "../resources/img/my_files_icon.png' alt='' class='icon'><h1>My Files</h1>";
		echo "<hr>";
		echo "<p class='slogan'>here you can access all your files</p>";
		echo "<div class='content'>";
		echo "<div class='action-header'>";
		echo "<a class='button light' href='admin.php?page=m10-remote-ftp-upload-new-files'>Upload New Files</a>";
		echo "<a class='button grey' onclick=selectAllFiles()>Select All Files</a>";
		echo "<a class='button colored' onclick='deselectAllFiles()'>Deselect All Files</a>";
		echo "<a class='button dark' onclick=deleteSelectedFiles('" . $del_action_file . "','" . $user_directory . "','" . $ftp_server . "','" . $ftp_username . "','" . $ftp_password . "','" . $resources . "')>Delete Selected Files</a>";
		echo "</div>";
		echo "<h3>Instructions:</h3>";
		echo "<ul>";
		echo "<li>1) Double click a filename to rename it</li>";
		echo "<li>2) Delete individual files by pressing the respective delete button</li>";
		echo "<li>3) To delete multiple files, select desired files and hit 'Delete Selected Files' button</li>";
		echo "<li>4) You can upload new files by going to <strong>Upload New Files</strong> tab</li>";
		echo "</ul>";
		echo "<br>";

			//files table
		if ($file_count_total > 0) {

			echo "<table class='files-list-table'>";
			echo "<tr>
							<th>Select</th>
							<th>Filename</th>
							<th>Actions</th>
						</tr>";
			for ($i = 0; $i < $file_count_page; $i++) {
				$filelist[$i] = str_replace($user_directory . "/", "", $filelist[$i]);
				echo "<tr>";
				echo "<td><input class='selected_files' type='checkbox' name='selected_files[]' value=" . $filelist[$i] . "></td>";
				echo "<td><input class='filename' ondblclick=renameFile('" . $rename_action_file . "','" . $user_directory . "','" . $filelist[$i] . "','" . $ftp_server . "','" . $ftp_username . "','" . $ftp_password . "','" . $resources . "') value=" . $filelist[$i] . " readonly></td>";
				echo "<td><button onclick=deleteFile('" . $del_action_file . "','" . $user_directory . "','" . $filelist[$i] . "','" . $ftp_server . "','" . $ftp_username . "','" . $ftp_password . "','" . $resources . "',1)>Delete</button></td>";
				echo "</tr>";
			}

			echo "</table>";
				
				//pagination
			echo "<div class='files-pagination'>";
			for ($i = 0; $i < $total_pages; $i++) {
				?>	
					<a class="button grey <?php if ($i == $_GET['m10p']) {
																											echo 'dark';
																										} ?>" style="color:#f1f1f1;" href="admin.php?page=m10-remote-ftp-upload-my-files&m10p=<?php echo $i; ?>"><?php echo ($i + 1); ?></a>
				<?php

		}
		echo "</div>";


	} else {
		_e("You haven't uploaded any file yet.", "textdomain");
	}

	echo "</div>";
	echo "</div>";

			//closing ftp connection
	ftp_close($ftp_conn);
	}
}
?>
