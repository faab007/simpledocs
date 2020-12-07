<?php 
    include '../server.php';
    if(!isset($_SESSION['UserId'])){
        header('location: ../login');
        echo '
        <script>
            location.replace("../login");
            window.location.href = "../login"
        </script>
        ';
    }else{
        $UserId = $_SESSION['UserId'];
        $pdoResult = $PDOdb->prepare("SELECT * FROM users WHERE `Id`=:UserId");
		$pdoExec = $pdoResult->execute(array(":UserId"=>$UserId));
        $rowcount = $pdoResult->rowCount();
        $UserName = "123";
		
		if($pdoExec){
			if($rowcount != 0){
                $result = $pdoResult->fetchAll();
                $UserName = $result[0]['Username'];

                $TitleColor = "";
                $SubTitleColor = "";
                $MenuBGColor = "";
                $PageBGColor = "";
                $MenuLevel0Color = "";
                $MenuLevel1Color = "";
                $MenuLevel2Color = "";
                $MenuLevel3Color = "";
                $MenuLevel4Color = "";
                $MenuLevel5Color = "";
                $TitleText = "";
                $SubTitleText = "";
                $TabTitleText = "";
                $LoginLinkText = "";
                $TinyMCEKey = "";
                
                $pdoResult_Settings = $PDOdb->prepare("SELECT * FROM settings");
                $pdoExec_Settings = $pdoResult_Settings->execute();
                if($pdoExec_Settings){
                    while($row = $pdoResult_Settings->fetch(PDO::FETCH_ASSOC)){
                        $TitleColor = $row['TitleColor'];
                        $SubTitleColor = $row['SubTitleColor'];
                        $MenuBGColor = $row['MenuBGColor'];
                        $PageBGColor = $row['PageBGColor'];
                        $MenuLevel0Color = $row['MenuLevel0Color'];
                        $MenuLevel1Color = $row['MenuLevel1Color'];
                        $MenuLevel2Color = $row['MenuLevel2Color'];
                        $MenuLevel3Color = $row['MenuLevel3Color'];
                        $MenuLevel4Color = $row['MenuLevel4Color'];
                        $MenuLevel5Color = $row['MenuLevel5Color'];
                        $TitleText = $row['TitleText'];
                        $SubTitleText = $row['SubTitleText'];
                        $TabTitleText = $row['TabTitleText'];
                        $LoginLinkText = $row['LoginLinkText'];
                        $TinyMCEKey = $row['TinyMCEKey'];
                    }
                }
            }else{
                header('location: ../login');
                echo '
                <script>
                    location.replace("../login");
                    window.location.href = "../login"
                </script>
                ';
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Settings - Simple Docs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
</head>
<body>
    <div id="wrapper">
        <!-- Start: Sidebar Menu --> 
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand"> <a href="./">Admin Panel</a></li>
                <li><a href="./pages">Pages</a></li>
                <li><a href="./menu">Side Menu</a></li>
                <li><a href="./users">Users</a></li>
                <li><a href="./settings">Settings</a></li>
                <li><a href="../server.php?methode=signout">Logout</a></li>
            </ul>
        </div>
        <!-- End: Sidebar Menu -->
        <div class="page-content-wrapper">
            <div class="container-fluid"><br>
                <p>Welcome <?php echo $UserName; ?>,</p>
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="AdminPageTitle">Settings</h1>
                        <form action="../server.php" method="POST" class="form" style="width: 400px;">
                            <div class="form-group text-left">
                                <label for="PageTitle">Title Text:</label>
                                <input class="form-control" type="text" value="<?php echo $TitleText; ?>" name="titletext">
                            </div>
                            <div class="form-group text-left">
                                <label for="PageTitle">Sub Title Text:</label>
                                <input class="form-control" type="text" value="<?php echo $SubTitleText; ?>" name="subtitletext">
                            </div>
                            <div class="form-group text-left">
                                <label for="PageTitle">Tab Title Text:</label>
                                <input class="form-control" type="text" value="<?php echo $TabTitleText; ?>" name="tabtitletext">
                            </div>
                            <div class="form-group text-left">
                                <label for="PageTitle">Login Text:</label>
                                <input class="form-control" type="text" value="<?php echo $LoginLinkText; ?>" name="logintext">
                            </div>
                            <div class="form-group text-left">
                                <label for="PageTitle">Title Color:</label>
                                <input class="form-control" type="color" value="<?php echo $TitleColor; ?>" name="titlecolor">
                            </div>
                            <div class="form-group text-left">
                                <label for="PageTitle">Sub Title Color:</label>
                                <input class="form-control" type="color" value="<?php echo $SubTitleColor; ?>" name="subtitlecolor">
                            </div>
                            <div class="form-group text-left">
                                <label for="PageTitle">Menu Background Color:</label>
                                <input class="form-control" type="color" value="<?php echo $MenuBGColor; ?>" name="menubgcolor">
                            </div>
                            <div class="form-group text-left">
                                <label for="PageTitle">Page Background Color:</label>
                                <input class="form-control" type="color" value="<?php echo $PageBGColor; ?>" name="pagebgcolor">
                            </div>
                            <div class="form-group text-left">
                                <label for="PageTitle">Menu Level 0 Color:</label>
                                <input class="form-control" type="color" value="<?php echo $MenuLevel0Color; ?>" name="menulevel0color">
                            </div>
                            <div class="form-group text-left">
                                <label for="PageTitle">Menu Level 1 Color:</label>
                                <input class="form-control" type="color" value="<?php echo $MenuLevel1Color; ?>" name="menulevel1color">
                            </div>
                            <div class="form-group text-left">
                                <label for="PageTitle">Menu Level 2 Color:</label>
                                <input class="form-control" type="color" value="<?php echo $MenuLevel2Color; ?>" name="menulevel2color">
                            </div>
                            <div class="form-group text-left">
                                <label for="PageTitle">Menu Level 3 Color:</label>
                                <input class="form-control" type="color" value="<?php echo $MenuLevel3Color; ?>" name="menulevel3color">
                            </div>
                            <div class="form-group text-left">
                                <label for="PageTitle">Menu Level 4 Color:</label>
                                <input class="form-control" type="color" value="<?php echo $MenuLevel4Color; ?>" name="menulevel4color">
                            </div>
                            <div class="form-group text-left">
                                <label for="PageTitle">Menu Level 5 Color:</label>
                                <input class="form-control" type="color" value="<?php echo $MenuLevel5Color; ?>" name="menulevel5color">
                            </div>
                            <div class="form-group text-left">
                                <label for="PageTitle">TinyMCE Key:</label>
                                <input class="form-control" type="text" value="<?php echo $TinyMCEKey; ?>" name="tinymcekey">
                            </div>
                            <button type="submit" class="btn btn-primary" name="updatesettings">Update</button><br><br><br><br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <script src="../assets/js/script.min.js"></script>
</body>
</html>