<?php

/*
*	Plugin Name: IPlog
*	Description: Logs IP addresses and other access parameters
*	Version: 0.3
*	Author: Milos Milutinovic
*			https://github.com/miloske85
*/

	//installation
	include_once __DIR__.'/install.php';
	register_activation_hook(__FILE__,'install_db');

	//run the logging
	require_once(__DIR__.'/logger.php');

	$log = new \Miloske85\Iplog();
	$log->iplog();

	//add to admin menu
	add_action('wp_dashboard_setup','iplog_dashboard_info');

	function iplog_dashboard_info(){
		wp_add_dashboard_widget('iplog_info','Iplog Info','iplog_display_info');
	}

	function iplog_display_info(){
		$log = new \Miloske85\Iplog();
		echo'Total number of visits: ';
		echo $log->basicInfo();
	}

	