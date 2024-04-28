<?php 

    require_once('../connection.php');

      //DELETE DEPARTMENT
      if(isset($_POST['deleteDepartment'])){
		$department_id =  $_POST['department_id'];

        try{
            //get connection
            $connection = $newconnection->openConnection();
            //prepare query
            $stmt = $connection->prepare("DELETE FROM departments_table WHERE department_id = '$department_id' ");
            //executre query
            $query = $stmt->execute();
            // check if query is true
			if ($query) {
				// Redirect to the same page after successful deletion
				// header('Location: ' . $_SERVER['PHP_SELF']);
                header("Location: ../departments.php");
				exit();
			}
          
        }catch (PDOException $th){
            echo "Error Message: " .$th->getMessage();
        }
    }

?>