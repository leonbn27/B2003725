<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlbanhang";

session_start();

/*
  $_SESSION["name"]  = "user";
  $_SESSION["value"] = $row['email'];
  $_SESSION[$_SESSION["name"]] = $_SESSION["value"];
  $_SESSION["fullname"] = $row['fullname'];
  $_SESSION["id"] =  $row['id'];
  $_SESSION["password"] =  $row['password'];
*/
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$oldpass = mysqli_real_escape_string($conn, $_POST["oldpass"]);
$newpass1 = mysqli_real_escape_string($conn, $_POST["newpass1"]);
$newpass2 = mysqli_real_escape_string($conn, $_POST["newpass2"]);


//$_SESSION["password"] =  $row['password']; Định nghĩa tại log_session rồi
/*Test
echo "old: " . $oldpass . "<br>";
echo "new1: " . $newpass1 . "<br>";
echo "new2: " . $newpass2 . "<br>";
echo "sess_pass: " . $_SESSION["password"] . "<br>";*/


if ($_SESSION["password"] == md5($oldpass) && $newpass1==$newpass2 && $oldpass != $newpass1) {
 
    $sql = "UPDATE `customers` SET `password` ='". md5($newpass1)."' WHERE `customers`.`email` = '". $_SESSION['value']."'";
  //echo $sql;

    if ($conn->query($sql) == TRUE) {
    echo "Doi mat khau thanh cong";
    } 
    else {
    echo "Error: " . $sql . "<br>" . $conn->error;
      //Tro ve trang dang nhap sau 3 giay
        header('Refresh: 3;url=sua_mk.php');
    }
  
} 
else if ($_SESSION["password"] != md5($oldpass)) {
  echo "Nhap sai mat khau cu";
  //Tro ve trang dang nhap sau 3 giay
  header('Refresh: 3;url=sua_mk.php');
}
else if ($newpass1!=$newpass2) {
  echo "Mat khau nhap lai khong dung";
  //Tro ve trang dang nhap sau 3 giay
  header('Refresh: 3;url=sua_mk.php');
}
else if ($oldpass == $newpass1) {
  echo "Mat khau moi khong the trung mat khau cu";
  //Tro ve trang dang nhap sau 3 giay
  header('Refresh: 3;url=sua_mk.php');
}
else {
  echo "Loi khong xac dinh";
  //Tro ve trang dang nhap sau 3 giay
  header('Refresh: 3;url=sua_mk.php');
}

$conn->close();
?>
