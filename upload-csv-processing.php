
<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($fileType != "csv" ) {
  echo "Sorry, only CSV files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
   
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
	echo '<br>';
	
    //Bat dau dua vao CSDL---------------------------------------------------

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "qlbanhang";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

    //Read-csv
    $csv = array();
    $name_file = $_FILES["fileToUpload"]["name"];
    $lines = file($name_file, FILE_IGNORE_NEW_LINES);

    //dua du lieu tu file csv vao mang:
    foreach ($lines as $key => $value)
    {
        $csv[$key] = str_getcsv($value);

        //Chay lenh sql
        $date = date_create($csv[$key][3]);
        
        $sql = "INSERT INTO customers (id, fullname, email, birthday, password, img_profile) 
            VALUES ('".$csv[$key][0]."','".$csv[$key][1]."', '".$csv[$key][2]."', '".$date ->format('Y-m-d') ."','".md5($csv[$key][4])."','".$csv[$key][5]."')";
        echo $sql."<br>";
        if ($conn->query($sql) == TRUE) {
        echo "Them sinh vien thanh cong <br><br>";
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    //Read-csv xong

    $conn->close();

  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>
