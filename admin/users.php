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
    <title>Users - Simple Docs</title>
    <link rel="icon" href="./assets/img/icon.png">
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
                        <h1 class="AdminPageTitle">Users</h1>
                        <form action="../server.php" method="POST" class="form form-inline">
                            <input class="form-control" type="text" placeholder="Username" name="Username">&nbsp;
                            <input class="form-control" type="password" placeholder="Password" name="Password">&nbsp;
                            <button type="submit" class="btn btn-primary" name="adduser">Add</button>
                        </form><br>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Password</th>
                                    <th>Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $pdoResult = $PDOdb->prepare("SELECT * FROM users ORDER BY Id DESC");
                                    $pdoExec =  $pdoResult->execute();
                                    
                                    if($pdoExec){
                                        while($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                                            $Id = $row['Id'];
                                            $Name = $row['Username'];
                                            
                                            echo '
                                            <form action="../server.php" method="POST">
                                                <tr>
                                                    <td><input class="form-control" type="text" value="'.$Name.'" name="Username"></td>
                                                    <td><input class="form-control" type="password" name="Password"></td>
                                                    <td>
                                                        <input class="form-control" type="hidden" readonly="" name="Id" value="'.$Id.'">
                                                        <button type="submit" class="btn btn-primary" name="updateuser">Update</button>
                                                        ';
                                                        if($UserId != $Id){
                                                            echo '<button type="submit" class="btn btn-primary" name="deleteuser">Delete</button>';
                                                        }
                                                        echo'
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