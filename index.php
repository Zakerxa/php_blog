<?php
session_start();
require "config/config.php";

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("Location: login.php");
}

  $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
  $stmt->execute();
  $result = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Widgets</title>
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


  <!-- Content Wrapper. Contains page content -->
  <div class="">
    <!-- Content Header (Page header) -->
    <section>
        <div class="container-fluid">
            <h1 style="text-align: center;">Blog Site</h1>
       </div>
    </section>

    <section class="content-header">


        <div class="row">
          <?php 
            if($result){
              $i = 1;
              foreach($result as $value){ ?>

                <div class="col-md-4">
                  <!-- Box Comment -->
                  <div class="card card-widget">
                    <div class="card-header">
                       <div class="card-title" style="float: none;text-align: center;">
                           <h4><?=$value['title']?></h4>
                       </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <a href="blogdetails.php?id=<?=$value['id']?>"><img class="img-fluid pad" src="admin/images/<?=$value['image']?>" style="height:200px !important" alt="Photo"></a>
                    </div>
                  </div>
                </div>

          <?php $i++;   }
            }
          ?>
           
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


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
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
