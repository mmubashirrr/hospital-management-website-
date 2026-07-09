<?php
include 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $full_name = trim($_POST['full_name']);
    $specialization = trim($_POST['specialization']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    
    if (empty($full_name) || empty($specialization) || empty($phone) || empty($email)) {
        $message = "All fields are required.";
    } else {
        
        // Check if email already exists
        $check_sql = "SELECT email FROM doctors WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_result) > 0) {
            $message = "Email already exists! Please use a different email.";
        } else {
            
            $full_name = mysqli_real_escape_string($conn, $full_name);
            $specialization = mysqli_real_escape_string($conn, $specialization);
            $phone = mysqli_real_escape_string($conn, $phone);
            $email = mysqli_real_escape_string($conn, $email);
            
            $sql = "INSERT INTO doctors (full_name, specialization, phone, email) 
                    VALUES ('$full_name', '$specialization', '$phone', '$email')";
            
            if (mysqli_query($conn, $sql)) {
                header('Location: doctors.php?msg=added');
                exit();
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        }
    }
}

$pageTitle = "Add Doctor";
include 'header.php';
?>

<div class="page-header">
    <p class="eyebrow">Roster</p>
    <h1>Add Doctor</h1>
</div>

<?php if ($message): ?>
    <div class="alert alert-error"><?php echo $message; ?></div>
<?php endif; ?>

<div class="form-card">
    <form method="post" action="">
        <div class="field">
            <label>Doctor Name</label>
            <input type="text" name="full_name" required>
        </div>

        <div class="field">
            <label>Specialization</label>
            <input type="text" name="specialization" required>
        </div>

        <div class="field">
            <label>Phone</label>
            <input type="text" name="phone" required>
        </div>

        <div class="field">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <button type="submit">Add Doctor</button>
    </form>
</div>

<a href="doctors.php" class="back-link">← Back to Doctors</a>

<?php include 'footer.php'; ?>
