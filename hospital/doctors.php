<?php
// doctors.php — Shows all doctors in a table

include 'db.php';

$sql = "SELECT doctors.doctor_id, doctors.full_name, doctors.specialization, doctors.phone,doctors.email 
        FROM doctors 
        ORDER BY doctors.doctor_id ASC";

$result = mysqli_query($conn, $sql);

$pageTitle = "Doctors";
include 'header.php';
?>

<div class="page-header">
    <p class="eyebrow">Roster</p>
    <h1>All Doctors</h1>
</div>

<?php
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'deleted') {
        echo "<div class='alert alert-error'>Doctor deleted successfully.</div>";
    } elseif ($_GET['msg'] == 'added') {
        echo "<div class='alert alert-success'>Doctor added successfully.</div>";
    } elseif ($_GET['msg'] == 'updated') {
        echo "<div class='alert alert-info'>Doctor updated successfully.</div>";
    }
}
?>

<div class="toolbar">
    <a href="add_doctor.php" class="btn btn-add">+ Add New Doctor</a>
</div>

<div class="search-bar">
    <input type="search" placeholder="Search doctors..." data-table-search="doctorsTable">
    <span class="match-count" data-table-count="doctorsTable"></span>
</div>

<table class="data-table" id="doctorsTable">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Specialization</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td class='mono'>" . $row['doctor_id'] . "</td>";
            echo "<td>" . $row['full_name'] . "</td>";
            echo "<td>" . $row['specialization'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td><a class='link-action edit' href='update_doctor_phone.php?id=" . $row['doctor_id'] . "'>Update Phone</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No doctor found.</td></tr>";
    }
    ?>
</table>

<a href="index.php" class="back-link">← Back to Home</a>

<?php include 'footer.php'; ?>
