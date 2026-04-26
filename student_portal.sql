CREATE DATABASE IF NOT EXISTS student_portal;
USE student_portal;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    course VARCHAR(100),
    profile_photo VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students (full_name, email, password, phone, course) VALUES
('Xenium Thebe', 'zen@example.com', 'sunnymunny', '9800000000', 'Web Development'),
('Alice Doe', 'alice@example.com', 'password123', '9800111122', 'Computer Science'),
('Bob Smith', 'bob@example.com', 'letmein', '9800222233', 'Information Tech');
