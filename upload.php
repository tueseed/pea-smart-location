<!DOCTYPE html>
<html>
<head>
  <title>อัพโหลดไฟล์ฐานข้อมูลสำหรับ PEA SMART LOCATION</title>
</head>
<body>
  <form enctype="multipart/form-data" action="upload.php" method="POST">
    <p>อัพโหลดไฟล์ฐานข้อมูลสำหรับ PEA SMART LOCATION</p>
    <input type="file" name="uploaded_file"></input><br />
    <input type="submit" value="Upload"></input>
  </form>
</body>
</html>
<?PHP
  if(!empty($_FILES['uploaded_file']))
  {
    $path = "pea-smart-location/";
    $path = $path . basename( $_FILES['uploaded_file']['name']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
      echo "The file ".  basename( $_FILES['uploaded_file']['name']). 
      " has been uploaded";
    } else{
        echo "There was an error uploading the file, please try again!";
    }
  }
?>
