<?php 

    require_once('../connection.php');

      //DELETE DEPARTMENT
      if(isset($_POST['deleteCourse'])){
		$course_id =  $_POST['course_id'];

        try{
            //get connection
            $connection = $newconnection->openConnection();
            //prepare query
            $stmt = $connection->prepare("DELETE FROM courses_table WHERE course_id = '$course_id' ");
            //executre query
            $query = $stmt->execute();
            // check if query is true
			if ($query) {
				// Redirect to the same page after successful deletion
				// header('Location: ' . $_SERVER['PHP_SELF']);
                header("Location: ../courses.php");
				exit();
			}
          
        }catch (PDOException $th){
            echo "Error Message: " .$th->getMessage();
        }
    }

?>