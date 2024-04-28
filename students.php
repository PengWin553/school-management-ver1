<!-- establish a connection and session -->
<?php 
	require_once('connection.php');

	session_start();

    if(!isset($_SESSION["user_email"]))
    {
        header("location:login.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
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

    <?php include 'sidebar.php' ?>

    <section class="dashboard">

        <!-- HEADER -->
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>

            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
        </div>

        <!-- HERO -->
        <div class="dash-content">

            <!-- MARKER -->
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Students</span>
                </div>
            </div>

            <!-- Add Subject Button -->
            <div class="button-container">
                <button class="button-crud button-add" id='addSubject' onclick='openAddStudentModal()'>Add Student</button>
            </div>
            
            <!-- TABLE -->
            <div class="container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Student Email</th>
                            <th>Department Name</th>
                            <th>Course Name</th>
                            <th>Year Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $connection = $newconnection->openConnection();

                            $stmt = $connection->prepare("
                                                            SELECT 
                                                                st.student_id,
                                                                st.student_fname,
                                                                st.student_lname,
                                                                st.student_email,
                                                                d.department_name,
                                                                c.course_name,
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
                                    <td><?php echo $row->student_email ?></td>
                                    <td><?php echo $row->department_name ?></td>
                                    <td><?php echo $row->course_name ?></td>
                                    <td><?php echo $row->year_level ?></td>
                                    <td>
                                        <div class="actions-container">
                                            <a href="editNDelete/editStudent.php?student_id=<?php echo $row->student_id ?>"><i class='bx bx-edit-alt action-icon'></i></a>
                                            <form action="editNDelete/deleteStudent.php" method="POST">
                                                <input type="hidden" name="student_id" value="<?php echo $row->student_id ?>">
                                                <button class="button" type="submit" onclick="return confirm('Are you sure you want to delete this?')" name='deleteStudent'><i class='bx bx-trash action-icon'></i></button>
                                            </form>
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
            
            <!-- Attach Add Subject Modal Form -->
            <?php require_once('modals/modal_addStudent.php');?>

        </div>
    </section>

    <script src="js/script.js"></script>

</body>
</html>
