<?php
    // Start the session
    session_start();

    if (!isset($_SESSION["user_email"])) {
        header("location:login.php");
    }

    // Store the session value inside a variable
    $user_email = $_SESSION["user_email"];

    // Connect to your database using PDO
    $connection = new PDO("mysql:host=localhost;dbname=im2_school_db", "root", "");

    // Check for PDO connection errors
    if ($connection->errorCode() != 0) {
        die("Connection failed: " . $connection->errorInfo()[2]);
    }

    // Prepare and execute a SQL query to select some columns from the teachers_table
    $sql = "SELECT teacher_id, teacher_fname, teacher_lname, teacher_email, teacher_picture FROM teachers_table WHERE teacher_email = :user_email";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the result as an associative array
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Store the data in variables
    $teacher_id = $row['teacher_id'];
    $teacher_fname = $row['teacher_fname'];
    $teacher_lname = $row['teacher_lname'];

    // Print the data
    echo "Teacher ID: " . htmlspecialchars($teacher_id) . "<br>";
    echo "Teacher First Name: " . htmlspecialchars($teacher_fname) . "<br>";
    echo "Teacher Last Name: " . htmlspecialchars($teacher_lname) . "<br>";

    if (isset($_GET['student_id'])) {
        $student_id = $_GET['student_id'];

        // Use a new connection for the second query
        $connection = new PDO("mysql:host=localhost;dbname=im2_school_db", "root", "");

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
            $department_id = $row['department_id'];
            $year_level = $row['year_level'];
        } else {
            echo "Student not found";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School System</title>
    <!-- CSS files -->
    <link rel="stylesheet" href="css/style.css"> 
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/button.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/extra.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/actions.css">

    <!-- Iconscout CSS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        button.button {
            padding: 0;
            margin: 0;
            background: none;
            border: none;
        }

        button.button i {
            font-size: 24px; 
            color: white; 
        }

        body {
            background: white;
        }

        .main-text {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <button class="button-crud button-add" id='Add' onclick='openAddSubjectModal()'>Add Subject</button>
    </div>

    <!-- TABLE -->
    <div class="container" style="margin-top: 2rem;">
        <table>
            <thead>
                <tr>
                    <th>Grade Id</th>
                    <th>Student Name</th>
                    <th>Teacher Name</th>
                    <th>Year Level</th>
                    <th>Department Id</th>
                    <th>Subject Id</th>
                    <th>Prelim Grade</th>
                    <th>Midterm Grade</th>
                    <th>Semi Finals Grade</th>
                    <th>Finals Grade</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // ... (previous code remains unchanged)
                      require_once('connection.php'); $connection = $newconnection->openConnection();
                        $stmt = $connection->prepare("SELECT 
                                                        g.grade_id,
                                                        CONCAT(s.student_fname, ' ', s.student_lname) AS student_name,
                                                        CONCAT(t.teacher_fname, ' ', t.teacher_lname) AS teacher_name,
                                                        s.year_level,
                                                        s.department_id,
                                                        g.subject_id, 
                                                        g.prelim_grade,
                                                        g.midterm_grade,
                                                        g.semi_finals_grade,
                                                        g.finals_grade
                                                    FROM
                                                        grades_table g
                                                    INNER JOIN
                                                        students_table s ON g.student_id = s.student_id
                                                    INNER JOIN
                                                        facultysubjects_table f ON g.subject_id = f.subject_id
                                                    INNER JOIN
                                                        teachers_table t ON f.teacher_id = t.teacher_id
                                                    WHERE
                                                        t.teacher_id = :teacher_id;
                                                    ");
                        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
                        $stmt->execute(); 
                        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

                    if ($result) {
                        foreach ($result as $row) { ?>
                            <tr>
                                <td><?php echo $row->grade_id ?></td>
                                <td><?php echo $row->student_name ?></td>
                                <td><?php echo $row->teacher_name ?></td>
                                <td><?php echo $row->year_level ?></td>
                                <td><?php echo $row->department_id ?></td>
                                <td><?php echo $row->subject_id ?></td>
                                <td><?php echo $row->prelim_grade ?></td>
                                <td><?php echo $row->midterm_grade ?></td>
                                <td><?php echo $row->semi_finals_grade ?></td>
                                <td><?php echo $row->finals_grade ?></td>
                                <td>
                                    <div class="actions-container">
                                        <button>Update</button>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    }
                ?>
            </tbody>
        </table>
    </div>

    <!-- JavaScript function (add this script at the end of your HTML) -->
    <script>
        function openAddSubjectModal() {
            // Implement your modal opening logic here
            console.log("Add Subject Modal opened");
        }
    </script>
</body>
</html>
