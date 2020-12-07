<?php 
    include './server.php';
    
    if(isset($_GET['PageUrl'])){
        $PageUrl = $_GET['PageUrl'];
        $pdoResult_Page = $PDOdb->prepare("SELECT * FROM pages WHERE `Url`=:PageUrl");
        $pdoExec_Page = $pdoResult_Page->execute(array(":PageUrl"=>$PageUrl));
        $rowcount_Page = $pdoResult_Page->rowCount();
        
        if($pdoExec_Page){
            if($rowcount_Page != 0){
                $result_Page = $pdoResult_Page->fetchAll();
                $Title = $result_Page[0]['Title'];
                $Contents = $result_Page[0]['Contents'];
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

        echo '<h1>'.$Title.'</h1>';
        echo $Contents;
    }else{
        echo 'no data';
    }
?>