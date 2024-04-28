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
                    <span class="text">Faculty Subjects</span>
                </div>
            </div>
            
            <!-- TABLE -->
            <div class="container">
                <table>
                    <thead>
                        <tr>
                            <th>Subject ID</th>
                            <th>Subject Name</th>
                            <th>Subject Description</th>
                            <th>Teacher</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $connection = $newconnection->openConnection();

                            $stmt = $connection->prepare("SELECT * FROM facultySubjects_table");
                            $stmt->execute(); 
                            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

                            if($result){
                                foreach ($result as $row) {
                        ?>
                                <tr>
                                    <td><?php echo $row->subject_id ?></td>
                                    <td><?php echo $row->subject_name ?></td>
                                    <td><?php echo $row->subject_description ?></td>
                                    <td><?php echo $row->teacher_id ?></td>
                                    <td>
                                        <div class="actions-container">
                                            <a href="editNDelete/editFacultySubjectTeacher.php?subject_id=<?php echo $row->subject_id ?>&&teacher_id=<?php echo $row->teacher_id ?>&&"><i class='bx bx-edit-alt action-icon'></i></a>
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
        </div>
    </section>

    <script src="js/script.js"></script>

</body>
</html>
