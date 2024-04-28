<!-- TRIALLLLLLLLLLLLLLLLLL -->
<dialog id="AddTeacher" class="modal">
    <div class="wrapper">
        <div class="text"> <h1> Add Teacher Form </h1> <div>
        <form action="" style="width: 500px;" method="POST" autocomplete="off" enctype="multipart/form-data">

            <!-- INPUT Teacher Picture -->
            <div class="picture-input">
                <div class="input-area one">
                <input type="file" name="image" id = "image" accept=".jpg, .jpeg, .png" value="" required>
                <h6>Drag teacher picture here or click in this area.</h6> 
                </div>
            </div>

            <!-- INPUT Teacher fNAME -->
            <div class="field password">
                <div class="input-area">
                <input type="text" placeholder="Teacher First Name" name="name" id = "name" required value="">
                </div>
            </div>

            <!-- INPUT Teacher lNAME -->
            <div class="field password">
                <div class="input-area">
                <input type="text" placeholder="Teacher Last Name" name="teacher-lname" id = "teacher-lname" required value="">
                </div>
            </div>

            <!-- INPUT Teacher Email -->
            <div class="field password">
                <div class="input-area">
                <input type="email" placeholder="Teacher Email" name="teacher-email" id = "teacher-email" required value="">
                </div>
            </div>

            <!-- INPUT Teacher Password -->
            <div class="field password">
                <div class="input-area">
                <input type="password" placeholder="Teacher Password" name="teacher-password" id = "teacher-password" required value="">
                </div>
            </div>

             <!-- INPUT Department -->
             <div class="field password">
                <div class="input-area">
                    <select name="department-id">
                        <?php
                        $connection = $newconnection->openConnection();
                        $stmt =  $connection->prepare("SELECT department_id, department_name FROM departments_table ORDER BY department_id DESC");
                        $stmt->execute(); 
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($result as $d) {
                        ?>
                            <option value="<?php echo $d['department_id'] ?>"><?php echo $d['department_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="button-container">
                <button type="submit" id="submit" class="okay-modal" name="submit">Submit</button>
                <button onclick="closeAddTeacherModal()" type="button" class="close-modal">Close</button>
            </div>
          
        </form>
    </div>

  
</dialog>

<script>

    // show modal for patient registration
    document.addEventListener('DOMContentLoaded', (event) => {
        // Open/Close Modal + get patient data base on ID
        const add_department = document.getElementById("AddTeacher");

        window.openAddTeacherModal = function() {
            add_department.showModal();
        }

        window.closeAddTeacherModal = function() {
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
  $name = $_POST["name"]; //first name
  $teacher_lname = $_POST["teacher-lname"]; 
  $teacher_email= $_POST["teacher-email"]; 
  $teacher_password = $_POST["teacher-password"]; 
  $department_id = $_POST["department-id"]; 

    // HANDLE IMAGE ---->

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
        $query = "INSERT INTO teachers_table(`teacher_picture`,`teacher_fname`, `teacher_lname`,`teacher_email`, `teacher_password`,`department_id`) VALUES(?,?,?,?,?,?)";
              // $query = "INSERT INTO departments_table VALUES('$newImageName', '$name')";

        //prepare the query
        $stmt = $connection->prepare($query);

        //execute query
        $query = $stmt->execute([$newImageName,$name,$teacher_lname,$teacher_email,$teacher_password,$department_id,]);

        //check if query is true
        if($query){
          echo
            "
            <script>
              alert('Successfully Added Teacher');
              document.location.href = 'teachers.php';
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
