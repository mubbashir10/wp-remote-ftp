<?php
/*
Plugin Name: M10 Remote FTP
Plugin URI: http://mubbashir10.com/projects/plugins/m10-remote-ftp
Description: This simple yet powerful plugin allows your users to register to your WordPress website and let them upload files to some remote FTP server.
Version: 2.0
Author: Mubbashir10
Author URI: https://mubbashir10.com
*/

//getting options values
$ftp_server					= get_option('ftp_server_name');
$ftp_username				= get_option('ftp_username');
$ftp_password				= get_option('ftp_password');
$ftp_email					= get_option('ftp_email');

//loading plugin assests
function load_plugin_assets(){
    wp_enqueue_style('m10-grid',plugin_dir_url( __FILE__ ).'/resources/css/grid.css');
    wp_enqueue_style('m10-css',plugin_dir_url( __FILE__ ).'/resources/css/style.css');
    wp_enqueue_script('m10-js-script', plugin_dir_url( __FILE__ ).'/resources/js/script.js', array( 'jquery' ) );
}
add_action('admin_head', 'load_plugin_assets');

//adding backend options page
require ('screens/admin_options.php');
require ('screens/my_files.php');
require ('screens/upload_new_files.php');















