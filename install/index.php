<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installer</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <script src="./assets/js/jquery.js"></script>
</head>
<body>
    <div class="installerdiv">
        <div class="header">
            <h1>UltraEditor Installer</h1>
        </div>
        <div class="stepsDiv">
            <div class="stepDiv" id="step1">
                <h3>Database</h3>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Host</span>
                    </div>
                    <input type="text" class="form-control" id="DB_Host">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Database</span>
                    </div>
                    <input type="text" class="form-control" id="DB_Database">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Username</span>
                    </div>
                    <input type="text" class="form-control" id="DB_Username">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Password</span>
                    </div>
                    <input type="password" class="form-control" id="DB_Password">
                </div>
                <div class="btnDiv">
                    <button class="btn btn-primary" id="nextbtn1">Next</button>
                </div>
            </div>

            <div class="stepDiv" id="step2">
                <h3>Create Admin Account</h3>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Username</span>
                    </div>
                    <input type="text" class="form-control" id="User_UserName">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Password</span>
                    </div>
                    <input type="password" class="form-control" id="User_Password">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Repeat Password</span>
                    </div>
                    <input type="password" class="form-control" id="User_Password2">
                </div>
                <div class="btnDiv">
                    <button class="btn btn-primary" id="backbtn2">Previous</button>
                    <button class="btn btn-primary" id="finsh">Finsh</button>
                </div>
            </div>

            <div class="stepDiv" id="step3">
                <h3>Setting up Database</h3><br>

                <p class="setupText" id="Setup1">Connecting to Database <img class="loadingIcon" src="./assets/img/loading.gif" alt="Loading" id="Setup1Loading"> <i id="Setup1Check" class="fas fa-check"></i> <i id="Setup1Error" class="fas fa-times"></i></p>
                <p class="setupText" id="Setup2">Creating Tables <img class="loadingIcon" src="./assets/img/loading.gif" alt="Loading" id="Setup2Loading"> <i id="Setup2Check" class="fas fa-check"></i> <i id="Setup2Error" class="fas fa-times"></i></p>
                <p class="setupText" id="Setup3">Creating config.php File <img class="loadingIcon" src="./assets/img/loading.gif" alt="Loading" id="Setup3Loading"> <i id="Setup3Check" class="fas fa-check"></i> <i id="Setup3Error" class="fas fa-times"></i></p>
                
                <p class="errorMsg" id="errorMsg">Unknown Error</p>
                
                <div id="successDiv">
                    <h4>Success</h4>
                    <p>Simple Docs has been succesfully set up.</p>
                    <p>If you want to change the config you can do so in config.php</p>
                    <p class="important">DONT FORGET TO REMOVE THE INSTALLER FOLDER!!</p>
                </div>

                <div class="btnDiv">
                    <button class="btn btn-primary" id="backbtn3">Previous</button>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/scripts.js"></script>
    <script src="./assets/js/notify.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>