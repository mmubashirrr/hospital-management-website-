<?php
include 'db.php';

$doctor_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$doctor = null;

if ($doctor_id > 0) {
    $get_sql = "SELECT doctor_id, full_name, specialization, phone, email FROM doctors WHERE doctor_id = $doctor_id";
    $get_result = mysqli_query($conn, $get_sql);
    
    if (mysqli_num_rows($get_result) > 0) {
        $doctor = mysqli_fetch_assoc($get_result);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['phone']) && $doctor_id > 0) {
    $new_phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $update_sql = "UPDATE doctors SET phone = '$new_phone' WHERE doctor_id = $doctor_id";
    
    if (mysqli_query($conn, $update_sql)) {
        header('Location: doctors.php?msg=updated');
        exit();
    }
}

$pageTitle = "Update Doctor Phone";
include 'header.php';
?>

<div class="page-header">
    <p class="eyebrow">Roster</p>
    <h1>Update Doctor Phone Number</h1>
</div>

<?php
if ($doctor) {
    echo "<div class='panel' style='max-width:480px; margin-bottom:22px;'>";
    echo "<p><strong>Doctor ID:</strong> <span class='mono'>" . $doctor['doctor_id'] . "</span></p>";
    echo "<p><strong>Name:</strong> " . $doctor['full_name'] . "</p>";
    echo "<p><strong>Specialization:</strong> " . $doctor['specialization'] . "</p>";
    echo "<p><strong>Current Phone:</strong> " . $doctor['phone'] . "</p>";
    echo "</div>";

    echo "<div class='form-card'>";
    echo "<form method='POST'>";
    echo "<div class='field'>";
    echo "<label>New Phone Number</label>";
    echo "<input type='text' name='phone' value='" . $doctor['phone'] . "' required>";
    echo "</div>";
    echo "<button type='submit'>Update Phone</button>";
    echo "</form>";
    echo "</div>";
} else {
    echo "<div class='alert alert-error'>Doctor not found!</div>";
}
?>

<a href="doctors.php" class="back-link">← Back</a>

<?php include 'footer.php'; ?>
