<?php 
    include './server.php';

    if(!file_exists("./config.php")){
        header('location: ./install');
        echo '
        <script>
            location.replace("./install");
            window.location.href = "./install"
        </script>
        ';
    }

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
            
            if($MenuBGColor != "#000000"){
                $MenuFooterBorder = "border: 1px solid rgb(150, 150, 150);";
            }
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $TabTitleText; ?></title>
    <link rel="icon" href="./assets/img/icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="row no-gutters">
        <div class="col-auto SideMenu noselect" style="background-color: <?php echo $MenuBGColor; ?>;">
            <div class="header">
                <a href="./">
                    <h1 style="color: <?php echo $TitleColor; ?>;"><?php echo $TitleText; ?></h1>
                    <p style="color: <?php echo $SubTitleColor; ?>;"><?php echo $SubTitleText; ?></p>
                </a>
            </div>
            <div class="MenuItems">
                <!-- Start: MenuItem -->
                <div class="MenuItem">
                    <?php
                        $pdoResult = $PDOdb->prepare("SELECT * FROM menuitems ORDER BY `Order` DESC");
                        $pdoExec =  $pdoResult->execute();
                        
                        if($pdoExec){
                            while($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                                $Id = $row['Id'];
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
                                $NewCat = $row['NewCat'];

                                if($Level == "MenuLayer0"){
                                    $ItemColor = $MenuLevel0Color;
                                }
                                if($Level == "MenuLayer1"){
                                    $ItemColor = $MenuLevel1Color;
                                }
                                if($Level == "MenuLayer2"){
                                    $ItemColor = $MenuLevel2Color;
                                }
                                if($Level == "MenuLayer3"){
                                    $ItemColor = $MenuLevel3Color;
                                }
                                if($Level == "MenuLayer4"){
                                    $ItemColor = $MenuLevel4Color;
                                }
                                if($Level == "MenuLayer5"){
                                    $ItemColor = $MenuLevel5Color;
                                }
                                
                                if($Page == "none"){
                                    if($NewCat == "true"){
                                        echo '
                                        <div class="'.$Level.'" style="margin-top: 10px;">
                                            <a style="color: '.$ItemColor.'">
                                                <p>- '.$Title.'</p>
                                            </a>
                                        </div>
                                        ';
                                    }else{
                                        echo '
                                        <div class="'.$Level.'">
                                            <a style="color: '.$ItemColor.'">
                                                <p>- '.$Title.'</p>
                                            </a>
                                        </div>
                                        ';
                                    }
                                }else{
                                    if($NewCat == "true"){
                                        echo '
                                        <div class="'.$Level.'" style="margin-top: 10px;">
                                            <a style="color: '.$ItemColor.'" href="./?'.$Page.'">
                                                <p>- '.$Title.'</p>
                                            </a>
                                        </div>
                                        ';
                                    }else{
                                        echo '
                                        <div class="'.$Level.'">
                                            <a style="color: '.$ItemColor.'" href="./?'.$Page.'">
                                                <p>- '.$Title.'</p>
                                            </a>
                                        </div>
                                        ';
                                    }
                                }
                            }
                        }else{
                            echo 'error';
                        }
                    ?>
                </div>
                <!-- End: MenuItem -->
            </div>
            <div class="Footer">
                <p class="text-center" style="<?php echo $MenuFooterBorder; ?>">Powered By <a href="https://github.com/faab007/simpledocs" target="_BLANK"><span class="FooterByText">Simple Docs</span></a><a class="Login" href="./login"><?php echo $LoginLinkText; ?></a></p>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                var PageUrl = window.location.toString();
                var PageUrl = PageUrl.split("?")[1];

                if(PageUrl == undefined){
                    PageUrl = "default";
                }
                console.log(PageUrl);

                function getData(){
                    $.get( "pagedata.php?PageUrl="+PageUrl, function( data ) {
                        $('#output').html(data);
                    });
                }
                getData();
            });
        </script>
        <div class="col">
            <div class="Contents">
	            <div id="output"></div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/script.min.js"></script>
</body>

</html>
