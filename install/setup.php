<?php
    $hostname = $_POST['hostname'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$database = $_POST['database'];

	$user_username = $_POST['user_username'];
	$user_password = $_POST['user_password'];
	$user_password = md5($user_password);
    
    $dsn = "mysql:host=".$hostname.";dbname=".$database;
    try{
		$PDOdb = new PDO($dsn, $username, $password);
		//echo "MySQL Connected!";
	}catch(PdoException $e){
		$error_message = $e->getMessage();
		echo 'con-error';
		return;
	}
	
	function GenerateUserId($RandomIdlength){
		$RandomId = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWabcdefghijklmnopqrstuvwqyz"), 0, $RandomIdlength);
		return $RandomId;
	}
	$UserId = GenerateUserId(40);
	
	$pdoResult_Pages = $PDOdb->prepare("
		CREATE TABLE IF NOT EXISTS `pages` (
			`Id` varchar(50) NOT NULL,
			`Url` varchar(100) CHARACTER SET utf8 NOT NULL,
			`Title` varchar(100) CHARACTER SET utf8 NOT NULL,
			`Contents` text CHARACTER SET utf8 NOT NULL,
			PRIMARY KEY (`Id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
	");
	$pdoExec_Pages = $pdoResult_Pages->execute();
	
	$Contents = '<p>Simple Docs is a easy to setup and manage documentation system.<br />All u need is a&nbsp;<a href="https://www.php.net/">php</a> server and <a href="https://www.mysql.com/">mysql</a> database.<br /><br /></p><p><strong>Features:</strong></p><ul><li>User management</li><li>Custom pages</li><li>Custom side menu</li><li>Custom colors</li></ul><p>&nbsp;</p><p>Thanx for using Simple Docs.<br /><img src="https://www.google.nl/url?sa=i&amp;url=https%3A%2F%2Fgfycat.com%2Fstickers%2Fsearch%2Fthx%2Bty&amp;psig=AOvVaw01oPo74v4gskikX2zR4CDR&amp;ust=1607442156572000&amp;source=images&amp;cd=vfe&amp;ved=0CAIQjRxqFwoTCOCAsuiavO0CFQAAAAAdAAAAABAJ" alt="" /><img src="https://thumbs.gfycat.com/ImmenseWellmadeCapeghostfrog-size_restricted.gif" alt="" width="413" height="250" /></p>';
	$pdoResult_InsertDefaultPage = $PDOdb->prepare("
		INSERT INTO `pages` (`Id`, `Url`, `Title`, `Contents`) VALUES (:Id, :Url, :Title, :Contents);
	");
	$pdoExec_InsertDefaultPage = $pdoResult_InsertDefaultPage->execute(array(":Id" => GenerateUserId(30),":Url" => 'default', ":Title" => 'Welcome to Simple Docs', ":Contents" => $Contents));
	
	$pdoResult_MenuItems = $PDOdb->prepare("
		CREATE TABLE IF NOT EXISTS `menuitems` (
			`Id` varchar(50) NOT NULL,
			`Title` varchar(50) NOT NULL,
			`Page` varchar(50) NOT NULL,
			`Level` varchar(50) NOT NULL,
			`Order` int(11) NOT NULL,
			`NewCat` varchar(5) NOT NULL,
			PRIMARY KEY (`Id`)
	  	) ENGINE=InnoDB DEFAULT CHARSET=latin1;
	");
	$pdoExec_MenuItems = $pdoResult_MenuItems->execute();
	
	$pdoResult_Users = $PDOdb->prepare("
		CREATE TABLE IF NOT EXISTS `users` (
			`Id` varchar(50) NOT NULL,
			`Username` varchar(100) NOT NULL,
			`Password` varchar(100) NOT NULL,
			PRIMARY KEY (`Id`)
	  	) ENGINE=InnoDB DEFAULT CHARSET=latin1;
	");
	$pdoExec_Users = $pdoResult_Users->execute();
	
	$pdoResult_InsertUsers = $PDOdb->prepare("
		INSERT INTO `users` (`Id`, `Username`, `Password`) VALUES (:userid, :username, :password);
	");
	$pdoExec_InsertUsers = $pdoResult_InsertUsers->execute(array(":userid" => $UserId, ":username" => $user_username, ":password" => $user_password));

	$pdoResult_Settings = $PDOdb->prepare("
		CREATE TABLE IF NOT EXISTS `settings` (
			`Id` int(11) NOT NULL AUTO_INCREMENT,
			`TitleColor` varchar(100) NOT NULL,
			`SubTitleColor` varchar(100) NOT NULL,
			`MenuBGColor` varchar(100) NOT NULL,
			`PageBGColor` varchar(100) NOT NULL,
			`MenuLevel0Color` varchar(100) NOT NULL,
			`MenuLevel1Color` varchar(100) NOT NULL,
			`MenuLevel2Color` varchar(100) NOT NULL,
			`MenuLevel3Color` varchar(100) NOT NULL,
			`MenuLevel4Color` varchar(100) NOT NULL,
			`MenuLevel5Color` varchar(100) NOT NULL,
			`TitleText` varchar(100) NOT NULL,
			`SubTitleText` varchar(100) NOT NULL,
			`TabTitleText` varchar(100) NOT NULL,
			`LoginLinkText` varchar(100) NOT NULL,
			`TinyMCEKey` varchar(100) NOT NULL,
			PRIMARY KEY (`Id`)
	  	) ENGINE=InnoDB DEFAULT CHARSET=latin1;
	");
	$pdoExec_Settings = $pdoResult_Settings->execute();

	$pdoResult_InsertSettings = $PDOdb->prepare("
		INSERT INTO `settings` (`Id`, `TitleColor`, `SubTitleColor`, `MenuBGColor`, `PageBGColor`, `MenuLevel0Color`, `MenuLevel1Color`, `MenuLevel2Color`, `MenuLevel3Color`, `MenuLevel4Color`, `MenuLevel5Color`, `TitleText`, `SubTitleText`, `TabTitleText`, `LoginLinkText`, `TinyMCEKey`) VALUES 
			(NULL, '#000000', '#000000', '#ffffff', '#ffffff', '#000000', '#000000', '#000000', '#000000', '#000000', '#000000', 'Simple Docs', 'A simple to manage documentation system', 'Simple Docs', 'Login', '');
	");
	$pdoExec_InsertSettings = $pdoResult_InsertSettings->execute();
	
	if($pdoExec_Pages && $pdoExec_InsertDefaultPage && $pdoExec_MenuItems && $pdoExec_Settings && $pdoExec_InsertSettings && $pdoExec_Users && $pdoExec_InsertUsers){
			$dbconfig = '<?php
	$hostname = "'.$hostname.'";
	$username = "'.$username.'";
	$password = "'.$password.'";
	$database = "'.$database.'";
?>
			';
			$file = file_put_contents("../config.php", $dbconfig);
			if($file){
				echo 'success';
			}else{
				echo 'file-error';
			}
	}else{
		echo 'create-error';
	}