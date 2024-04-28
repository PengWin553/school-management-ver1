<?php 

    require_once('../connection.php');

      //DELETE DEPARTMENT
      if(isset($_POST['deleteSemester'])){
		$semester_id =  $_POST['semester_id'];

        try{
            //get connection
            $connection = $newconnection->openConnection();
            //prepare query
            $stmt = $connection->prepare("DELETE FROM semesters_table WHERE semester_id = '$semester_id' ");
            //executre query
            $query = $stmt->execute();
            // check if query is true
			if ($query) {
				// Redirect to the same page after successful deletion
				// header('Location: ' . $_SERVER['PHP_SELF']);
                header("Location: ../semester.php");
				exit();
			}
          
        }catch (PDOException $th){
            echo "Error Message: " .$th->getMessage();
        }
    }

?>