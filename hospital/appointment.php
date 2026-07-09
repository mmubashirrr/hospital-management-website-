<?php
include 'db.php';

$selected_status = isset($_GET['status']) ? $_GET['status'] : 'all';

if ($selected_status == 'all') {
    $sql = "SELECT 
            a.appointment_id,
            p.full_name AS patient_name,
            d.full_name AS doctor_name,
            a.appointment_date,
            a.status
            FROM appointments a
            JOIN patients p ON a.patient_id = p.patient_id
            JOIN doctors d ON a.doctor_id = d.doctor_id
            ORDER BY a.appointment_date ASC";
} else {
    $sql = "SELECT 
            a.appointment_id,
            p.full_name AS patient_name,
            d.full_name AS doctor_name,
            a.appointment_date,
            a.status
            FROM appointments a
            JOIN patients p ON a.patient_id = p.patient_id
            JOIN doctors d ON a.doctor_id = d.doctor_id
            WHERE a.status = '" . mysqli_real_escape_string($conn, $selected_status) . "'
            ORDER BY a.appointment_date ASC";
}

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}

function statusBadge($status) {
    $class = 'badge-scheduled';
    if ($status == 'Completed') { $class = 'badge-completed'; }
    if ($status == 'Cancelled') { $class = 'badge-cancelled'; }
    return "<span class='badge $class'>" . htmlspecialchars($status) . "</span>";
}

$pageTitle = "Appointments";
include 'header.php';
?>

<div class="page-header">
    <p class="eyebrow">Schedule</p>
    <h1>All Appointments</h1>
</div>

<?php
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'deleted') {
        echo "<div class='alert alert-success'>✓ Appointment deleted successfully.</div>";
    } elseif ($_GET['msg'] == 'added') {
        echo "<div class='alert alert-success'>✓ Appointment added successfully.</div>";
    } elseif ($_GET['msg'] == 'updated') {
        echo "<div class='alert alert-info'>✓ Appointment updated successfully.</div>";
    } elseif ($_GET['msg'] == 'error') {
        echo "<div class='alert alert-error'>✗ An error occurred.</div>";
    }
}
?>

<div class="toolbar">
    <a href="add_appointment.php" class="btn btn-add">+ Add New Appointment</a>
    <a href="patient_appointments.php" class="btn btn-secondary">Search by Patient</a>
</div>

<form method="GET" action="" class="filter-bar toolbar">
    <label>Filter by Status:</label>
    <select name="status" onchange="this.form.submit()">
        <option value="all" <?php echo $selected_status == 'all' ? 'selected' : ''; ?>>All</option>
        <option value="Scheduled" <?php echo $selected_status == 'Scheduled' ? 'selected' : ''; ?>>Scheduled</option>
        <option value="Completed" <?php echo $selected_status == 'Completed' ? 'selected' : ''; ?>>Completed</option>
        <option value="Cancelled" <?php echo $selected_status == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
    </select>
</form>

<div class="search-bar">
    <input type="search" placeholder="Search appointments..." data-table-search="appointmentsTable">
    <span class="match-count" data-table-count="appointmentsTable"></span>
</div>

<table class="data-table" id="appointmentsTable">
    <tr>
        <th>ID</th>
        <th>Patient</th>
        <th>Doctor</th>
        <th>Date</th>
        <th>Status</th>
    </tr>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td class='mono'>" . $row['appointment_id'] . "</td>";
            echo "<td>" . $row['patient_name'] . "</td>";
            echo "<td>" . $row['doctor_name'] . "</td>";
            echo "<td class='mono'>" . $row['appointment_date'] . "</td>";
            echo "<td>" . statusBadge($row['status']) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No appointments found.</td></tr>";
    }
    ?>
</table>

<a href="index.php" class="back-link">← Back to Home</a>

<?php include 'footer.php'; ?>
