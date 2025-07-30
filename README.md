# Task Management System
### A simple Task Management System built with PHP, MySQL, and XAMPP that allows users (admin and students) to manage tasks, assign roles, track task progress, and receive notifications.

## Features

+ Students Role Management: Supports two roles - Admin and Student. For this signup.php, it is signing up to admin so you can test everything, Usually it will create a "student" role.
+ Task Management: Create, update, delete, and view tasks in priority and name title.
+ Task Categorization: Filter tasks by status, and due date.
+ Authentication and Authorization: Secure login system with role-based access control.
+ Notifications: Notify students of assigned tasks and important updates.
+ Task Filtering: Filter tasks by priority, status, deadline.
+ Task Deadlines: Track due dates and overdue tasks.
+ Admin power: delete and remove users etc

For table creation, Add each of these SQL tables into one


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'student') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

EXPORTED:
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(50) NOT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'student') DEFAULT 'admin',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    assigned_to INT,
    status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES users(id)
);

EXPORTED:
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100) NOT NULL,
  description TEXT,
  assigned_to INT DEFAULT NULL,
  due_date DATE NOT NULL,
  status ENUM('pending','in_progress','completed') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  priority ENUM('High','Medium','Low') DEFAULT 'Medium',
    FOREIGN KEY (assigned_to) REFERENCES users(id)
)

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    recipient INT NOT NULL,
    type VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    is_read BOOLEAN DEFAULT FALSE
);

EXPORTED:
CREATE TABLE notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  message TEXT NOT NULL,
  recipient INT NOT NULL,
  type VARCHAR(50) NOT NULL,
  date DATE NOT NULL,
  is_read BOOLEAN DEFAULT FALSE
)