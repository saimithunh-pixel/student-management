
CREATE DATABASE IF NOT EXISTS student_db;

USE student_db;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    course VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students (name, email, course, phone)
VALUES
('Rahul Kumar', 'rahul@example.com', 'BCA', '9876543210'),
('Priya Sharma', 'priya@example.com', 'BSc Computer Science', '9876543211'),
('Arun Kumar', 'arun@example.com', 'BCA', '9876543212');
