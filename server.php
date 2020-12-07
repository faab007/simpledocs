<?php
    include 'dbcon.php';
    session_start();

    if(isset($_GET['methode'])){
		$methode = $_GET['methode'];
	}else{
		$methode = "";
    }
    
    function GenerateUserId($RandomIdlength){
		include('dbcon.php');
		$RandomId = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWabcdefghijklmnopqrstuvwqyz"), 0, $RandomIdlength);
		$pdoResult_Id = $PDOdb->prepare("SELECT * FROM users WHERE Id=:Id");
		$pdoExec_Id = $pdoResult_Id->execute(array(":Id"=>$RandomId));
		$RowCount_Id = $pdoResult_Id->rowCount();
		if($RowCount_Id == 0){
			return $RandomId;
		}else{
			return GenerateUserId($RandomIdlength);
		}
    }

    function GeneratePageId($RandomIdlength){
		include('dbcon.php');
		$RandomId = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWabcdefghijklmnopqrstuvwqyz"), 0, $RandomIdlength);
		$pdoResult_Id = $PDOdb->prepare("SELECT * FROM pages WHERE Id=:Id");
		$pdoExec_Id = $pdoResult_Id->execute(array(":Id"=>$RandomId));
		$RowCount_Id = $pdoResult_Id->rowCount();
		if($RowCount_Id == 0){
			return $RandomId;
		}else{
			return GeneratePageId($RandomIdlength);
		}
    }
    
    function GeneratePageCode($RandomIdlength){
		include('dbcon.php');
		$RandomId = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWabcdefghijklmnopqrstuvwqyz"), 0, $RandomIdlength);
		return $RandomId;
	}

    if(isset($_POST['login'])){
        $UserName = $_POST['username'];
        $Password = $_POST['password'];
        $Password = md5($Password);

        $pdoResult = $PDOdb->prepare("SELECT * FROM users WHERE `Username`=:Username AND `Password`=:Password");
		$pdoExec = $pdoResult->execute(array(":Username"=>$UserName, ":Password"=>$Password));
        $rowcount = $pdoResult->rowCount();
		
		if($pdoExec){
			if($rowcount != 0){
                $result = $pdoResult->fetchAll();
                $_SESSION['UserId'] = $result[0]['Id'];
                header("location: ./admin/");
                echo '
                <script>
                    location.replace("./admin/");
                    window.location.href = "./admin/"
                </script>
                ';
            }else{
                $_SESSION['status'] = "error";
                $_SESSION['statusmsg'] = "User not found";
                header('location: ./login');
                echo '
                <script>
                    location.replace("./login");
                    window.location.href = "./login"
                </script>
                ';
            }
        }else{
            echo 'error';
            print_r($pdoResult->errorInfo());
        }
    }

    if($methode == "signout"){
        unset($_SESSION['UserId']);
		unset($_SESSION['UserName']);
		session_destroy();
		header("location: ./login");
		echo '
		<script>
			location.replace("./login");
			window.location.href = "./login"
		</script>
		';
    }

    if(isset($_POST['updateuser'])){
        $UserId = $_POST['Id'];
        $Username = $_POST['Username'];
        $Password = $_POST['Password'];

        if(!empty($Password)){
            $Password = md5($Password);
            
            $pdoResult = $PDOdb->prepare("UPDATE users SET `Username`=:Username, `Password`=:Password WHERE `Id`=:UserId");
		    $pdoExec = $pdoResult->execute(array(":Username"=>$Username, ":Password"=>$Password, ":UserId"=>$UserId));
        }else{
            $pdoResult = $PDOdb->prepare("UPDATE users SET `Username`=:Username WHERE `Id`=:UserId");
		    $pdoExec = $pdoResult->execute(array(":Username"=>$Username, ":UserId"=>$UserId));
        }
		
		if($pdoExec){
			header("location: ./admin/users");
            echo '
            <script>
                location.replace("./admin/users");
                window.location.href = "./admin/users"
            </script>
            ';
        }else{
            echo 'error';
            print_r($pdoResult->errorInfo());
        }
    }

    if(isset($_POST['adduser'])){
        $UserId = GenerateUserId(30);
        $Username = $_POST['Username'];
        $Password = $_POST['Password'];
        $Password = md5($Password);
        
        $pdoResult = $PDOdb->prepare("INSERT INTO `users` (`Id`, `Username`, `Password`) VALUES (:UserId, :Username, :Password);");
		$pdoExec = $pdoResult->execute(array(":Username"=>$Username, ":Password"=>$Password, ":UserId"=>$UserId));
		
		if($pdoExec){
			header("location: ./admin/users");
            echo '
            <script>
                location.replace("./admin/users");
                window.location.href = "./admin/users"
            </script>
            ';
        }else{
            echo 'error';
            print_r($pdoResult->errorInfo());
        }
    }

    if(isset($_POST['deleteuser'])){
        $UserId = $_POST['Id'];

        $pdoResult = $PDOdb->prepare("DELETE FROM users WHERE `Id`=:UserId");
		$pdoExec = $pdoResult->execute(array(":UserId"=>$UserId));
		
		if($pdoExec){
			header("location: ./admin/users");
            echo '
            <script>
                location.replace("./admin/users");
                window.location.href = "./admin/users"
            </script>
            ';
        }else{
            echo 'error';
            print_r($pdoResult->errorInfo());
        }
    }

    if(isset($_POST['updatesettings'])){
        $titletext = $_POST['titletext'];
        $subtitletext = $_POST['subtitletext'];
        $tabtitletext = $_POST['tabtitletext'];
        $logintext = $_POST['logintext'];
        $titlecolor = $_POST['titlecolor'];
        $subtitlecolor = $_POST['subtitlecolor'];
        $menubgcolor = $_POST['menubgcolor'];
        $pagebgcolor = $_POST['pagebgcolor'];
        $menulevel0color = $_POST['menulevel0color'];
        $menulevel1color = $_POST['menulevel1color'];
        $menulevel2color = $_POST['menulevel2color'];
        $menulevel3color = $_POST['menulevel3color'];
        $menulevel4color = $_POST['menulevel4color'];
        $menulevel5color = $_POST['menulevel5color'];
        $tinymcekey = $_POST['tinymcekey'];

        $pdoResult = $PDOdb->prepare("
            UPDATE settings SET
                `TitleColor`=:TitleColor, 
                `SubTitleColor`=:SubTitleColor, 
                `MenuBGColor`=:MenuBGColor, 
                `PageBGColor`=:PageBGColor, 
                `MenuLevel0Color`=:MenuLevel0Color, 
                `MenuLevel1Color`=:MenuLevel1Color, 
                `MenuLevel2Color`=:MenuLevel2Color, 
                `MenuLevel3Color`=:MenuLevel3Color, 
                `MenuLevel4Color`=:MenuLevel4Color, 
                `MenuLevel5Color`=:MenuLevel5Color, 
                `TitleText`=:TitleText, 
                `SubTitleText`=:SubTitleText, 
                `TabTitleText`=:TabTitleText, 
                `LoginLinkText`=:LoginLinkText,
                `TinyMCEKey`=:TinyMCEKey
            ");
		$pdoExec = $pdoResult->execute(array(":TitleColor"=>$titlecolor, ":SubTitleColor"=>$subtitlecolor, ":MenuBGColor"=>$menubgcolor, ":PageBGColor"=>$pagebgcolor, ":MenuLevel0Color"=>$menulevel0color, ":MenuLevel1Color"=>$menulevel1color, ":MenuLevel2Color"=>$menulevel2color, ":MenuLevel3Color"=>$menulevel3color, ":MenuLevel4Color"=>$menulevel4color, ":MenuLevel5Color"=>$menulevel5color, ":TitleText"=>$titletext, ":SubTitleText"=>$subtitletext, ":TabTitleText"=>$tabtitletext, ":LoginLinkText"=>$logintext, ":TinyMCEKey"=>$tinymcekey));
		
		if($pdoExec){
			header("location: ./admin/settings");
            echo '
            <script>
                location.replace("./admin/settings");
                window.location.href = "./admin/settings"
            </script>
            ';
        }else{
            echo 'error';
            print_r($pdoResult->errorInfo());
        }
    }

    //Pages
    if(isset($_POST['addpage'])){
        $Id = GeneratePageId(30);
        $Title = $_POST['Title'];
        $Url = GeneratePageCode(10) .'-'. $Title;
        
        $pdoResult = $PDOdb->prepare("INSERT INTO `pages` (`Id`, `Url`, `Title`) VALUES (:Id, :Url, :Title);");
		$pdoExec = $pdoResult->execute(array(":Url"=>$Url, ":Title"=>$Title, ":Id"=>$Id));
		
		if($pdoExec){
			header("location: ./admin/pages");
            echo '
            <script>
                location.replace("./admin/pages");
                window.location.href = "./admin/pages"
            </script>
            ';
        }else{
            echo 'error';
            print_r($pdoResult->errorInfo());
        }
    }

    if($methode == "deletepage"){
        $Id = $_GET['Id'];

        $pdoResult = $PDOdb->prepare("DELETE FROM pages WHERE `Id`=:Id");
		$pdoExec = $pdoResult->execute(array(":Id"=>$Id));
		
		if($pdoExec){
			header("location: ./admin/pages");
            echo '
            <script>
                location.replace("./admin/pages");
                window.location.href = "./admin/pages"
            </script>
            ';
        }else{
            echo 'error';
            print_r($pdoResult->errorInfo());
        }
    }

    if(isset($_POST['updatepage'])){
        $Id = $_POST['Id'];
        $Title = $_POST['Title'];
        $Url = $_POST['Url'];
        $Contents = $_POST['Contents'];

        $pdoResult = $PDOdb->prepare("UPDATE pages SET `Title`=:Title, `Url`=:Url, `Contents`=:Contents WHERE `Id`=:Id");
		$pdoExec = $pdoResult->execute(array(":Title"=>$Title, ":Url"=>$Url, ":Contents"=>$Contents, ":Id"=>$Id));
        
		if($pdoExec){
			header("location: ./admin/page?Id=".$Id);
            echo '
            <script>
                location.replace("./admin/page?Id='.$Id.'");
                window.location.href = "./admin/page?Id='.$Id.'"
            </script>
            ';
        }else{
            echo 'error';
            print_r($pdoResult->errorInfo());
        }
    }

    //Menu
    if(isset($_POST['addmenuitem'])){
        $Id = GeneratePageId(30);
        $Title = $_POST['Title'];
        $Page = $_POST['Page'];
        $Level = $_POST['Level'];
        $Order = $_POST['Order'];
        $NewCat = $_POST['NewCat'];
        
        $pdoResult = $PDOdb->prepare("INSERT INTO `menuitems` (`Id`, `Title`, `Page`, `Level`, `Order`, `NewCat`) VALUES (:Id, :Title, :Page, :Level, :Order, :NewCat);");
		$pdoExec = $pdoResult->execute(array(":Title"=>$Title, ":Page"=>$Page, ":Level"=>$Level, ":Order"=>$Order, ":NewCat"=>$NewCat, ":Id"=>$Id));
		
		if($pdoExec){
			header("location: ./admin/menu");
            echo '
            <script>
                location.replace("./admin/menu");
                window.location.href = "./admin/menu"
            </script>
            ';
        }else{
            echo 'error';
            print_r($pdoResult->errorInfo());
        }
    }

    if(isset($_POST['updatemenuitem'])){
        $Id = $_POST['Id'];
        $Title = $_POST['title'];
        $Page = $_POST['page'];
        $Level = $_POST['level'];
        $Order = $_POST['order'];
        $NewCat = $_POST['newcat'];

        $pdoResult = $PDOdb->prepare("UPDATE menuitems SET `Title`=:Title, `Page`=:Page, `Level`=:Level, `Order`=:Order, `NewCat`=:NewCat WHERE `Id`=:Id");
		$pdoExec = $pdoResult->execute(array(":Title"=>$Title, ":Page"=>$Page, ":Level"=>$Level, ":Order"=>$Order, ":NewCat"=>$NewCat, ":Id"=>$Id));
        
		if($pdoExec){
			header("location: ./admin/menu");
            echo '
            <script>
                location.replace("./admin/menu");
                window.location.href = "./admin/menu"
            </script>
            ';
        }else{
            echo 'error';
            print_r($pdoResult->errorInfo());
        }
    }

    if(isset($_POST['deletemenuitem'])){
        $Id = $_POST['Id'];

        $pdoResult = $PDOdb->prepare("DELETE FROM menuitems WHERE `Id`=:Id");
		$pdoExec = $pdoResult->execute(array(":Id"=>$Id));
		
		if($pdoExec){
			header("location: ./admin/menu");
            echo '
            <script>
                location.replace("./admin/menu");
                window.location.href = "./admin/menu"
            </script>
            ';
        }else{
            echo 'error';
            print_r($pdoResult->errorInfo());
        }
    }
?>