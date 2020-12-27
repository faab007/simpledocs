<?php 
    include 'server.php';
    if(isset($_SESSION['UserId'])){
        header('location: ../admin/');
        echo '
        <script>
            location.replace("../admin/");
            window.location.href = "../admin/"
        </script>
        ';
    }
    
    if(isset($_GET['error'])){
        if($_GET['error'] == "usernotfound"){
            $error = '<div class="error-box"><strong>Incorrect username or password</strong></div>';
        }
    }else{
        $error = "";
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Simple Docs</title>
    <link rel="icon" href="./assets/img/icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
</head>

<body style="overflow: hidden;">
    <!-- Start: Login screen -->
    <div id="login-one" class="login-one">
        <form class="login-one-form" action="server.php" method="POST">
            <div class="col">
                <div class="login-one-ico"><i class="fa fa-unlock-alt" id="lockico"></i></div>
                <div class="form-group">
                    <div>
                        <h3 id="heading">Log in:</h3>
                    </div>
                    <?php echo $error ?>
                    <input class="form-control" type="text" id="input" placeholder="Username" name="username" required>
                    <input class="form-control" type="password" id="input" placeholder="Password" name="password" required>
                    <button class="btn btn-primary" id="button" name="login" style="background-color:#007ac9;" type="submit">Log in</button>
                </div>
            </div>
        </form>
    </div>
    <!-- End: Login screen -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/script.min.js"></script>
</body>

</html>
