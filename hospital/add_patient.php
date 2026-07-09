<?php
// add_patient.php — Form to add a new patient to the database

include 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $full_name = trim($_POST['full_name']);
    $date_of_birth    = $_POST['date_of_birth'];
    $gender = trim($_POST['gender']); 
    $phone        = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Basic validation — make sure fields are not empty
    if (empty($full_name) || empty($date_of_birth) || empty($gender) || empty($phone) || empty($address) ) {
        $message = "All fields are required.";
    } else {

        $full_name        = mysqli_real_escape_string($conn, $full_name);
        $date_of_birth = mysqli_real_escape_string($conn, $date_of_birth);
         $gender        = mysqli_real_escape_string($conn, $gender);
        $phone = mysqli_real_escape_string($conn, $phone);
        $address = mysqli_real_escape_string($conn, $address);

        $sql = "INSERT INTO patients (full_name,date_of_birth,gender,phone,address) 
                VALUES ('$full_name','$date_of_birth','$gender','$phone','$address')";

        if (mysqli_query($conn, $sql)) {
            header('Location: patients.php?msg=added');
            exit();
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}

$pageTitle = "Add Patient";
include 'header.php';
?>

<div class="page-header">
    <p class="eyebrow">Records</p>
    <h1>Add Patient</h1>
</div>

<?php if ($message): ?>
    <div class="alert alert-error"><?php echo $message; ?></div>
<?php endif; ?>

<div class="form-card">
    <form method="post" action="">

        <div class="field">
            <label>Full Name</label>
            <input type="text" name="full_name" required>
        </div>

        <div class="field">
            <label>Date of Birth</label>
            <input type="date" name="date_of_birth" required>
        </div>

        <div class="field">
            <label>Gender</label>
            <select name="gender" required>
                <option value="">-- Select Gender --</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="field">
            <label>Phone</label>
            <input type="text" name="phone" required>
        </div>

        <div class="field">
            <label>Address</label>
            <input type="text" name="address" required>
        </div>

        <button type="submit">Add Patient</button>

    </form>
</div>

<a href="patients.php" class="back-link">← Back to Patients</a>

<?php include 'footer.php'; ?>
