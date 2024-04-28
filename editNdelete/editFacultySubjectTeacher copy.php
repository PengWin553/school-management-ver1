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

            <h1 class="main-text">Assign Teacher</h1>

            <!-- gets data from the url to populate the input -->
            <?php 
                if (isset($_GET['subject_id'])) {
                    $subject_id = $_GET['subject_id'];
                    // Get the teacher's fullname from the URL parameter
                    $teacher_name = $_GET['teacher_name'];

                    $connection = $newconnection->openConnection();

                    // Prepare and execute the SQL query
                    $sql = "SELECT * FROM facultysubjects_table WHERE subject_id = :subject_id";
                    $stmt = $connection->prepare($sql);
                    $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
                    $stmt->execute();

                    // Fetch the result
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Output or use the retrieved data as needed
                    if ($row) {
                        $subject_name = $row['subject_name'];
                        $subject_description = $row['subject_description'];
                        $teacher_name = $row['teacher_name'];
                    } else {
                        echo "Subject not found";
                    }
                }
            ?>
           
        </div>

        <form action="" style="width: 500px;" method="POST" autocomplete="off" enctype="multipart/form-data">
            <!-- close icon -->
            <a href="../faculty.php"><i class='bx bx-x close-icon'></i></a>
            <div class="form-contents">

            <div class="field password">
                <div class="input-area">
                    <select name="teacher-name">
                        <?php
                        $connection = $newconnection->openConnection();
                        $stmt =  $connection->prepare("SELECT teacher_id, teacher_fname, teacher_lname FROM teachers_table ORDER BY teacher_id DESC");
                        $stmt->execute(); 
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($result as $d) {
                            $teacher_fullname = $d['teacher_fname'] . ' ' . $d['teacher_lname'];
                            $selected = ($teacher_fullname == $teacher_name) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $teacher_fullname; ?>" <?php echo $selected; ?>><?php echo $teacher_fullname; ?></option>
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

        $teacher_name = $_POST["teacher-name"];

        try{
            // get connection
            $connection = $newconnection->openConnection();
            
            // prepare query using named parameters
            $stmt = $connection->prepare("UPDATE facultysubjects_table SET teacher_name=:teacher_name WHERE subject_id = :subject_id LIMIT 1");

            // get data inputs
            $data = [
                ':teacher_name' => $teacher_name,
                ':subject_id' => $subject_id,  // Add this line to bind the subject_id parameter
            ];

            // execute query
            $query = $stmt->execute($data);

            // check if query is true
            if($query){
                echo
                "
                <script>
                    alert('Successfully Updated Faculty Subject Teacher');
                    document.location.href = '../faculty.php';
                </script>
                ";
            }
        } catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }
?>
