<?php
$departmentId = $_POST['departmentId'];

// include '../connection.php';

$conn = mysqli_connect("localhost", "root", "", "dental_clinic_db");



// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use prepared statement to prevent SQL injection
$query = "SELECT * FROM departments_table WHERE department_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $departmentId); // "i" means int
$stmt->execute();
$result = $stmt->get_result();

// Check if a row is returned
if ($result->num_rows > 0) {
    $departmentDetails = $result->fetch_assoc();

    //Format time
    // $departmentDetails['formatted_timestamp'] = date('Y-m-d h:i A', strtotime($departmentDetails['create_date']));
    echo json_encode($departmentDetails);
} else {
    echo json_encode(array('error' => 'Patient not found'));
}

$stmt->close();
$conn->close();
?>
