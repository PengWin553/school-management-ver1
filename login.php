
<?php

   // CONNECT TO DB WITH PDO
   $host = 'localhost';
   $db   = 'im2_school_db';
   $user = 'root';
   $pass = '';
   $charset = 'utf8mb4';

   $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
   $opt = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
      PDO::ATTR_EMULATE_PREPARES   => false,
   ];
   $pdo = new PDO($dsn, $user, $pass, $opt);

   $error_msg = NULL;

   // START SESSION
   session_start();

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $user_email = $_POST["user_email"];
      $user_password = $_POST["user_password"];

      $stmt = $pdo->prepare('SELECT * FROM users_table WHERE user_email = ? AND user_password = ?');
      $stmt->execute([$user_email, $user_password]);
      $user = $stmt->fetch();

      if ($user) {
            $_SESSION["user_email"] = $user_email;

            if($user->user_type == "teacher"){
               header("location: teacher-home.php");
            }
            elseif ($user->user_type == "student"){
               header("location: student-home.php");
            }
            elseif ($user->user_type == "admin"){
               header("location: index.php");
            }

      }else {
         $error_msg =  "Email or password incorrect";
      }
   }
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Login Form</title>
      <link rel="stylesheet" href="css/login.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
   </head>
   <body>
      <div class="center">
         <div class="container">

            <div class="text"> Login </div>

            <?php if (!empty($error_msg)): ?>
               <div class="error-msg-container" style="">
                  <?php echo $error_msg ?>
               </div>
            <?php endif; ?>

            <form action="#" method="POST">
               <div class="data">
                  <label>Email or Phone</label>
                  <input type="text" required name="user_email">
               </div>
               <div class="data">
                  <label>Password</label>
                  <input type="password" required name="user_password">
               </div>
               <div class="forgot-pass">
                  <a href="#">Forgot Password?</a>
               </div>
               <div class="btn">
                  <div class="inner"></div>
                  <button type="submit">login</button>
               </div>
            </form>
         </div>
      </div>
   </body>
</html>
