<?php
require_once '../connection.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../css/style.css"> 
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/button.css">
    <link rel="stylesheet" href="../css/modal.css">
    <link rel="stylesheet" href="../css/extra.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/actions.css">

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!----===== Boxicons CSS ===== -->
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>School System</title>

    <style>

        body{
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
        }
        .wrapper{
            display: inline-block;
            border-radius: 10px;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px grey;
        }

        .form-contents{
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .close-icon{
            position: absolute;
            margin-top: -7.1rem;
            margin-left: 13.8rem;
            font-size: 25px;
        }

        .okay-modal{
            width: 100%;
        }

        .main-text{
            margin-top: 10px;
        }
      
        
    </style>

</head>
<body>
    <div class="wrapper">
        <div class="text"> 

            <h1 class="main-text">Edit Student</h1>

            <?php 
                if (isset($_GET['student_id'])) {
                    $student_id = $_GET['student_id'];
                    // echo $subject_id;

                    $connection = $newconnection->openConnection();

                    // Prepare and execute the SQL query
                    $sql = "SELECT * FROM students_table WHERE student_id = :student_id";
                    $stmt = $connection->prepare($sql);
                    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                    $stmt->execute();

                    // Fetch the result
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Output or use the retrieved data as needed
                    if ($row) {
                        $student_fname = $row['student_fname'];
                        $student_lname = $row['student_lname'];
                        $student_email = $row['student_email'];
                        $department_id = $row['department_id'];
                        $course_id = $row['course_id'];
                        $year_level = $row['year_level'];
                    } else {
                        echo "Student not found";
                    }
                }
            ?>
        </div>

        <form action="" style="width: 500px;" method="POST" autocomplete="off" enctype="multipart/form-data">
            <!-- close icon -->
            <a href="../students.php"><i class='bx bx-x close-icon'></i></a>
            <div class="form-contents">

                <!-- INPUT STUDENT FIRST NAME -->
                <div class="field password">
                    <div class="input-area">
                        <input type="text" placeholder="Student First Name" name="student-fname" id="student-fname" required value="<?php echo $student_fname; ?>">
                    </div>
                </div>

                <!-- INPUT STUDENT lAST NAME -->
                  <div class="field password">
                    <div class="input-area">
                        <input type="text" placeholder="Student Last Name" name="student-lname" id="student-lname" required value="<?php echo $student_lname; ?>">
                    </div>
                </div>

                 <!-- INPUT STUDENT EMAIL -->
                 <div class="field password">
                    <div class="input-area">
                        <input type="email" placeholder="Student Email" name="student-email" id="student-email" required value="<?php echo $student_email; ?>">
                    </div>
                </div>


                <div class="field password">
                    <div class="input-area">
                            <select name="course-id">
                                <?php
                                $connection = $newconnection->openConnection();
                                $stmt =  $connection->prepare("SELECT course_id, course_name FROM courses_table ORDER BY course_id DESC");
                                $stmt->execute(); 
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($result as $d) {
                                    $selected = ($d['course_id'] == $course_id) ? 'selected' : '';
                                ?>
                                    <option value="<?php echo $d['course_id'] ?>" <?php echo $selected ?>><?php echo $d['course_name'] ?></option>
                                <?php } ?>
                            </select>
                    </div>
                </div>

                <div class="field password">
                    <div class="input-area">
                            <select name="department-id">
                                <?php
                                $connection = $newconnection->openConnection();
                                $stmt =  $connection->prepare("SELECT department_id, department_name FROM departments_table ORDER BY department_id DESC");
                                $stmt->execute(); 
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($result as $d) {
                                    $selected = ($d['department_id'] == $department_id) ? 'selected' : '';
                                ?>
                                    <option value="<?php echo $d['department_id'] ?>" <?php echo $selected ?>><?php echo $d['department_name'] ?></option>
                                <?php } ?>
                            </select>
                    </div>
                </div>

               <!-- INPUT YEAR LEVEL -->
                <div class="field password">
                    <div class="input-area">
                        <select id="student-year-level" name="student-year-level">
                            <?php
                            $selected_year_level = isset($year_level) ? $year_level : ''; // Retrieve the year level from the database
                            $year_levels = [1, 2, 3, 4]; // Define the year levels

                            foreach ($year_levels as $level) {
                                $selected = ($level == $selected_year_level) ? 'selected' : '';
                                echo "<option value=\"$level\" $selected>Year $level</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="button-container">
                    <button type="submit" id="submit" class="okay-modal" name="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<?php 
    // if the button "Submit" is pressed
    if(isset($_POST["submit"])){

        // store the form input for name into the $name variable
        $student_fname = $_POST["student-fname"];
        $student_lname = $_POST["student-lname"];
        $student_email = $_POST["student-email"];
        $course_id = $_POST["course-id"];
        $department_id = $_POST["department-id"];
        $year_level = $_POST["student-year-level"];

        try{
            // get connection
            $connection = $newconnection->openConnection();
            
            // prepare query using named parameters
            $stmt = $connection->prepare("UPDATE students_table SET student_fname=:student_fname, student_lname=:student_lname, student_email=:student_email, course_id=:course_id, department_id=:department_id, year_level=:year_level WHERE student_id = :student_id LIMIT 1");

            // get data inputs
            $data = [
                ':student_fname' => $student_fname,
                ':student_lname' => $student_lname,
                ':student_email' => $student_email,
                ':course_id' => $course_id,
                ':department_id' => $department_id,
                ':year_level' => $year_level,
                ':student_id' => $student_id,  // Add this line to bind the subject_id parameter
            ];

            // execute query
            $query = $stmt->execute($data);

            // check if query is true
            if($query){
                echo
                "
                <script>
                    alert('Successfully Updated Student');
                    document.location.href = '../students.php';
                </script>
                ";
            }
        } catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }
?>
