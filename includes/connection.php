<?php 

	class Connection {

		public function dbConnect() {
			//localhost:
			return new PDO("mysql:host=localhost; dbname=Banco_Novus", "root","",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		}

	}

?>