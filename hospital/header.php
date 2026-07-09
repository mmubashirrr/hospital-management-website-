<?php
// header.php — shared top of every page.
// Set $pageTitle before including this file, e.g. $pageTitle = "Doctors";
if (!isset($pageTitle)) { $pageTitle = "MediTrack"; }
$current = basename($_SERVER['SCRIPT_NAME']);
function navClass($file, $current) {
    return $file === $current ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($pageTitle); ?> · MediTrack</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="topbar">
    <div class="topbar-inner">
        <a href="index.php" class="brand">
            <svg class="brand-mark" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 4 L16 28 M4 16 L28 16" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
            </svg>
            <span>
                <span class="brand-name">MediTrack</span>
                <span class="brand-sub">Hospital Records</span>
            </span>
        </a>
        <nav class="mainnav">
            <a href="index.php" class="<?php echo navClass('index.php', $current); ?>">Home</a>
            <a href="doctors.php" class="<?php echo navClass('doctors.php', $current); ?>">Doctors</a>
            <a href="patients.php" class="<?php echo navClass('patients.php', $current); ?>">Patients</a>
            <a href="appointment.php" class="<?php echo navClass('appointment.php', $current); ?>">Appointments</a>
        </nav>
    </div>
    <svg class="vitals-line" viewBox="0 0 600 20" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 10 L220 10 L235 2 L250 18 L265 10 L600 10" fill="none" stroke="currentColor" stroke-width="1.5"/>
    </svg>
</div>

<main class="page-wrap">
