<?php 
    // establish a connection
    require_once './connection.php';
?>

<dialog id="AddSemester" class="modal">
    <div class="wrapper">
        <div class="text"> <h1> Add Semester Form </h1> <div>
        <form action="" style="width: 500px;" method="POST" autocomplete="off" enctype="multipart/form-data">


            <!-- INPUT SEMESTER YEAR -->
            <div class="field password">
                <div class="input-area">
                    <select id="semester_year" name="semester-year">
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                    </select>
                </div>
            </div>

              <!-- INPUT YEAR LEVEL -->
            <div class="field password">
                <div class="input-area">
                    <select id="year-level" name="year-level">
                        <option value="Year 1">Year 1</option>
                        <option value="Year 2">Year 2</option>
                        <option value="Year 3">Year 3</option>
                        <option value="Year 4">Year 4</option>
                    </select>
                </div>
            </div>

            <!-- INPUT SUBJECT -->
            <div class="field password">
                <div class="input-area">
                    <select name="subject-name">
                        <?php
                        $connection = $newconnection->openConnection();
                        $stmt =  $connection->prepare("SELECT subject_id, subject_name FROM subjects_table ORDER BY subject_id DESC");
                        $stmt->execute(); 
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($result as $d) {
                        ?>
                            <option value="<?php echo $d['subject_name'] ?>"><?php echo $d['subject_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="button-container">
                <button type="submit" id="submit" class="okay-modal" name="submit">OK</button>
                <button onclick="closeAddSemesterModal()" type="button" class="close-modal">Close</button>
            </div>
          
        </form>
    </div>

  
</dialog>

<script>

    // show modal for patient registration
    document.addEventListener('DOMContentLoaded', (event) => {
        // Open/Close Modal + get patient data base on ID
        const add_semester = document.getElementById("AddSemester");

        window.openAddSemesterModal = function() {
            add_semester.showModal();
        }

        window.closeAddSemesterModal = function() {
            add_semester.close();
        }
    });

</script>


<!-- STORE NAME AND IMAGE INSIDE DATABASE -->
<?php

    // if the button "Submit" is pressed
    if(isset($_POST["submit"])){

        // store the form input for name into the $name variable
        $semester_year = $_POST["semester-year"];
        $year_level = $_POST["year-level"];
        $subject_name = $_POST["subject-name"];

        try {
            // query using positional parameters
            $query = "INSERT INTO semesters_table (`semester_year`, `year_level`, `subject_name`) VALUES (?, ?, ?)";

            // prepare the query
            $stmt = $connection->prepare($query);

            // bind parameters
            $stmt->bindParam(1, $semester_year);
            $stmt->bindParam(2, $year_level);
            $stmt->bindParam(3, $subject_name);

            // execute query
            $stmt->execute();

            // check if query is true
            if($stmt->rowCount() > 0){
                echo
                "
                <script>
                    alert('Successfully Added');
                    document.location.href = 'semester.php';
                </script>
                ";
            } else {
                echo
                "
                <script>
                    alert('Failed to Add Semester');
                </script>
                ";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>
