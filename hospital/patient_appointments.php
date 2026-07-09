<?php
include 'db.php';

$patient_name = '';
$patient_id = '';
$result = null;
$appointments_found = false;
$not_found = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['patient_name'])) {
    $patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
    
    $patient_sql = "SELECT patient_id, full_name FROM patients WHERE full_name LIKE '%$patient_name%'";
    $patient_result = mysqli_query($conn, $patient_sql);
    
    if (!$patient_result) {
        die("Query Error: " . mysqli_error($conn));
    }
    
    if (mysqli_num_rows($patient_result) > 0) {
        $patient = mysqli_fetch_assoc($patient_result);
        $patient_id = $patient['patient_id'];
        $patient_name = $patient['full_name'];
        
        $sql = "SELECT 
                a.appointment_id,
                p.full_name AS patient_name,
                d.full_name AS doctor_name,
                d.specialization,
                a.appointment_date,
                a.appointment_time,
                a.status,
                a.notes
                FROM appointments a
                JOIN patients p ON a.patient_id = p.patient_id
                JOIN doctors d ON a.doctor_id = d.doctor_id
                WHERE a.patient_id = $patient_id
                ORDER BY a.appointment_date ASC";
        
        $result = mysqli_query($conn, $sql);
        
        if (!$result) {
            die("Query Error: " . mysqli_error($conn));
        }
        
        if (mysqli_num_rows($result) > 0) {
            $appointments_found = true;
        }
    } else {
        $patient_name = '';
        $not_found = true;
    }
}

$all_patients_sql = "SELECT full_name FROM patients ORDER BY full_name ASC";
$all_patients_result = mysqli_query($conn, $all_patients_sql);
$all_patients = [];
while ($row = mysqli_fetch_assoc($all_patients_result)) {
    $all_patients[] = $row['full_name'];
}

function apptBadge($status) {
    $class = 'badge-scheduled';
    if ($status == 'Completed') { $class = 'badge-completed'; }
    if ($status == 'Cancelled') { $class = 'badge-cancelled'; }
    return "<span class='badge $class'>" . htmlspecialchars($status) . "</span>";
}

$pageTitle = "Search Appointments";
include 'header.php';
?>

<div class="page-header">
    <p class="eyebrow">Schedule</p>
    <h1>Search Patient Appointments</h1>
</div>

<div class="panel" style="max-width:560px;">
    <form method="POST" action="" class="field" style="margin-bottom:0;">
        <label>Enter Patient Name</label>
        <input type="text" id="patientName" name="patient_name" placeholder="Type patient name..." required list="patients">
        <datalist id="patients">
            <?php foreach ($all_patients as $patient) { ?>
                <option value="<?php echo $patient; ?>">
            <?php } ?>
        </datalist>
        <br><br>
        <button type="submit">Search</button>
    </form>
</div>

<br>

<?php if ($not_found): ?>
    <div class="alert alert-error">Patient not found!</div>
<?php endif; ?>

<?php
if ($appointments_found) {
    echo "<p><strong>Patient:</strong> " . $patient_name . " <span class='mono' style='color:var(--gray)'>(ID: " . $patient_id . ")</span></p>";
    
    echo "<table class='data-table'>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Doctor</th>";
    echo "<th>Specialization</th>";
    echo "<th>Date</th>";
    echo "<th>Time</th>";
    echo "<th>Status</th>";
    echo "<th>Notes</th>";
    echo "<th>Actions</th>";
    echo "</tr>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td class='mono'>" . $row['appointment_id'] . "</td>";
        echo "<td>" . $row['doctor_name'] . "</td>";
        echo "<td>" . $row['specialization'] . "</td>";
        echo "<td class='mono'>" . $row['appointment_date'] . "</td>";
        echo "<td class='mono'>" . $row['appointment_time'] . "</td>";
        echo "<td>" . apptBadge($row['status']) . "</td>";
        echo "<td>" . $row['notes'] . "</td>";
        echo "<td>
                <a class='link-action edit' href='update_status.php?id=" . $row['appointment_id'] . "'>Edit</a>
                &nbsp;|&nbsp;
                <a class='link-action delete' href='delete_appointment.php?id=" . $row['appointment_id'] . "' 
                   data-confirm='Delete this appointment? This cannot be undone.'>Delete</a>
              </td>";
        echo "</tr>";
    }
    
    echo "</table>";
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $patient_name == '' && !$not_found) {
    echo "<div class='alert alert-info'>No appointments found for this patient.</div>";
}
?>

<a href="appointment.php" class="back-link">← Back</a>

<?php include 'footer.php'; ?>
