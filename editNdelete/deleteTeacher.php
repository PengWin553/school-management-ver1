<?php 

    require_once('../connection.php');

      //DELETE DEPARTMENT
      if(isset($_POST['deleteTeacher'])){
		$teacher_id =  $_POST['teacher_id'];

        try{
            //get connection
            $connection = $newconnection->openConnection();
            //prepare query
            $stmt = $connection->prepare("DELETE FROM teachers_table WHERE teacher_id = '$teacher_id' ");
            //executre query
            $query = $stmt->execute();
            // check if query is true
			if ($query) {
				// Redirect to the same page after successful deletion
				// header('Location: ' . $_SERVER['PHP_SELF']);
                header("Location: ../teachers.php");
				exit();
			}
          
        }catch (PDOException $th){
            echo "Error Message: " .$th->getMessage();
        }
    }

?>