<?php
    // Start the session
    session_start();

    if(!isset($_SESSION["user_email"]))
    {
        header("location:login.php");
    }

    // Store the session value inside a variable
    $user_email = $_SESSION["user_email"];

    // Connect to your database using PDO
    $connection = new PDO("mysql:host=localhost;dbname=im2_school_db", "root", "");

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
?>



<!DOCTYPE html>
<html>
<head>
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

    <title>School System</title>
    <style>
        button.button {
            padding: 0;
            margin: 0;
            background: none;
            border: none;
        }

        button.button i {
            font-size: 24px; /* Adjust the size according to your needs */
            color: white; /* Set the color you want for the icon */
        }
    </style>
</head>
<body>

<h1>THIS IS TEACHER HOME PAGE</h1> <?php echo $_SESSION['user_email'] ?>

 <!-- TABLE -->
 <div class="container" style="margin-top: 0.5rem;">
                <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Department Name</th>
                                <th>Year Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <tbody>
                    <?php
	                    require_once('connection.php');

                            $connection = $newconnection->openConnection();

                            $stmt = $connection->prepare("
                                                            SELECT 
                                                                st.student_id,
                                                                st.student_fname,
                                                                st.student_lname,
                                                                d.department_name,
                                                                st.year_level
                                                            FROM 
                                                                students_table st
                                                                JOIN departments_table d ON st.department_id = d.department_id
                                                                JOIN courses_table c ON st.course_id = c.course_id
                                                            ORDER BY 
                                                                st.student_id DESC
                                                        ");
                            $stmt->execute(); 
                            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

                            if($result){
                                foreach ($result as $row) {
                        ?>
                                <tr>
                                    <td><?php echo $row->student_id ?></td>
                                    <td><?php echo $row->student_fname ?></td>
                                    <td><?php echo $row->student_lname ?></td>
                                    <td><?php echo $row->department_name ?></td>
                                    <td><?php echo $row->year_level ?></td>
                                    <td>
                                        <div class="actions-container">
                                            <a href="editNDelete/studentGrades.php?student_id=<?php echo $row->student_id ?>">Grades</i></a>
                                           
                                        </div>
                                    </td>
                                </tr>
                        <?php 
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>

<a href="logout.php">Logout</a>
</body>
</html>
