CREATE DATABASE todo_app;

USE todo_app;

CREATE TABLE tasks (
         id INT AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR(255) NOT NULL,
         category VARCHAR(30) NOT NULL,
         status VARCHAR(50) NOT NULL,
         due_date DATE NOT NULL
        );