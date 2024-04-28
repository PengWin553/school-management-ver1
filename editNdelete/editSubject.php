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

            <h1 class="main-text">Edit Subject</h1>

            <?php 
                if (isset($_GET['subject_id'])) {
                    $subject_id = $_GET['subject_id'];
                    // echo $subject_id;

                    $connection = $newconnection->openConnection();

                    // Prepare and execute the SQL query
                    $sql = "SELECT * FROM subjects_table WHERE subject_id = :subject_id";
                    $stmt = $connection->prepare($sql);
                    $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
                    $stmt->execute();

                    // Fetch the result
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Output or use the retrieved data as needed
                    if ($row) {
                        $subject_name = $row['subject_name'];
                        $subject_description = $row['subject_description'];
                        $course_id = $row['course_id'];
                    } else {
                        echo "Subject not found";
                    }
                }
            ?>
        </div>

        <form action="" style="width: 500px;" method="POST" autocomplete="off" enctype="multipart/form-data">
            <!-- close icon -->
            <a href="../subjects.php"><i class='bx bx-x close-icon'></i></a>
            <div class="form-contents">

                <!-- INPUT COURSE NAME -->
                <div class="field password">
                    <div class="input-area">
                        <input type="text" placeholder="Subject Name" name="subject-name" id="subject-name" required value="<?php echo $subject_name; ?>">
                    </div>
                </div>


                  <!-- INPUT COURSE CREDITS -->
                <div class="field password">
                    <div class="input-area">
                        <input type="text" placeholder="Subject Description" name="subject-description" id = "subject-description" required value="<?php echo $subject_description; ?>">
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
        $subject_name = $_POST["subject-name"];
        $subject_description = $_POST["subject-description"];
        $course_id = $_POST["course-id"];

        try{
            // get connection
            $connection = $newconnection->openConnection();
            
            // prepare query using named parameters
            $stmt = $connection->prepare("UPDATE subjects_table SET subject_name=:subject_name, subject_description=:subject_description, course_id=:course_id WHERE subject_id = :subject_id LIMIT 1");

            // get data inputs
            $data = [
                ':subject_name' => $subject_name,
                ':subject_description' => $subject_description,
                ':course_id' => $course_id,
                ':subject_id' => $subject_id,  // Add this line to bind the subject_id parameter
            ];

            // execute query
            $query = $stmt->execute($data);

            // check if query is true
            if($query){
                echo
                "
                <script>
                    alert('Successfully Updated Subject');
                    document.location.href = '../subjects.php';
                </script>
                ";
            }
        } catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }
?>
