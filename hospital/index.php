<?php
$pageTitle = "Home";
include 'header.php';
?>

<div class="page-header">
    <p class="eyebrow">Front Desk</p>
    <h1>Good to see you.</h1>
    <p class="lede">Pick a chart to open — doctors, patients, or the appointment book. Everything here reads and writes straight to the hospital database.</p>
</div>

<div class="module-grid">

    <a href="doctors.php" class="module-card" style="--card-accent:#2F6F63">
        <svg class="icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.8"/>
            <path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M12 12v3M10.5 13.5h3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
        </svg>
        <h3>Doctors</h3>
        <p>Roster, specializations, and contact details.</p>
        <span class="go">Open roster →</span>
    </a>

    <a href="patients.php" class="module-card" style="--card-accent:#B8862B">
        <svg class="icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="1.8"/>
            <path d="M9 8h6M9 12h6M9 16h3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
        </svg>
        <h3>Patients</h3>
        <p>Demographics and contact records on file.</p>
        <span class="go">Open records →</span>
    </a>

    <a href="appointment.php" class="module-card" style="--card-accent:#E4572E">
        <svg class="icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="4" y="5" width="16" height="15" rx="2" stroke="currentColor" stroke-width="1.8"/>
            <path d="M4 9h16M8 3v4M16 3v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <circle cx="9" cy="14" r="1.1" fill="currentColor"/>
            <circle cx="13" cy="14" r="1.1" fill="currentColor"/>
            <circle cx="9" cy="17" r="1.1" fill="currentColor"/>
        </svg>
        <h3>Appointments</h3>
        <p>Book, filter by status, and manage the schedule.</p>
        <span class="go">Open schedule →</span>
    </a>

</div>

<?php include 'footer.php'; ?>
