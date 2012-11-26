<?php
class auscode_class{
	
	function auscode_class(){
	}
	
	/**
	 * Install plugin on plugin activation
	 */
	function install() {
		global $wpdb;
	
			if( $wpdb->get_var("SHOW TABLES LIKE '".AUSCODE_DB."'") != AUSCODE_DB ) {
				$sql ="CREATE TABLE ".AUSCODE_DB." (
						  PCode varchar(5) NOT NULL default '',
						  Locality varchar(30) NOT NULL default '',
						  State varchar(5) default '' NULL,
						  Comments varchar(19) default '' NULL,
						  DeliveryOffice varchar(14) default '' NULL,
						  PresortIndicator varchar(16) default '' NULL,
						  Parcelzone varchar(10) default '' NULL,
						  BSPnumber varchar(9) default '' NULL,
						  BSPname varchar(8) default '' NULL,
						  Category varchar(50) default '' NULL,
						  PRIMARY KEY (PCode,Locality) );";
				$wpdb->query($sql);
				$filename = AUSCODE_Path . "addons/mysql.sql";
				$handle = fopen($filename, "r");
				if ($handle) {
					while (!feof($handle)) {
						$buffer = fgets($handle, 4096);
						$newtext = str_replace("INSERT INTO geo_pcode_au", "INSERT INTO ". AUSCODE_DB, $buffer );
						$wpdb->query($newtext);
					}
				fclose($handle);
				}
			}
	}
	
	
	function get_locality_list( $suburb ){
		global $wpdb;
		$local=array();
		$localities = $wpdb->get_results( "SELECT Locality as value, PCode as id, State as state FROM ".AUSCODE_DB." WHERE Locality LIKE '".$suburb."%' GROUP BY Locality" );
		foreach ( $localities as $locality ) {
			array_push( $local, array('value' => ucfirst( strtolower($locality->value) ), 'id' => $locality->id, 'state' => $locality->state ) );
		}
		return $local;
	}


	/**
	 * Uninstall plugin on plugin activation
	 */
	function uninstall() {
		global $wpdb;
		if($wpdb->get_var("SHOW TABLES LIKE '".AUSCODE_DB."'") == AUSCODE_DB ) {
			$sql = "DROP TABLE ". AUSCODE_DB ." ";
			$wpdb->query($sql);
		}
	}


}

?>