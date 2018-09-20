<?php

    namespace M10Plugin;

    /**
    * Plugin Name: WP Remote FTP
    * Plugin URI: http://mubbashir10.com/projects/plugins/wp-remote-ftp
    * Description: Wordpress plugin which lets you connect to a remote ftp server and manage files.
    * Version: 2.0.0
    * Author: Mubbashir10
    * Author URI: https://mubbashir10.com
    */

    /**
     * package wide constants
     */
    define('WP_REMOTE_FTP_VERSION', '2.0.0');
    define('WP_REMOTE_FTP_MIN_WP_VERSION', '3.0');
    define('WP_REMOTE_FTP_PLUGIN_PATH', plugin_dir_path(__FILE__));
    define('WP_REMOTE_FTP_PLUGIN_URL', plugin_dir_url( __FILE__ ));



    
    /**
     * including modules
     */
    require (WP_REMOTE_FTP_PLUGIN_PATH.'/admin/Options.php');
    require (WP_REMOTE_FTP_PLUGIN_PATH.'/admin/MyFiles.php');

    $wp_remote_ftp = new WpRemoteFtp\Options();

    // attempt login
    $wp_remote_ftp->wp_remote_ftp_login();

    $wp_remote_ftp_files = new WpRemoteFtp\MyFiles();
    














