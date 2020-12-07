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
    <title>Menu - Simple Docs</title>
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
                        <h1 class="AdminPageTitle">Menu</h1>
                        <form action="../server.php" method="POST" class="form form-inline">
                            <input class="form-control" type="text" placeholder="Title" name="Title">&nbsp;
                            <select class="form-control"  name="Page">
                                <option value="none" selected>No page</option>
                                <?php
                                    $pdoResult_Pages2 = $PDOdb->prepare("SELECT * FROM pages ORDER BY Id DESC");
                                    $pdoExec_Pages2 =  $pdoResult_Pages2->execute();
                                    
                                    if($pdoExec_Pages2){
                                        while($row_Pages2 = $pdoResult_Pages2->fetch(PDO::FETCH_ASSOC)){
                                            $Id = $row_Pages2['Id'];
                                            $Url = $row_Pages2['Url'];
                                            $Title = $row_Pages2['Title'];
                                            
                                            echo '<option value="'.$Id.'">'.$Title.'</option>';
                                        }
                                    }else{
                                        echo '<option disabled selected>No pages Found</option>';
                                    }
                                ?>
                            </select>&nbsp;
                            <select class="form-control"  name="Level">
                                <option value="MenuLayer0">Level 0</option>
                                <option value="MenuLayer1">Level 1</option>
                                <option value="MenuLayer2">Level 2</option>
                                <option value="MenuLayer3">Level 3</option>
                                <option value="MenuLayer4">Level 4</option>
                                <option value="MenuLayer5">Level 5</option>
                            </select>&nbsp;
                            <input class="form-control" type="number" value="0" name="Order">&nbsp;
                            <select class="form-control"  name="NewCat">
                                <option value="false" selected>False</option>
                                <option value="true">True</option>
                            </select>&nbsp;
                            <button type="submit" class="btn btn-primary" name="addmenuitem">Add</button>
                        </form><br>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Page</th>
                                    <th>Level</th>
                                    <th>Order</th>
                                    <th>New Category</th>
                                    <th>Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $pdoResult = $PDOdb->prepare("SELECT * FROM menuitems ORDER BY `Order` DESC");
                                    $pdoExec =  $pdoResult->execute();
                                    
                                    if($pdoExec){
                                        while($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                                            $ItemId = $row['Id'];
                                            $Title = $row['Title'];
                                            
                                            $PageId = $row['Page'];
                                            $pdoResult_PageLink = $PDOdb->prepare("SELECT * FROM pages WHERE Id=:Id");
                                            $pdoExec_PageLink = $pdoResult_PageLink->execute(array(":Id" => $PageId));
                                            $result = $pdoResult_PageLink->fetchAll();
                                            if(isset($result[0]['Url'])){
                                                $Page = $result[0]['Url'];
                                            }else{
                                                $Page = "none";
                                            }
                                            
                                            $Level = $row['Level'];
                                            $Order = $row['Order'];
                                            $NewCat = $row['NewCat'];
                                            
                                            echo '
                                            <form action="../server.php" method="POST">
                                                <tr>
                                                    <td><input class="form-control" type="text" value="'.$Title.'" name="title"></td>
                                                    <td>
                                                        <select class="form-control" name="page">
                                                        ';
                                                            if($Page == "none"){
                                                                echo '<option selected value="none" selected>No page</option>';
                                                            }else{
                                                                echo '<option value="none">No page</option>';
                                                            }
                                                            
                                                            $pdoResult_Pages = $PDOdb->prepare("SELECT * FROM pages ORDER BY Id DESC");
                                                            $pdoExec_Pages =  $pdoResult_Pages->execute();

                                                            if($pdoExec_Pages){
                                                                while($row_Pages = $pdoResult_Pages->fetch(PDO::FETCH_ASSOC)){
                                                                    $Id = $row_Pages['Id'];
                                                                    $PageUrl = $row_Pages['Url'];
                                                                    
                                                                    $Title = $row_Pages['Title'];
                                                                    if($PageUrl == $Page && $Page != "none"){
                                                                        echo '<option selected value="'.$Id.'">'.$Title.'</option>';
                                                                    }else{
                                                                        echo '<option value="'.$Id.'">'.$Title.'</option>';
                                                                    }
                                                                }
                                                            }else{
                                                                echo '<option disabled selected>Error</option>';
                                                            }
                                                        echo '
                                                        </select>&nbsp;
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="level">';
                                                        if($Level == "MenuLayer0"){
                                                            echo '<option selected value="MenuLayer0">Level 0</option>';
                                                        }else{
                                                            echo '<option value="MenuLayer0">Level 0</option>';
                                                        }
                                                        if($Level == "MenuLayer1"){
                                                            echo '<option selected value="MenuLayer1">Level 1</option>';
                                                        }else{
                                                            echo '<option value="MenuLayer1">Level 1</option>';
                                                        }
                                                        if($Level == "MenuLayer2"){
                                                            echo '<option selected value="MenuLayer2">Level 2</option>';
                                                        }else{
                                                            echo '<option value="MenuLayer2">Level 2</option>';
                                                        }
                                                        if($Level == "MenuLayer3"){
                                                            echo '<option selected value="MenuLayer3">Level 3</option>';
                                                        }else{
                                                            echo '<option value="MenuLayer3">Level 3</option>';
                                                        }
                                                        if($Level == "MenuLayer4"){
                                                            echo '<option selected value="MenuLayer4">Level 4</option>';
                                                        }else{
                                                            echo '<option value="MenuLayer4">Level 4</option>';
                                                        }
                                                        if($Level == "MenuLayer5"){
                                                            echo '<option selected value="MenuLayer5">Level 5</option>';
                                                        }else{
                                                            echo '<option value="MenuLayer5">Level 5</option>';
                                                        }
                                                    
                                                    echo '
                                                        </select>&nbsp;
                                                    </td>
                                                    <td><input class="form-control" type="number" value="'.$Order.'" name="order"></td>
                                                    <td>
                                                        <select class="form-control" name="newcat">';
                                                            if($NewCat == "false"){
                                                                echo '
                                                                <option value="false" selected>False</option>
                                                                <option value="true">True</option>
                                                                ';
                                                            }else{
                                                                echo '
                                                                <option value="false">False</option>
                                                                <option value="true" selected>True</option>
                                                                ';
                                                            }
                                                            echo '
                                                        </select>&nbsp;
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="hidden" readonly="" name="Id" value="'.$ItemId.'">
                                                        <button type="submit" class="btn btn-primary" name="updatemenuitem">Update</button>
                                                        <button type="submit" class="btn btn-primary" name="deletemenuitem">Delete</button>
                                                    </td>
                                                </tr>
                                            </form>
                                            ';
                                        }
                                    }else{
                                        echo 'error';
                                    }
                                ?>
                            </tbody>
                        </table>
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