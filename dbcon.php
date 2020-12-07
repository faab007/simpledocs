<?php
	include 'config.php';
	
	$dsn = "mysql:host=".$hostname.";dbname=".$database;
	
	try{
		$PDOdb = new PDO($dsn, $username, $password);
		//echo "MySQL Connected!";
	}catch(PdoException $e){
		$error_message = $e->getMessage();
		echo '
		<div style="background-color: rgba(255,0,0,0.8); position: absolute; top: 0px; left: 0px; bottom:0px; right: 0px; z-index: 5000; cursor: wait;">
			<div style="position: absolute;top: 25%; left: 10%;font-size: 50px; width:80%; color: white;">
				<p style="text-align: center;">Can`t connect to DataBase<br/>Please contact the system administrator</p>
			</div>
		</div>';
	}
?>