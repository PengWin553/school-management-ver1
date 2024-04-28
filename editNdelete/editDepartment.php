<?php
require_once '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department_id = $_GET['department_id'];
    $department_name = $_POST['name'];
    $current_image = $_POST['image_old']; // Change to 'image_old'

    // Check if a new image is selected
    if (!empty($_FILES['image']['name'])) {
        // Upload the new image and update the $current_image variable
        $uploaded_image = uploadImage(); // Uncomment this line
        if ($uploaded_image) {
            $current_image = $uploaded_image;
        }
    }

    // Update the department record in the database
    $connection = $newconnection->openConnection();
    $sql = "UPDATE departments_table SET department_name = :department_name, department_logo = :department_logo WHERE department_id = :department_id";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':department_name', $department_name, PDO::PARAM_STR);
    $stmt->bindParam(':department_logo', $current_image, PDO::PARAM_STR);
    $stmt->bindParam(':department_id', $department_id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        // Successfully updated, you can redirect or display a success message
        header("Location: ../departments.php");
        exit();
    } else {
        echo "Error updating department";
    }
}

// Function to upload image
function uploadImage() {
    // Add your image upload logic here
    // Make sure to handle errors and return the uploaded image filename
    // Example:
    // $target_dir = "uploads/";
    // $target_file = $target_dir . basename($_FILES["image"]["name"]);
    // move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    // return basename($_FILES["image"]["name"]);

    // For simplicity, you may use the commented-out code above or replace it with your own logic
    return null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../css/style.css"> 
    <!-- <link rel="stylesheet" href="../css/table.css"> -->
    <link rel="stylesheet" href="../css/button.css">
    <!-- <link rel="stylesheet" href="../css/modal.css"> -->
    <link rel="stylesheet" href="../css/extra.css">
    <link rel="stylesheet" href="../css/form.css">
    <!-- <link rel="stylesheet" href="../css/actions.css"> -->

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!----===== Boxicons CSS ===== -->
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Departments</title>

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
            margin-top: -5rem;
            margin-left: 14rem;
            font-size: 20px;
        }

        
    </style>

</head>
<body>
    <div class="wrapper">
        <div class="text"> 
            <h1 class="main-text">
                Edit Department
                <?php 
                if (isset($_GET['department_id'])) {
                    $department_id = $_GET['department_id'];
                    echo $department_id;

                    $connection = $newconnection->openConnection();

                    // Prepare and execute the SQL query
                    $sql = "SELECT * FROM departments_table WHERE department_id = :department_id";
                    $stmt = $connection->prepare($sql);
                    $stmt->bindParam(':department_id', $department_id, PDO::PARAM_INT);
                    $stmt->execute();

                    // Fetch the result
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Output or use the retrieved data as needed
                    if ($row) {
                        $department_name = $row['department_name'];
                        $department_logo = $row['department_logo'];
                    } else {
                        echo "Department not found";
                    }
                }

                // Check if the form is submitted
                if (isset($_POST['submit'])) {
                    // Get the input values
                    $name = $_POST['name'];
                    $image_old = $_POST['image_old'];

                    // Initialize the image variable
                    $image = $image_old;

                    // Check if the user has uploaded a new image file
                    if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                        // Get the image file information
                        $image_name = $_FILES['image']['name'];
                        $image_type = $_FILES['image']['type'];
                        $image_size = $_FILES['image']['size'];
                        $image_error = $_FILES['image']['error'];
                        $image_tmp = $_FILES['image']['tmp_name'];

                        // Validate the image file type
                        $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
                        if (!in_array($image_type, $allowed_types)) {
                            echo "Invalid image file type";
                            exit();
                        }

                        // Validate the image file size
                        $max_size = 2 * 1024 * 1024; // 2 MB
                        if ($image_size > $max_size) {
                            echo "Image file size is too large";
                            exit();
                        }

                        // Validate the image file error status
                        if ($image_error != 0) {
                            echo "Image file upload error";
                            exit();
                        }

                        // Verify that the file is an image
                        if (!getimagesize($image_tmp)) {
                            echo "File is not an image";
                            exit();
                        }

                        // Generate a unique name for the image file
                        $image_new_name = uniqid() . '.' . pathinfo($image_name, PATHINFO_EXTENSION);

                        // Set the target file path
                        $target_file = "../img/" . $image_new_name;

                        // Move the uploaded file to the upload folder
                        if (move_uploaded_file($image_tmp, $target_file)) {
                            // Delete the old image file from the upload folder
                            unlink("../img/" . $image_old);

                            // Set the image variable to the new image name
                            $image = $image_new_name;
                        } else {
                            echo "Image file upload failed";
                            exit();
                        }
                    }

                    // Prepare and execute the update query
                    $sql = "UPDATE departments_table SET department_name = :name, department_logo = :image WHERE department_id = :id";
                    $stmt = $connection->prepare($sql);
                    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt->bindParam(':image', $image, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $department_id, PDO::PARAM_INT);
                    $stmt->execute();

                    // Redirect to the departments page
                    header("Location: ../departments.php");
                }
                ?>
            </h1>
        </div>
        <form action="" style="width: 500px;" method="POST" autocomplete="off" enctype="multipart/form-data">
            <a href="../departments.php"><i class='bx bx-x close-icon'></i></a>
            <div class="form-contents">

                <!-- THE DEPARTMENT LOGO FETCHED-->
                <div class="picture-input" style="background: pink; display: flex; justify-content: center; height: 150px;">
                    <div class="image-container" style="">
                    <div class="input-area">
                        <input type="file" name="image" class="">
                            <input type="hidden" name="image_old" value="<?php echo $department_logo; ?>">
                            <img src="../img/<?php echo $department_logo; ?>" title="<?php echo $department_logo; ?>" width="50%;" style="max-height: 50%;" alt="image">
                        </div>
                    </div>
                </div> <br> <br> <br>

                <!-- INPUT DEPARTMENT NAME -->
                <div class="field password">
                    <div class="input-area">
                        <input type="text" placeholder="Department Name" name="name" id="name" required value="<?php echo $department_name; ?>">
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

// if(isset($_POST['submit'])){
//     $name = $_POST['name'];
//     $new_image = $_FILES['image']['name'];
//     $old_iamge = $_POST['image_old'];

//     if($new_image != ''){
//         $update_filename = $new_image;
//     }else{
//         $update_filename = $old_image;
//     }
// }
    


?>