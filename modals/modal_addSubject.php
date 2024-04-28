<?php 
    // establish a connection
    require_once './connection.php';
?>

<dialog id="AddSubject" class="modal">
    <div class="wrapper">
        <div class="text"> <h1> Add Subject Form </h1> <div>
        <form action="" style="width: 500px;" method="POST" autocomplete="off" enctype="multipart/form-data">

            <!-- INPUT SUBJECT NAME -->
            <div class="field password">
                <div class="input-area">
                <input type="text" placeholder="Subject Name" name="subject-name" id = "subject-name" required value="">
                </div>
            </div>

            <!-- INPUT SUBJECT DESCRIPTION -->
            <div class="field password">
                <div class="input-area">
                <input type="text" placeholder="Subject Descripition" name="subject-description" id = "subject-description" required value="">
                </div>
            </div>

            <!-- INPUT COURSE  -->
            <div class="field password">
                <div class="input-area">
                    <select name="course-id">
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

            <div class="button-container">
                <button type="submit" id="submit" class="okay-modal" name="submit">OK</button>
                <button onclick="closeAddSubjectModal()" type="button" class="close-modal">Close</button>
            </div>
          
        </form>
    </div>

  
</dialog>

<script>

    // show modal for patient registration
    document.addEventListener('DOMContentLoaded', (event) => {
        // Open/Close Modal + get patient data base on ID
        const add_subject = document.getElementById("AddSubject");

        window.openAddSubjectModal = function() {
            add_subject.showModal();
        }

        window.closeAddSubjectModal = function() {
            add_subject.close();
        }
    });

</script>


<!-- STORE NAME AND IMAGE INSIDE DATABASE -->
<?php

    // if the button "Submit" is pressed
    if(isset($_POST["submit"])){

        // store the form input for name into the $name variable
        $subject_name = $_POST["subject-name"];
        $subject_description = $_POST["subject-description"];
        $course_id = $_POST["course-id"];

        try {
            // query using positional parameters
            $query = "INSERT INTO subjects_table (`subject_name`, `subject_description`, `course_id`) VALUES (?, ?, ?)";

            // prepare the query
            $stmt = $connection->prepare($query);

            // bind parameters
            $stmt->bindParam(1, $subject_name);
            $stmt->bindParam(2, $subject_description);
            $stmt->bindParam(3, $course_id);

            // execute query
            $stmt->execute();

            // check if query is true
            if($stmt->rowCount() > 0){
                echo
                "
                <script>
                    alert('Successfully Added');
                    document.location.href = 'subjects.php';
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


