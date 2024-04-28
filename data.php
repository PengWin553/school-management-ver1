<!-- establish a connection -->
<?php
require 'connection.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Data</title>
  </head>
  <body>
    <!-- TABLE -->
    <table border = 1 cellspacing = 0 cellpadding = 10>
      <thead>
        <tr>
          <td>Id</td>
          <td>Name</td>
          <td>Image</td>
          <td>Action</td>
        </tr>
      </thead>

      <!-- 
        // select the row data from the "accounts" table if the user's email and password have matching values with that table
        $select = mysqli_query($conn, "SELECT *  FROM accounts WHERE email = '$email' AND password = '$password' ");

        // get the row data
        $row = mysqli_fetch_array($select);
       -->

      <tbody>
        <?php
        $rows = mysqli_fetch_array($conn, "SELECT * FROM departments_table ORDER BY department_id DESC")
        ?>

        <?php foreach ($rows as $row) : ?>
        <tr>
          <td><?php echo $row["department_id"]; ?></td>
          <td><?php echo $row["department_name"]; ?></td>
          <td> <img src="img/<?php echo $row["department_logo"]; ?>" width = 200 title="<?php echo $row['department_logo']; ?>"> </td>
          <td>
            <button>Edit</button>
            <button>Delete</button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <br>
    <a href="../school3">Upload Image File</a>
  </body>
</html>
