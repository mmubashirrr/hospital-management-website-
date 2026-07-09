# MediTrack — Hospital Management System

A small PHP + MySQL app for managing doctors, patients, and appointments. Built with plain PHP (`mysqli`) and no framework — meant as a learning project / starter you can extend.

## Features

- **Doctors** — view roster, add new doctors, update phone numbers, live search
- **Patients** — view records, add new patients, live search
- **Appointments** — book appointments, filter by status, search by patient name, update status, delete
- Shared UI (`header.php` / `footer.php` / `style.css` / `app.js`) across every page: consistent nav, status badges, auto-dismissing alerts, and an in-app confirm dialog on delete

## Tech stack

- PHP (mysqli extension, no framework)
- MySQL / MariaDB
- Vanilla HTML/CSS/JS — no build step, no dependencies

## Requirements

- PHP 7.4+ with the `mysqli` extension enabled
- MySQL 5.7+ or MariaDB 10.3+
- Any local server stack works: XAMPP, MAMP, WAMP, Laragon, or `php -S` with a MySQL server running

## Setup

1. **Clone the repo**
   ```bash
   git clone https://github.com/<your-username>/<your-repo>.git
   cd <your-repo>
   ```

2. **Create the database**

   Import the included schema, which creates the `hospital_db` database, its tables, and a few sample rows:
   ```bash
   mysql -u root -p < hospital_db.sql
   ```
   Or open `hospital_db.sql` in phpMyAdmin / Adminer / MySQL Workbench and run it there.

3. **Configure the database connection**

   Edit `db.php` with your local MySQL credentials:
   ```php
   $host = "localhost";
   $db   = "hospital_db";
   $user = "root";
   $pass = "";
   ```

4. **Run the app**

   - **XAMPP/MAMP/WAMP:** copy the project folder into `htdocs` (or `www`), start Apache + MySQL, then visit `http://localhost/<folder-name>/index.php`.
   - **PHP's built-in server:**
     ```bash
     php -S localhost:8000
     ```
     then visit `http://localhost:8000/index.php`.

5. Open `index.php` in your browser — that's the home dashboard linking to Doctors, Patients, and Appointments.

## Project structure

```
.
├── index.php                  # Home dashboard
├── header.php                 # Shared page header/nav (include)
├── footer.php                 # Shared page footer (include)
├── style.css                  # Shared stylesheet
├── app.js                     # Shared JS (search, alerts, confirm modal)
├── db.php                     # Database connection config
├── hospital_db.sql            # Database schema + sample data
│
├── doctors.php                # Doctor list
├── add_doctor.php             # Add doctor form
├── update_doctor_phone.php    # Update a doctor's phone number
├── edit_doctor.php            # ⚠ not wired up — see Known issues
│
├── patients.php                # Patient list
├── add_patient.php             # Add patient form
│
├── appointment.php             # Appointment list + status filter
├── add_appointment.php         # Add appointment form
├── patient_appointments.php    # Search appointments by patient name
├── update_status.php           # Update an appointment's status
├── delete_appointment.php      # Delete an appointment
```

## Database schema

| Table          | Key columns                                                                 |
|----------------|------------------------------------------------------------------------------|
| `doctors`      | `doctor_id` (PK), `full_name`, `specialization`, `phone`, `email` (unique)   |
| `patients`     | `patient_id` (PK), `full_name`, `date_of_birth`, `gender`, `phone`, `address`|
| `appointments` | `appointment_id` (PK), `patient_id` (FK), `doctor_id` (FK), `appointment_date`, `appointment_time`, `status`, `notes` |

`appointments.patient_id` and `appointments.doctor_id` cascade on delete, so removing a patient or doctor also removes their appointments.

## Known issues

- `edit_doctor.php` is currently broken and unused — it queries a `students`/`classes` table left over from an earlier version of this project, not `doctors`. Nothing in the UI links to it. Either delete it or rebuild it to edit a doctor's full profile.
- Several forms build SQL by concatenating `$_POST`/`$_GET` values directly (e.g. `add_appointment.php`) rather than using prepared statements. This works for local/learning use but isn't safe for a public deployment — switch to `mysqli_prepare()` / parameterized queries before putting this anywhere internet-facing.

## License

Use this however you like — it's a learning project.
