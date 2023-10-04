<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// set the expiration date to one hour ago
setcookie("user", "", time() - 3600);

// remove all session variables
session_unset();

// destroy the session
session_destroy();
header('Location: Login.php');
?>

</body>
</html>