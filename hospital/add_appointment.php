<?php
// add_appointment.php — Form to add a new appointment

include 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $patient_id = (int)$_POST['patient_id'];
    $doctor_id = (int)$_POST['doctor_id'];
    $appointment_date = trim($_POST['appointment_date']);
    $appointment_time = trim($_POST['appointment_time']);
    $status = trim($_POST['status']); 
    $notes = trim($_POST['notes']);
    
    // Validation
    if ($patient_id <= 0 || $doctor_id <= 0 || empty($appointment_date) || 
        empty($appointment_time) || empty($status) || empty($notes)) {
        $message = "All fields are required.";
    } else {
        // Use prepared statements (safer than real_escape_string)
        $sql = "INSERT INTO appointments (patient_id,doctor_id,appointment_date,appointment_time,status,notes) 
                               VALUES ('$patient_id','$doctor_id','$appointment_date','$appointment_time','$status','$notes')";
    
    
        if (mysqli_query($conn, $sql)) {
            header('Location: appointment.php?msg=added');
            exit();
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}

// Fetch patients and doctors AFTER post handling so result is always fresh
$patients_result = mysqli_query($conn, "SELECT * FROM patients ORDER BY full_name ASC");
$doctors_result = mysqli_query($conn, "SELECT * FROM doctors ORDER BY full_name ASC");

if (!$patients_result) {
    die("Patient query error: " . mysqli_error($conn));
}
if (!$doctors_result) {
    die("Doctor query error: " . mysqli_error($conn));
}

$pageTitle = "Add Appointment";
include 'header.php';
?>

<div class="page-header">
    <p class="eyebrow">Schedule</p>
    <h1>Add Appointment</h1>
</div>

<?php if ($message): ?>
    <div class="alert alert-error"><?php echo $message; ?></div>
<?php endif; ?>

<div class="form-card">
    <form method="post" action="">
        <div class="field">
            <label>Select Patient</label>
            <select name="patient_id" required>
                <option value="">-- Select Patient --</option>
                <?php
                while ($patient = mysqli_fetch_assoc($patients_result)) {
                    echo "<option value='" . $patient['patient_id'] . "'>" . htmlspecialchars($patient['full_name']) . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="field">
            <label>Select Doctor</label>
            <select name="doctor_id" required>
                <option value="">-- Select Doctor --</option>
                <?php
                while ($doctor = mysqli_fetch_assoc($doctors_result)) {
                    echo "<option value='" . $doctor['doctor_id'] . "'>" . htmlspecialchars($doctor['full_name']) . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="field">
            <label>Appointment Date</label>
            <input type="date" name="appointment_date" required>
        </div>

        <div class="field">
            <label>Appointment Time</label>
            <input type="time" name="appointment_time" required>
        </div>

        <div class="field">
            <label>Status</label>
            <select name="status" required>
                <option value="">-- Select Status --</option>
                <option value="Scheduled">Scheduled</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
            </select>
        </div>

        <div class="field">
            <label>Notes</label>
            <input type="text" name="notes" required>
        </div>

        <button type="submit">Add Appointment</button>
    </form>
</div>

<a href="appointment.php" class="back-link">← Back to Appointments</a>

<?php include 'footer.php'; ?>
