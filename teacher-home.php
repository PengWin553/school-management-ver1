<?php
include 'connection.php';

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
$teacherId = $row['teacher_id'];
$teacher_fname = $row['teacher_fname'];
$teacher_lname = $row['teacher_lname'];

echo $teacherId;
echo $teacher_fname;

// Logout functionality
if (isset($_GET['logout'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Fetch data from the database - Replace this with your actual code
try {
    // Get teacherId from session
    $teacher_id2 = $teacherId;

    echo $teacher_id2;

    // Check if year level is selected
    $selectedYear = isset($_POST['year_level']) ? $_POST['year_level'] : '';

    // Check if department is selected
    $selectedDepartment = isset($_POST['department_id']) ? $_POST['department_id'] : '';

    // Replace the following code with your database query and result fetching logic
    $query = "SELECT
        grades_table.grade_id,
        CONCAT(students_table.student_fname, ' ', students_table.student_lname) AS studentName,
        CONCAT(teachers_table.teacher_fname, ' ', teachers_table.teacher_lname) AS teacherName,
        students_table.year_level,
        students_table.department_id,  -- Include the department column in the query
        subject_name,
        prelim_grade,
        midterm_grade,
        semi_finals_grade,
        finals_grade
    FROM 
        grades_table
    INNER JOIN 
        students_table ON grades_table.student_id = students_table.student_id
    INNER JOIN 
        facultysubjects_table ON grades_table.facultysubject_id = facultysubjects_table.subject_id
    INNER JOIN 
        teachers_table ON facultysubjects_table.teacher_id = teachers_table.teacher_id
    WHERE 
        teachers_table.teacher_id = :teacher_id";

    // Modify the query if a year level is selected
    if (!empty($selectedYear)) {
        $query .= " AND students_table.year_level = :selectedYear";
    }

    // Modify the query if a department is selected
    if (!empty($selectedDepartment)) {
        $query .= " AND students_table.department_id = :selectedDepartment";
    }

    $stmt = $connection->prepare($query);
    $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);

    // Bind the parameters if year level or department is selected
    if (!empty($selectedYear)) {
        $stmt->bindParam(':selectedYear', $selectedYear, PDO::PARAM_STR);
    }

    if (!empty($selectedDepartment)) {
        $stmt->bindParam(':selectedDepartment', $selectedDepartment, PDO::PARAM_STR);
    }

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

// Fetch department data for dropdown
try {
    $departmentQuery = "SELECT department_name FROM departments_table";
    $departmentStmt = $connection->query($departmentQuery);
    $departments = $departmentStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    die("Department query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grades Table</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <h2>Grades Table</h2>

    <!-- Form for selecting year level and department -->
    <form action="" method="post">
        <label for="year">Select Year Level:</label>
        <select id="year" name="year">
            <option value="">All</option>
            <option value="1">1st Year</option>
            <option value="2">2nd Year</option>
            <option value="3">3rd Year</option>
            <option value="4">4th Year</option>
            <!-- Add more options for other year levels if needed -->
        </select>

        <label for="department">Select Department:</label>
        <select id="department" name="department">
            <option value="">All</option>
            <?php foreach ($departments as $department) : ?>
                <option value="<?php echo $department; ?>"><?php echo $department; ?></option>
            <?php endforeach; ?>
        </select>

        <input type="submit" value="Filter">
    </form>

    <!-- Display data in an HTML table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Teacher Name</th>
            <th>Year Level</th>
            <th>Department</th> <!-- Added Department column -->
            <th>Subject</th>
            <th>Prelim</th>
            <th>Midterm</th>
            <th>Semi-Final</th>
            <th>Final</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td><?php echo $row['grade_id']; ?></td>
                <td><?php echo $row['studentName']; ?></td>
                <td><?php echo $row['teacherName']; ?></td>
                <td><?php echo $row['year_level']; ?></td>
                <td><?php echo $row['department_id']; ?></td> <!-- Display Department -->
                <td><?php echo $row['subject_name']; ?></td>
                <td><?php echo $row['prelim_grade']; ?></td>
                <td><?php echo $row['midterm_grade']; ?></td>
                <td><?php echo $row['semi_finals_grade']; ?></td>
                <td><?php echo $row['finals_grade']; ?></td>
                <td>
                    <button>update</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Logout link with the logout parameter -->
    <a href="?logout=1">Logout</a>

</body>

</html>
