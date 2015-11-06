<?php
	require_once(ABSPATH.'/wp-admin/includes/upgrade.php');

	function install_db(){

		create_log();
		create_pages();
		create_ua();
	}

	/**
	*	Creates table __iplog_log
	*/
	function create_log(){
		global $wpdb;

		$table_name = $wpdb->prefix.'iplog_log';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			page_id int(6) UNSIGNED NOT NULL,
			date int(10) NOT NULL,
			ua int(6) NOT NULL,
			ref varchar(1000) NOT NULL,
			ip varchar(60) NOT NULL,
			comment varchar(500) NULL,
			PRIMARY KEY (id)
		) $charset_collate;";

		dbDelta($sql);
	}

	/**
	*	Creates table __iplog_pages
	*/
	function create_pages(){
		global $wpdb;

		$table_name = $wpdb->prefix.'iplog_pages';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
			site_id int(5) UNSIGNED NULL,
			name varchar(50) NULL,
			location varchar(500) NOT NULL,
			version varchar(50) NULL,
			comment varchar(500) NULL,
			PRIMARY KEY (id)
		) $charset_collate;";

		dbDelta($sql);
	}

	/**
	*	Creates table __iplog_ua (for storing user agent info)
	*/
	function create_ua(){
		global $wpdb;

		$table_name = $wpdb->prefix.'iplog_ua';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
			ua varchar(500) NOT NULL,
			comment varchar(200) NULL,
			PRIMARY KEY (id)
		) $charset_collate;";

		dbDelta($sql);
	}