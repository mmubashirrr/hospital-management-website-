<?php
include 'db.php';

$appointment_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($appointment_id > 0) {
    $delete_sql = "DELETE FROM appointments WHERE appointment_id = $appointment_id";
    
    if (mysqli_query($conn, $delete_sql)) {
        header('Location: patient_appointments.php?msg=deleted');
        exit();
    } else {
        header('Location: patient_appointments.php?msg=error');
        exit();
    }
} else {
    header('Location: patient_appointments.php');
    exit();
}
?>