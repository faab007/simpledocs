$(window).bind("beforeunload", function(){
    return;
});

function RunSetup(){
    $( "#backbtn4" ).prop('disabled', true);
    
    $( "#Setup1" ).show();
    $( "#Setup2" ).show();
    $( "#Setup3" ).show();
    $( "#Setup1Loading" ).show();
    $( "#Setup2Loading" ).show();
    $( "#Setup3Loading" ).show();
    $( "#Setup1Error" ).hide();
    $( "#Setup2Error" ).hide();
    $( "#Setup3Error" ).hide();
    $( "#Setup1Check" ).hide();
    $( "#Setup2Check" ).hide();
    $( "#Setup3Check" ).hide();

    var DB_Host = $( "#DB_Host" ).val();
    var DB_Database = $( "#DB_Database" ).val();
    var DB_Username = $( "#DB_Username" ).val();
    var DB_Password = $( "#DB_Password" ).val();

    var User_UserName = $( "#User_UserName" ).val();
    var User_Password = $( "#User_Password" ).val();

    var http = new XMLHttpRequest();
    var url = 'setup.php';
    var params = 'hostname='+DB_Host+'&username='+DB_Username+'&password='+DB_Password+'&database='+DB_Database+'&user_username='+User_UserName+'&user_password='+User_Password+'';

    http.open('POST', url, true);
    
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            //console.log(http.responseText);

            if(http.responseText == "con-error"){
                $( "#Setup1Loading" ).hide();
                $( "#Setup2Loading" ).hide();
                $( "#Setup3Loading" ).hide();
                $( "#Setup1Error" ).show();
                $( "#Setup2Error" ).show();
                $( "#Setup3Error" ).show();
                $( "#errorMsg" ).show();
                $( "#errorMsg" ).text("Can't connect to DB");
                $( "#backbtn3" ).prop('disabled', false);
            }else if(http.responseText == "create-error"){
                $( "#Setup1Loading" ).hide();
                $( "#Setup2Loading" ).hide();
                $( "#Setup3Loading" ).hide();
                $( "#Setup1Check" ).show();
                $( "#Setup2Error" ).show();
                $( "#Setup3Error" ).show();
                $( "#errorMsg" ).show();
                $( "#errorMsg" ).text("Can't create tables");
                $( "#backbtn3" ).prop('disabled', false);
            }else if(http.responseText == "file-error"){
                $( "#Setup1Loading" ).hide();
                $( "#Setup2Loading" ).hide();
                $( "#Setup3Loading" ).hide();
                $( "#Setup1Check" ).show();
                $( "#Setup2Check" ).show();
                $( "#Setup3Error" ).show();
                $( "#errorMsg" ).show();
                $( "#successDiv" ).hide();
                $( "#errorMsg" ).text("Can't create config.php file");
                $( "#backbtn3" ).prop('disabled', false);
            }else if(http.responseText == "success"){
                $( "#Setup1Loading" ).hide();
                $( "#Setup2Loading" ).hide();
                $( "#Setup3Loading" ).hide();
                $( "#Setup1Check" ).show();
                $( "#Setup2Check" ).show();
                $( "#Setup3Check" ).show();
                $( "#successDiv" ).show();
                $( "#backbtn3" ).hide();
            }
        }
    }

    http.send(params);
}

$( "#nextbtn1" ).click(function() {
    if ($( "#DB_Host" ).val() == "") return $.notify("Host can't be empty", "error");
    if ($( "#DB_Database" ).val() == "") return $.notify("Database can't be empty", "error");
    if ($( "#DB_Username" ).val() == "") return $.notify("Username can't be empty", "error");
    if ($( "#DB_Password" ).val() == "") return $.notify("Password can't be empty", "error");
    
    $( "#step1" ).hide();
    $( "#step2" ).show();
});

$( "#finsh" ).click(function() {
    if ($( "#User_UserName" ).val() == "") return $.notify("Username can't be empty", "error");
    if ($( "#User_Password" ).val() == "") return $.notify("Password can't be empty", "error");
    if ($( "#User_Password2" ).val() == "") return $.notify("Password can't be empty", "error");
    if ($( "#User_Password" ).val() != $( "#User_Password2" ).val()) return $.notify("Passwords do not match", "info");
    
    $( "#step2" ).hide();
    $( "#step3" ).show();
    RunSetup();
});

$( "#backbtn2" ).click(function() {
    $( "#step1" ).show();
    $( "#step2" ).hide();
});

$( "#backbtn3" ).click(function() {
    $( "#step2" ).show();
    $( "#step3" ).hide();
});