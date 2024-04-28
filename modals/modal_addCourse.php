<?php 
    // establish a connection
    require_once './connection.php';
?>

<dialog id="AddCourse" class="modal">
    <div class="wrapper">
        <div class="text"> <h1> Add Course Form </h1> <div>
        <form action="" style="width: 500px;" method="POST" autocomplete="off" enctype="multipart/form-data">


            <!-- INPUT DEPARTMENT NAME -->
            <div class="field password">
                <div class="input-area">
                <input type="text" placeholder="Course Name" name="course-name" id = "course-name" required value="">
                </div>
            </div>

            <!-- INPUT COURSE CREDITS -->
            <div class="field password">
                <div class="input-area">
                <input type="text" placeholder="Credits" name="credits" id = "credits" required value="">
                </div>
            </div>

            <!-- INPUT COURSE CREDITS -->
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
                <button type="submit" id="submit" class="okay-modal" name="submit">OK</button>
                <button onclick="closeAddCourseModal()" type="button" class="close-modal">Close</button>
            </div>
          
        </form>
    </div>

  
</dialog>

<script>

    // show modal for patient registration
    document.addEventListener('DOMContentLoaded', (event) => {
        // Open/Close Modal + get patient data base on ID
        const add_course = document.getElementById("AddCourse");

        window.openAddCourseModal = function() {
            add_course.showModal();
        }

        window.closeAddCourseModal = function() {
            add_course.close();
        }
    });

</script>


<!-- STORE NAME AND IMAGE INSIDE DATABASE -->
<?php

    // if the button "Submit" is pressed
    if(isset($_POST["submit"])){

        // store the form input for name into the $name variable
        $course_name = $_POST["course-name"];
        $credits = $_POST["credits"];
        $department_id = $_POST["department-id"];

        try {
            // query using positional parameters
            $query = "INSERT INTO courses_table (`course_name`, `credits`, `department_id`) VALUES (?, ?, ?)";

            // prepare the query
            $stmt = $connection->prepare($query);

            // bind parameters
            $stmt->bindParam(1, $course_name);
            $stmt->bindParam(2, $credits);
            $stmt->bindParam(3, $department_id);

            // execute query
            $stmt->execute();

            // check if query is true
            if($stmt->rowCount() > 0){
                echo
                "
                <script>
                    alert('Successfully Added');
                    document.location.href = 'courses.php';
                </script>
                ";
            } else {
                echo
                "
                <script>
                    alert('Failed to Add Course');
                </script>
                ";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>
