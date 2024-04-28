<?php 

    require_once('../connection.php');

      //DELETE DEPARTMENT
      if(isset($_POST['deleteSubject'])){
		$subject_id =  $_POST['subject_id'];

        try{
            //get connection
            $connection = $newconnection->openConnection();
            //prepare query
            $stmt = $connection->prepare("DELETE FROM subjects_table WHERE subject_id = '$subject_id' ");
            //executre query
            $query = $stmt->execute();
            // check if query is true
			if ($query) {
				// Redirect to the same page after successful deletion
				// header('Location: ' . $_SERVER['PHP_SELF']);
                header("Location: ../subjects.php");
				exit();
			}
          
        }catch (PDOException $th){
            echo "Error Message: " .$th->getMessage();
        }
    }

?>