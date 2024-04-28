<?php
require_once '../connection.php';

if (isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];

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
        $teacher_id = $row['teacher_id'];
    } else {
        echo "Subject not found";
        // You may want to redirect or handle this error differently
        exit();
    }
}
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
                    // $teacher_id = $_GET['teacher_id'];

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
                        $teacher_id = $row['teacher_id'];
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
                        <label for="teacher-id">Teacher Name:</label>
                        <select name="teacher-id" id="teacher-id">
                            <?php
                            $connection = $newconnection->openConnection();
                            $stmt =  $connection->prepare("SELECT teacher_id, teacher_fname, teacher_lname FROM teachers_table ORDER BY teacher_id DESC");
                            $stmt->execute(); 
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($result as $d) {
                                $teacher_full_name = $d['teacher_fname'] . ' ' . $d['teacher_lname'];
                                $selected = ($d['teacher_id'] == $teacher_id) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $d['teacher_id']; ?>" <?php echo $selected; ?>><?php echo $teacher_full_name; ?></option>
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

        $teacher_id = $_POST["teacher-id"];

        try{
            // get connection
            $connection = $newconnection->openConnection();
            
            // prepare query using named parameters
            $stmt = $connection->prepare("UPDATE facultysubjects_table SET teacher_id=:teacher_id WHERE subject_id = :subject_id LIMIT 1");

            // get data inputs
            $data = [
                ':teacher_id' => $teacher_id,
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
