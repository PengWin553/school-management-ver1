<?php 
    // establish a connection
    require_once './connection.php';
?>

<dialog id="AddStudent" class="modal">
    <div class="wrapper">
        <div class="text"> <h1> Add Student Form </h1> <div>
        <form action="" style="width: 500px;" method="POST" autocomplete="off" enctype="multipart/form-data">

            <!-- INPUT STUDENT NAME -->
            <div class="field password">
                <div class="input-area">
                <input type="text" placeholder="First Name" name="student-fname" id = "student-fname" required value="">
                </div>
            </div>

            <!-- INPUT STUDENT LNAME -->
            <div class="field password">
                <div class="input-area">
                <input type="text" placeholder="Last Name" name="student-lname" id = "student-lname" required value="">
                </div>
            </div>
          
            <!-- INPUT COURSE  -->
              <div class="field password">
                <div class="input-area">
                    <select name="student-course-id">
                        <?php
                        $connection = $newconnection->openConnection();
                        $stmt =  $connection->prepare("SELECT course_id, course_name FROM courses_table ORDER BY course_id DESC");
                        $stmt->execute(); 
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($result as $d) {
                        ?>
                            <option value="<?php echo $d['course_id'] ?>"><?php echo $d['course_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <!-- INPUT DEPARTMENT  -->
            <div class="field password">
                <div class="input-area">
                    <select name="student-department-id">
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

            <!-- INPUT YEAR LEVEL -->
            <div class="field password">
                <div class="input-area">
                    <select id="student-year-level" name="student-year-level">
                        <option value="1">Year 1</option>
                        <option value="2">Year 2</option>
                        <option value="3">Year 3</option>
                        <option value="4">Year 4</option>
                    </select>
                </div>
            </div>

            <div class="button-container">
                <button type="submit" id="submit" class="okay-modal" name="submit">OK</button>
                <button onclick="closeAddStudentModal()" type="button" class="close-modal">Close</button>
            </div>
          
        </form>
    </div>
</dialog>

<script>

    // show modal for patient registration
    document.addEventListener('DOMContentLoaded', (event) => {
        // Open/Close Modal + get patient data base on ID
        const add_student = document.getElementById("AddStudent");

        window.openAddStudentModal = function() {
            add_student.showModal();
        }

        window.closeAddStudentModal = function() {
            add_student.close();
        }
    });

</script>

<!-- STORE NAME AND IMAGE INSIDE DATABASE -->
<?php

    // if the button "Submit" is pressed
    if(isset($_POST["submit"])){

        // store the form input for name into the $name variable
        $student_fname = $_POST["student-fname"];
        $student_lname = $_POST["student-lname"];
        $course_id = $_POST["student-course-id"];
        $department_id = $_POST["student-department-id"];
        $year_level = $_POST["student-year-level"];

        try {
            // query using positional parameters
            $query = "INSERT INTO students_table (`student_fname`, `student_lname`, `course_id`, `department_id`, `year_level`) VALUES (?, ?, ?, ?, ?)";

            // prepare the query
            $stmt = $connection->prepare($query);

            // bind parameters
            $stmt->bindParam(1, $student_fname);
            $stmt->bindParam(2, $student_lname);
            $stmt->bindParam(3, $course_id);
            $stmt->bindParam(4, $department_id);
            $stmt->bindParam(5, $year_level);

            // execute query
            $stmt->execute();

            // check if query is true
            if($stmt->rowCount() > 0){
                echo
                "
                <script>
                    alert('Successfully Added Student');
                    document.location.href = 'students.php';
                </script>
                ";
            } else {
                echo
                "
                <script>
                    alert('Failed to Add Student ');
                </script>
                ";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>


