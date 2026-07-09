<?php
// patients.php — Shows all patients in a table

include 'db.php';

$sql = "SELECT patients.patient_id, patients.full_name, patients.date_of_birth, patients.gender , patients.phone, patients.address
        FROM patients 
        ORDER BY patients.full_name ASC";

$result = mysqli_query($conn, $sql);

$pageTitle = "Patients";
include 'header.php';
?>

<div class="page-header">
    <p class="eyebrow">Records</p>
    <h1>All Patients</h1>
</div>

<?php
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'deleted') {
        echo "<div class='alert alert-error'>Patient deleted successfully.</div>";
    } elseif ($_GET['msg'] == 'added') {
        echo "<div class='alert alert-success'>Patient added successfully.</div>";
    } elseif ($_GET['msg'] == 'updated') {
        echo "<div class='alert alert-info'>Patient updated successfully.</div>";
    }
}
?>

<div class="toolbar">
    <a href="add_patient.php" class="btn btn-add">+ Add New Patient</a>
</div>

<div class="search-bar">
    <input type="search" placeholder="Search patients..." data-table-search="patientsTable">
    <span class="match-count" data-table-count="patientsTable"></span>
</div>

<table class="data-table" id="patientsTable">
    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Date of Birth</th>
        <th>Gender</th>
        <th>Phone</th>
        <th>Address</th>
    </tr>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td class='mono'>" . $row['patient_id'] . "</td>";
            echo "<td>" . $row['full_name'] . "</td>";
            echo "<td class='mono'>" . $row['date_of_birth'] . "</td>";
            echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>" . $row['address'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No patient found.</td></tr>";
    }
    ?>
</table>

<a href="index.php" class="back-link">← Back to Home</a>

<?php include 'footer.php'; ?>
