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

                $TinyMCEKey = "";
                $pdoResult_Settings = $PDOdb->prepare("SELECT * FROM settings");
                $pdoExec_Settings = $pdoResult_Settings->execute();
                if($pdoExec_Settings){
                    while($row = $pdoResult_Settings->fetch(PDO::FETCH_ASSOC)){
                        $TinyMCEKey = $row['TinyMCEKey'];
                    }
                }

                $PageId = $_GET['Id'];
                $pdoResult_Page = $PDOdb->prepare("SELECT * FROM pages WHERE `Id`=:PageId");
                $pdoExec_Page = $pdoResult_Page->execute(array(":PageId"=>$PageId));
                $rowcount_Page = $pdoResult_Page->rowCount();
                
                if($pdoExec_Page){
                    if($rowcount_Page != 0){
                        $result_Page = $pdoResult_Page->fetchAll();
                        $Id = $result_Page[0]['Id'];
                        $Title = $result_Page[0]['Title'];
                        $Url = $result_Page[0]['Url'];
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
    <title>Pages - Simple Docs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
    <script src="https://cdn.tiny.cloud/1/<?php echo $TinyMCEKey; ?>/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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
                        <h1 class="AdminPageTitle">Edit Page</h1>
                        <form action="../server.php" method="POST" class="form">
                            <div class="row">
                                <div class="col">
                                    Title:
                                    <input class="form-control" type="text" placeholder="Title" name="Title" value="<?php echo $Title; ?>">
                                </div>
                                <div class="col">
                                    URL:
                                    <input class="form-control" type="text" placeholder="Title" name="Url" value="<?php echo $Url; ?>">
                                </div>
                            </div><br>
                            <?php
                                if(empty($TinyMCEKey)){
                                    echo 'Your TinyMCE key is missing. Got to <a href="./settings">Settings</a> to enter it.';
                                }else{
                                    echo "
                                        <script>
                                        tinymce.init({
                                            selector: 'textarea',
                                            plugins: 'lists textcolor preview importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable charmap quickbars emoticons',
                                            toolbar_mode: 'floating',
                                            image_title: true,
                                            automatic_uploads: true,
                                            file_picker_types: 'image',
                                            file_picker_callback: function (cb, value, meta) {
                                                var input = document.createElement('input');
                                                input.setAttribute('type', 'file');
                                                input.setAttribute('accept', 'image/*');
                                                input.onchange = function () {
                                                  var file = this.files[0];
                                                  var reader = new FileReader();
                                                  reader.onload = function () {
                                                    var id = 'blobid' + (new Date()).getTime();
                                                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                                                    var base64 = reader.result.split(',')[1];
                                                    var blobInfo = blobCache.create(id, file, base64);
                                                    blobCache.add(blobInfo);
                                                    cb(blobInfo.blobUri(), { title: file.name });
                                                  };
                                                  reader.readAsDataURL(file);
                                                };
                                            
                                                input.click();
                                            },
                                            toolbar: 'undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | link image',
                                            content_style: 'p { margin: 0; }',
                                        });
                                    </script>
                                    ";
                                }
                            ?>
                            <textarea class="form-control" name="Contents" style="height: 60vh;"><?php echo $Contents; ?></textarea><br>
                            <input class="form-control" type="hidden" name="Id" value="<?php echo $Id; ?>">
                            <button type="submit" class="btn btn-primary" name="updatepage">Update</button>
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