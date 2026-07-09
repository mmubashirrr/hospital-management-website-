-- =====================================================================
-- MediTrack — Hospital Management System
-- Database schema
--
-- Usage:
--   mysql -u root -p < hospital_db.sql
-- or import this file through phpMyAdmin / Adminer / MySQL Workbench.
-- =====================================================================

CREATE DATABASE IF NOT EXISTS hospital_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE hospital_db;

-- ---------------------------------------------------------------------
-- Table: doctors
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS doctors;
DROP TABLE IF EXISTS patients;

CREATE TABLE doctors (
    doctor_id       INT AUTO_INCREMENT PRIMARY KEY,
    full_name       VARCHAR(100)  NOT NULL,
    specialization  VARCHAR(100)  NOT NULL,
    phone           VARCHAR(20)   NOT NULL,
    email           VARCHAR(150)  NOT NULL,
    created_at      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_doctors_email (email)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table: patients
-- ---------------------------------------------------------------------
CREATE TABLE patients (
    patient_id      INT AUTO_INCREMENT PRIMARY KEY,
    full_name       VARCHAR(100)  NOT NULL,
    date_of_birth   DATE          NOT NULL,
    gender          ENUM('Male','Female','Other') NOT NULL,
    phone           VARCHAR(20)   NOT NULL,
    address         VARCHAR(255)  NOT NULL,
    created_at      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table: appointments
-- ---------------------------------------------------------------------
CREATE TABLE appointments (
    appointment_id    INT AUTO_INCREMENT PRIMARY KEY,
    patient_id        INT NOT NULL,
    doctor_id         INT NOT NULL,
    appointment_date  DATE NOT NULL,
    appointment_time  TIME NOT NULL,
    status            ENUM('Scheduled','Completed','Cancelled') NOT NULL DEFAULT 'Scheduled',
    notes             VARCHAR(255),
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_appointments_patient
        FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
        ON DELETE CASCADE,

    CONSTRAINT fk_appointments_doctor
        FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id)
        ON DELETE CASCADE,

    INDEX idx_appointments_status (status),
    INDEX idx_appointments_date (appointment_date)
) ENGINE=InnoDB;

-- =====================================================================
-- Sample data (optional) — comment out or delete this section if you
-- want to start with empty tables.
-- =====================================================================

INSERT INTO doctors (full_name, specialization, phone, email) VALUES
('Dr. Sarah Bennett',  'Cardiology',   '555-0101', 'sarah.bennett@meditrack.test'),
('Dr. James Okafor',   'Pediatrics',   '555-0102', 'james.okafor@meditrack.test'),
('Dr. Amina Qureshi',  'Dermatology',  '555-0103', 'amina.qureshi@meditrack.test'),
('Dr. Liam Chen',      'Orthopedics',  '555-0104', 'liam.chen@meditrack.test');

INSERT INTO patients (full_name, date_of_birth, gender, phone, address) VALUES
('Ayesha Raza',    '1994-03-12', 'Female', '555-0201', '12 Garden Town, Lahore'),
('Bilal Ahmed',    '1988-07-25', 'Male',   '555-0202', '45 Model Town, Lahore'),
('Meera Kapoor',   '2001-11-02', 'Female', '555-0203', '9 DHA Phase 3, Lahore'),
('Tariq Mehmood',  '1975-01-30', 'Male',   '555-0204', '78 Johar Town, Lahore');

INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, status, notes) VALUES
(1, 1, CURDATE() + INTERVAL 2 DAY, '09:30:00', 'Scheduled', 'Routine cardiac checkup'),
(2, 2, CURDATE() + INTERVAL 3 DAY, '11:00:00', 'Scheduled', 'Follow-up on vaccination'),
(3, 3, CURDATE() - INTERVAL 5 DAY, '14:15:00', 'Completed', 'Skin allergy consultation'),
(4, 4, CURDATE() - INTERVAL 1 DAY, '10:00:00', 'Cancelled', 'Rescheduling requested by patient');
