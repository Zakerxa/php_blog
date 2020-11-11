<?php
 session_start();
 require "../config/config.php";

 if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
   header("Location: login.php");
 }
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<?php include("header.html"); ?>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Blog Listing</h3>
              </div>
               <?php 
                  if(!empty($_GET['pageno'])){
                    $pageno = $_GET['pageno'];

                  }else{
                    $pageno = 1;
                  }
                  $noOffrecs = 1;
                  $offset   = ($pageno - 1) * $noOffrecs;
                  

                  if(empty($_POST['search'])){
                    $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
                    $stmt->execute();
                    $rawResult = $stmt->fetchAll();
                    $total_page = ceil(count($rawResult) / $noOffrecs);
  
                    $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$noOffrecs");
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                  }else{
                    $searchkey = $_POST['search'];
                    $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchkey%' ORDER BY id DESC");
                    $stmt->execute();
                    $rawResult = $stmt->fetchAll();
                    $total_page = ceil(count($rawResult) / $noOffrecs);
   
                    $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchkey%' ORDER BY id DESC LIMIT $offset,$noOffrecs");
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                  }

                ?>
              <!-- /.card-header -->
              <div class="card-body">
                 <div>
                  <a href="add.php" type="button" class="btn btn-success ">New Blog Posts</a>
                 </div>
                 <br>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Content</th>
                      <th>Action</th>
                       
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($result){
                      $i = 1;
                       foreach($result as $value){  ?>
                         <tr>
                               <td><?=$i?></td>
                               <td><?=$value['title']?></td>
                               <td><?=substr($value['content'],0,50)?></td>
                               <td>
                                 <div class="btn-group">
                                   <div class="container">
                                     <a href="edit.php?id=<?=$value['id']?>" class="btn btn-warning btn-sm">Edit</a>
                                   </div>
                                   <div class="container">
                                     <a href="delete.php?id=<?=$value['id']?>" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-sm">Delete</a>
                                   </div>
                                 </div>
                               </td>
                          </tr>
                     <?php $i++;
                      }  
                    } ?>
                  </tbody>
                </table>

                <br>
              <nav aria-label="Page navigation example" style="float:right;">
                 <ul class="pagination">

                   <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                   <li class="page-item <?php  if($pageno <= 1){ echo 'disabled';} ?>"><a class="page-link" href="<?php if($pageno <= 1){ echo '#';}else { echo "?pageno=".($pageno-1);} ?>">Pre</a></li>

                   <li class="page-item"><a class="page-link" href="#"><?=$pageno?></a></li>

                   <li class="page-item <?php if($pageno >= $total_page){ echo 'disabled';} ?>"><a class="page-link" href="<?php if($pageno >= $total_page){ echo '#';}else { echo "?pageno=".($pageno+1);} ?>">Next</a></li>

                   <li class="page-item"><a class="page-link" href="<?=$total_page?>">Last</a></li>

                 </ul>
               </nav>

              </div>
             
            
            </div>
            

          </div>
        
        </div>
       
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php include("footer.html");?>

</body>
</html>
