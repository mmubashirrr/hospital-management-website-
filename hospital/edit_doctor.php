<?php
// edit_student.php — Load an existing student's data and allow editing

include 'db.php';

$message = "";

// Step 1: Get student ID from URL
// When user clicks Edit, URL is: edit_student.php?id=3
// isset() checks if a variable or key exists
if (!isset($_GET['id'])) {
    // If no ID in URL, send them back to students list
    header('Location: students.php');
    exit();
}

// Cast to integer to prevent SQL injection from the URL
$id = (int) $_GET['id'];

// Step 2: If form was submitted (POST), save the updated data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name        = trim($_POST['name']);
    $roll_number = trim($_POST['roll_number']);
    $class_id    = (int) $_POST['class_id'];

    if (empty($name) || empty($roll_number) || empty($class_id)) {
        $message = "All fields are required.";
    } else {

        $name        = mysqli_real_escape_string($conn, $name);
        $roll_number = mysqli_real_escape_string($conn, $roll_number);

        // UPDATE changes existing rows in the database
        // WHERE id = $id makes sure we only update THIS student, not all of them!
        $sql = "UPDATE students 
                SET name='$name', roll_number='$roll_number', class_id=$class_id 
                WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            header('Location: students.php?msg=updated');
            exit();
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}

// Step 3: Load existing student data to pre-fill the form
// We use LIMIT 1 because ID is unique — we only expect one row
$sql    = "SELECT * FROM students WHERE id=$id LIMIT 1";
$result = mysqli_query($conn, $sql);

// mysqli_num_rows() = 0 means no student found with that ID
if (mysqli_num_rows($result) == 0) {
    header('Location: students.php');
    exit();
}

// Fetch the student row as an associative array
$student = mysqli_fetch_assoc($result);

// Fetch all classes for dropdown
$classes = mysqli_query($conn, "SELECT * FROM classes ORDER BY class_name ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>

<h2>Edit Student</h2>

<?php if ($message): ?>
    <p style="color:red;"><?php echo $message; ?></p>
<?php endif; ?>

<form method="post" action="">

    <label>Student Name:</label><br>
    <!-- value="..." pre-fills the input with current data from DB -->
    <input type="text" name="name" value="<?php echo $student['name']; ?>" required><br><br>

    <label>Roll Number:</label><br>
    <input type="text" name="roll_number" value="<?php echo $student['roll_number']; ?>" required><br><br>

    <label>Class:</label><br>
    <select name="class_id" required>
        <option value="">-- Select Class --</option>
        <?php
        while ($class = mysqli_fetch_assoc($classes)) {
            // selected="selected" highlights the student's current class in the dropdown
            $selected = ($class['id'] == $student['class_id']) ? "selected='selected'" : "";
            echo "<option value='" . $class['id'] . "' $selected>" . $class['class_name'] . "</option>";
        }
        ?>
    </select><br><br>

    <button type="submit">Update Student</button>

</form>

<br>
<a href="students.php">← Back to Students</a>

</body>
</html>