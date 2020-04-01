<?php 

	class Connection {

		public function dbConnect() {
			//localhost:
			return new PDO("mysql:host=localhost; dbname=banco_novus", "root","",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		}

	}

?>