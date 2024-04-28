<!-- TRIALLLLLLLLLLLLLLLLLL -->
<dialog id="AddDepartment" class="modal">
    <div class="wrapper">
        <div class="text"> <h1> Add Department Form </h1> <div>
        <form action="" style="width: 500px;" method="POST" autocomplete="off" enctype="multipart/form-data">

            <!-- INPUT DEPARTMENT LOGO -->
            <div class="picture-input">
                <div class="input-area one">
                <input type="file" name="image" id = "image" accept=".jpg, .jpeg, .png" value="" required>
                <h6>Drag your department logo here or click in this area.</h6> 
                </div>
            </div>

            <!-- INPUT DEPARTMENT NAME -->
            <div class="field password">
                <div class="input-area">
                <input type="text" placeholder="Department Name" name="name" id = "name" required value="">
                </div>
            </div>

            <div class="button-container">
                <button type="submit" id="submit" class="okay-modal" name="submit">Submit</button>
                <button onclick="closeAddDepartmentModal()" type="button" class="close-modal">Close</button>
            </div>
          
        </form>
    </div>

  
</dialog>

<script>

    // show modal for patient registration
    document.addEventListener('DOMContentLoaded', (event) => {
        // Open/Close Modal + get patient data base on ID
        const add_department = document.getElementById("AddDepartment");

        window.openAddDepartmentModal = function() {
            add_department.showModal();
        }

        window.closeAddDepartmentModal = function() {
            add_department.close();
        }
    });

</script>


<!-- STORE NAME AND IMAGE INSIDE DATABASE -->
<?php

// establish a connection
require_once './connection.php';

// if the button "Submit" is pressed
if(isset($_POST["submit"])){

  // store the form input for name into the $name variable
  $name = $_POST["name"];

  // if the image doesn't exist
  if($_FILES["image"]["error"] == 4){
    echo
    "<script> alert('Image Does Not Exist'); </script>"
    ;
  }

  // if the image exists
  else{
    // NOTE: Associative array concept
    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png']; //only accepts these image formats
    $imageExtension = explode('.', $fileName);  //separate the words between the "."
    $imageExtension = strtolower(end($imageExtension)); //lower the case of the image extension

    // if the image type is invalid
    if ( !in_array($imageExtension, $validImageExtension) ){
      echo
      "
      <script>
        alert('Invalid Image Extension');
      </script>
      ";
    }

    // if the image is too large
    else if($fileSize > 1000000){
      echo
      "
      <script>
        alert('Image Size Is Too Large');
      </script>
      ";
    }

    // if the image is exists, valid, and not too large
    else{

      try{
        $newImageName = uniqid(); //generate a new image name
        $newImageName .= '.' . $imageExtension; //concatenate the new image name and the image extension

        move_uploaded_file($tmpName, 'img/' . $newImageName);

        //get connection
        $connection = $newconnection->openConnection();

        //query using positional parameters
        $query = "INSERT INTO departments_table(`department_logo`,`department_name`) VALUES(?,?)";
              // $query = "INSERT INTO departments_table VALUES('$newImageName', '$name')";

        //prepare the query
        $stmt = $connection->prepare($query);

        //execute query
        $query = $stmt->execute([$newImageName,$name]);

        //check if query is true
        if($query){
          echo
            "
            <script>
              alert('Successfully Added');
              document.location.href = 'departments.php';
            </script>
            "
          ;
        }
      }catch (PDOException $th){
        echo "Error Message:" .$th->getMessage();
      }

     
    }
  }
}
?>
