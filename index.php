

<?php


if ($_SERVER['REQUEST_METHOD']=='POST') {
  //get uploaded files info into variables


  $name_array=$_FILES['my_files']['name'];
  $type_array=$_FILES['my_files']['type'];
  $error_array=$_FILES['my_files']['error'];
  $size_array=$_FILES['my_files']['size'];
  $tmp_name_array=$_FILES['my_files']['tmp_name'];
  $file_errors=array();
  $allowed_file_types=array('jpg','jpeg','png','pdf');
  /*getting file extension using explode and then
  getting last element of the array in case of
  more than one '.' and converting to lower case*/

  foreach ($name_array as $key=>$name) {
    //extract file extension from name
    $exploded_name=explode('.',$name);
    $ext=strtolower(end($exploded_name));
    //check if file type is allowed
    if (!in_array($ext,$allowed_file_types)&&!empty($ext)) {
      $file_errors[$name][]='Files of extensions ('.$ext.") are not allowed";
    }
    //check for upload errors
    if ($error_array[$key]==4) {
      $file_errors[$name][]='No files uploaded';
    }
    if ($size_array[$key]>2097152) {
      $file_errors[$name][]='File size exceeds 2 MB';
    }
    //proceed to file move only if error array is empty and no upload error for this file
    if (empty($file_errors[$name])&&$error_array[$key]==0) {
      $new_name=rand(0,100000000000).'.'.$ext;
      move_uploaded_file($tmp_name_array[$key],'C:\xampp\htdocs\php_projects\upload_multiple_files\uploads\\'.$new_name);
      echo "<div class='success-message'>File (".$name." ) uploaded successfully</div>";

    }



  }


}




 ?>





<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Upload Multiple Files</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css\bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.css">
  </head>
  <body >
<form class="mt-5" action="index.php" method="post" enctype="multipart/form-data">
  <div class="errors">
    <?php
    //after the looping print out the errors
    $i=0;       //index for file names array
    foreach ($file_errors as $key => $value) {
      echo 'Errors for file ( '.$name_array[$i].") :-<br>";
      $i++;
      foreach ($value as $err) {
        echo "&nbsp&nbsp&nbsp&nbsp-".$err."<br>";
      }
    }?>
  </div>
  <h2 class="mb-3">Upload Files</h2>
  <input type="file" name="my_files[]" value="" class="form-control mb-3" Multiple>
  <input type="submit" name="submit" value="Upload">

</form>




    <script src="js\jquery-3.5.1.min.js" charset="utf-8"></script>
    <script src="js\bootstrap.min.js" charset="utf-8"></script>
    <script src="js\custom.js" charset="utf-8"></script>

  </body>
</html>
