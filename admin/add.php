<?php
 session_start();
 require "../config/config.php";

 if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
   header("Location: login.php");
 }

 if($_POST){

     $file = 'images/'.($_FILES['image']['name']);
     $imageType = pathinfo($file,PATHINFO_EXTENSION);

     if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg'){
         echo "<script>alert('Image must be  png,jpg,jpeg')</script>";
     }else{

        $title   = $_POST['title'];
        $content = $_POST['content'];
        $image   = $_FILES['image']['name'];
         move_uploaded_file($_FILES['image']['tmp_name'],$file);
        $stmt    = $pdo->prepare("INSERT INTO posts(title,content,image,author_id) VALUE (:title,:content,:image,:author_id)");
        $result  = $stmt->execute(
             array(':title'=>$title,':content'=>$content,':image'=>$image,':author_id'=>$_SESSION['user_id'])
         );

         if($result){
           echo "<script>alert('Successfully added');window.location.href='index.php';</script>";
         }
     }
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
               <div class="card-body">
               <form action="add.php" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                      <label for="">Title</label>
                      <br>
                      <input type="text" class="form-control" name="title" value="" required>
                  </div>
                  <div class="form-group">
                      <label for="">Content</label>
                      <br>
                      <textarea name="content" class="form-control" id="" cols="30" rows="10"></textarea>
                  </div>
                  <div class="form-group">
                      <label for="">Image</label>
                      <br>
                      <input type="file" name="image" id="">
                  </div>
                  <div class="form-group">
                      <input class="btn btn-success" type="submit" value="Submit">
                      
                      <a href="./" class="btn btn-warning">Back</a>
                  </div>
               </form>
               </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php include("footer.html");?>

</body>
</html>
