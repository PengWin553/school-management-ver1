<?php
    session_start();

    if(!isset($_SESSION["user_email"]))
    {
        header("location:login.php");
    }

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<h1>THIS IS STUDENT HOME PAGE</h1><?php echo $_SESSION["user_email"] ?>

<a href="logout.php">Logout</a>
</body>
</html>