<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {

  header('Location: login.php');
}

if ($_POST) {
    $file = 'images/'.($_FILES['image'] ['name']);
    $imageType = pathinfo($file, PATHINFO_EXTENSION );

    if($imageType != 'png' && $imageType != 'jpg') {
        echo "<script>alert('Image must be png,jpg,png,jpeg')</script>";
    } else {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_FILES['image'] ['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $file);

        $stmt = $pdo->prepare("INSERT INTO posts(title,content,author_id,image) VALUES (:title,:content,:author_id,:image)");
        $result = $stmt->execute(
            array(':title'=>$title, ':content'=>$content,':author_id'=>$_SESSION['user_id'],':image'=>$image )
        );

        if($result) {
            echo "<script>alert('Successfully added')</script>";
        }
    }
}

?>




<?php include('header.html') ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
              <form action="add.php" class="" method="post" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" class="form-control" name="title" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="">Content</label><br>
                        <textarea class="form-control" name="content" id="" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Image</label><br>
                        <input type="file" name="image" value="" required>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-success" type="submit" name="" value="SUBMIT">
                        <a href="index.php" class="btn btn-warning">Back</a>
                    </div>
              </form>
              </div>
                
            </div>
              <!-- /.card-body -->
              <?php include('footer.html') ?>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>


</html>
