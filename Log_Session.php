<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlbanhang";

/*gán
$cookie_name = "user";
$_SESSION["favcolor"] = "green";
khởi tạo
session_start();
lấy giá trị 
$_COOKIE[$cookie_name]
$_SESSION["favcolor"]
*/
session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//Cách cũ
//$sql = "select id, fullname, email from customers where email = '".$_POST["email"]."' and password = '".md5($_POST["pass"])."'";

//Cách mới
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = mysqli_real_escape_string($conn, $_POST["pass"]);
$sql = "select id, fullname, email, password from customers where email = '".$email."' and password = '".md5($password)."'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
 
  $row = $result->fetch_assoc();
  
  $_SESSION["name"]  = "user";
  $_SESSION["value"] = $row['email'];
  //setcookie($_SESSION["name"], $_SESSION["value"], time() + (86400 / 24), "/");
  //setcookie("fullname", $row['fullname'], time() + (86400 / 24), "/");
  //setcookie("id", $row['id'], time() + (86400 / 24), "/");
  $_SESSION[$_SESSION["name"]] = $_SESSION["value"];
  $_SESSION["fullname"] = $row['fullname'];
  $_SESSION["id"] =  $row['id'];
  $_SESSION["password"] =  $row['password'];


  header('Location: homepage_Session.php');
  
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  //Tro ve trang dang nhap sau 3 giay
  header('Refresh: 3;url=login.php');

}

$conn->close();
?>
