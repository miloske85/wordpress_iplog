<?php
	namespace Miloske85;

	class Iplog{

		/**
		*	Returns basic info for display in the Dashboard
		*/
		public function basicInfo(){
			global $wpdb;
			$table = $wpdb->prefix.'iplog_log';
			$count = $wpdb->get_var("SELECT COUNT(id) FROM $table");
			
			return $count;
		}

		/**
		*	Performs logging
		*/
		public function iplog(){
			$date = time(); 
			$ua = $_SERVER['HTTP_USER_AGENT'];  
			$ip = $_SERVER['REMOTE_ADDR']; 
			$referer = $_SERVER['HTTP_REFERER'];

			$uri = $_SERVER['REQUEST_URI'];

			//see if URI already in the db, if not insert it; get id in any case

			global $wpdb;
			$table = $wpdb->prefix.'iplog_pages';
			$sql = $wpdb->prepare("SELECT id FROM $table WHERE location=%s", $uri);
			$id = $wpdb->get_var($sql);

			if(!$id){
				$id = $this->insertUri($uri);
			}

			//get UA ID

			$table = $wpdb->prefix.'iplog_ua';
			$sql = $wpdb->prepare("SELECT id FROM $table WHERE ua=%s",$ua);
			$ua_id = $wpdb->get_var($sql);

			if(!$ua_id){
				$ua_id = $this->insertUA($ua);
			}			

			//log access params
			$acc_params = array(
				'page_id' => $id,
				'date' => $date,
				'ua' => $ua_id,
				'ref' => $referer,
				'ip' => $ip
			);
			$wpdb->insert($wpdb->prefix.'iplog_log', $acc_params);

			#var_dump($id);
		}

		/**
		*	Insert new URI entry
		*	@param string $uri URI
		*	@returns int insert id
		*/
		protected function insertUri($uri){
			global $wpdb;
			$wpdb->insert($wpdb->prefix.'iplog_pages',array('location' => $uri));

			return $wpdb->insert_id;
		}

		/**
		*	Insert User Agent string if not present in the table
		*	@param string $ua User Agent
		*	@returns int User Agent ID
		*/

		protected function insertUA($ua){
			global $wpdb;
			
			$wpdb->insert($wpdb->prefix.'iplog_ua',array('ua' => $ua));

			return $wpdb->insert_id;
		}

	}