<?php
 session_start();
 require "config/config.php";

 if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
   header("Location: login.php");
 }

 $stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
 $stmt->execute();
 $result = $stmt->fetchAll();

 $blogId      = $_GET['id'];

 $stmtcm = $pdo->prepare("SELECT * FROM comments WHERE post_id=$blogId");
 $stmtcm->execute();
 $cmResult = $stmtcm->fetchAll();

 $author_id = $cmResult[0]['author_id'];
 $stmtauth = $pdo->prepare("SELECT * FROM users WHERE id=$author_id");
 $stmtauth->execute();
 $authResult = $stmtauth->fetchAll();

 if($_POST){

   $content = $_POST['comment'];
   
   
    $stmt    = $pdo->prepare("INSERT INTO comments(content,author_id,post_id) VALUE (:content,:author_id,:post_id)");
    $result  = $stmt->execute(
         array(':content'=>$content,':author_id'=>$_SESSION['user_id'],':post_id'=>$blogId)
     );

     if($result){
        header("location: blogdetails.php?id=".$blogId);
     }

 }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blog Detail</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="">

  <div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
             <div class="col-md-12">
                <!-- Box Comment -->
                <div class="card card-widget">
                  <div class="card-header">
                     <div class="card-title" style="float: none;text-align: center;">
                         <h4><?=$result[0]['title']?></h4>
                     </div>
                  </div>
                
                  <div class="card-body">
                    <img class="img-fluid pad w-100" src="admin/images/<?=$result[0]['image']?>" alt="Photo">
                    <br>
                    <p><?=$result[0]['content']?></p>
                  </div>
                   <h3>Comments</h3><hr>
                   <a href="./" type="button" class="btn btn-dark">Go Back</a>
                </div>

                <div class="card-footer card-comments">

                 <div class="card-comment">
                
                  <div class="comment-text" style="margin-left: 8px!important;">
                    <span class="username">
                      <?=$authResult[0]['name']?>
                      <span class="text-muted float-right"><?=$cmResult[0]['created_at']?></span>
                    </span><!-- /.username -->
                   <?=$cmResult[0]['content'];?>
                  </div>
                  <!-- /.comment-text -->
                 </div>

                  <!-- /.card-footer -->
                 <div class="card-footer">
                   <form action="" method="post">
                     <div class="img-push">
                       <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                     </div>
                   </form>
                 </div>
               
              </div>

               
              </div>
          </div>
    </section>


  </div>
  <!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer" style="margin-left: 0!important;"> 
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <a href="logout.php">
         <div class="btn btn-warning font-weight-bold">Log Out</div>
      </a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 <a href="https://adminlte.io">Zakerxa</a>.</strong> All rights reserved.
  </footer>


  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
