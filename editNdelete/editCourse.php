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

            <h1 class="main-text">Edit Course</h1>

            <?php 
                if (isset($_GET['course_id'])) {
                    $course_id = $_GET['course_id'];
                    // echo $course_id;

                    $connection = $newconnection->openConnection();

                    // Prepare and execute the SQL query
                    $sql = "SELECT * FROM courses_table WHERE course_id = :course_id";
                    $stmt = $connection->prepare($sql);
                    $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
                    $stmt->execute();

                    // Fetch the result
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Output or use the retrieved data as needed
                    if ($row) {
                        $course_name = $row['course_name'];
                        $credits = $row['credits'];
                        $department_id = $row['department_id'];
                    } else {
                        echo "Department not found";
                    }
                }
            ?>
        </div>

        <form action="" style="width: 500px;" method="POST" autocomplete="off" enctype="multipart/form-data">
            <!-- close icon -->
            <a href="../courses.php"><i class='bx bx-x close-icon'></i></a>
            <div class="form-contents">

                <!-- INPUT COURSE NAME -->
                <div class="field password">
                    <div class="input-area">
                        <input type="text" placeholder="Course Name" name="course_name" id="course_name" required value="<?php echo $course_name; ?>">
                    </div>
                </div>


                  <!-- INPUT COURSE CREDITS -->
                <div class="field password">
                    <div class="input-area">
                        <input type="text" placeholder="Credits" name="credits" id = "credits" required value="<?php echo $credits; ?>">
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
        $course_name = $_POST["course_name"];
        $credits = $_POST["credits"];
        $department_id = $_POST["department-id"];

        try{
            // get connection
            $connection = $newconnection->openConnection();
            
            // prepare query using named parameters
            $stmt = $connection->prepare("UPDATE courses_table SET course_name=:course_name, credits=:credits, department_id=:department_id WHERE course_id = :course_id LIMIT 1");

            // get data inputs
            $data = [
                ':course_name' => $course_name,
                ':credits' => $credits,
                ':department_id' => $department_id,
                ':course_id' => $course_id,  // Add this line to bind the course_id parameter
            ];

            // execute query
            $query = $stmt->execute($data);

            // check if query is true
            if($query){
                echo
                "
                <script>
                    alert('Successfully Updated Course');
                    document.location.href = '../courses.php';
                </script>
                ";
            }
        } catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }
?>
