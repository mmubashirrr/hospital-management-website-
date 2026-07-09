<?php
include 'db.php';

$appointment_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$appointment = null;

if ($appointment_id > 0) {
    $get_sql = "SELECT a.appointment_id, a.status, p.full_name AS patient_name, d.full_name AS doctor_name, a.appointment_date, a.appointment_time
                FROM appointments a
                JOIN patients p ON a.patient_id = p.patient_id
                JOIN doctors d ON a.doctor_id = d.doctor_id
                WHERE a.appointment_id = $appointment_id";
    
    $get_result = mysqli_query($conn, $get_sql);
    
    if (mysqli_num_rows($get_result) > 0) {
        $appointment = mysqli_fetch_assoc($get_result);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status']) && $appointment_id > 0) {
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $update_sql = "UPDATE appointments SET status = '$new_status' WHERE appointment_id = $appointment_id";
    
    if (mysqli_query($conn, $update_sql)) {
        header('Location: patient_appointments.php?msg=updated');
        exit();
    }
}

$pageTitle = "Update Appointment Status";
include 'header.php';
?>

<div class="page-header">
    <p class="eyebrow">Schedule</p>
    <h1>Update Appointment Status</h1>
</div>

<?php
if ($appointment) {
    echo "<div class='panel' style='max-width:480px; margin-bottom:22px;'>";
    echo "<p><strong>Appointment ID:</strong> <span class='mono'>" . $appointment['appointment_id'] . "</span></p>";
    echo "<p><strong>Patient:</strong> " . $appointment['patient_name'] . "</p>";
    echo "<p><strong>Doctor:</strong> " . $appointment['doctor_name'] . "</p>";
    echo "<p><strong>Date:</strong> <span class='mono'>" . $appointment['appointment_date'] . "</span></p>";
    echo "<p><strong>Current Status:</strong> " . $appointment['status'] . "</p>";
    echo "</div>";

    echo "<div class='form-card'>";
    echo "<form method='POST'>";
    echo "<div class='field'>";
    echo "<label>Change Status</label>";
    echo "<select name='status' required>";
    echo "<option value='Scheduled' " . ($appointment['status'] == 'Scheduled' ? 'selected' : '') . ">Scheduled</option>";
    echo "<option value='Completed' " . ($appointment['status'] == 'Completed' ? 'selected' : '') . ">Completed</option>";
    echo "<option value='Cancelled' " . ($appointment['status'] == 'Cancelled' ? 'selected' : '') . ">Cancelled</option>";
    echo "</select>";
    echo "</div>";
    echo "<button type='submit'>Update</button>";
    echo "</form>";
    echo "</div>";
} else {
    echo "<div class='alert alert-error'>Appointment not found!</div>";
}
?>

<a href="patient_appointments.php" class="back-link">← Back</a>

<?php include 'footer.php'; ?>
