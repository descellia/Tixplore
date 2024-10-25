CREATE DATABASE todo_app;

USE todo_app;

CREATE TABLE tasks (
         id INT AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR(255) NOT NULL,
         category VARCHAR(30) NOT NULL,
         status VARCHAR(50) NOT NULL,
         due_date DATE NOT NULL
        );

INSERT INTO tasks (name, status, category, due_date, user_id) VALUES
('Belajar PHP', 'Not Started Yet', 'Education', '2024-11-01 12:00:00', 6),
('Menyelesaikan Proyek', 'Working on it', 'Work', '2024-10-28 17:00:00', 6),
('Olahraga', 'Done', 'Health', '2024-10-20 08:00:00', 7),
('Membaca Buku', 'Stuck', 'Hobby', '2024-11-05 15:00:00', 7),
('Perencanaan Keuangan', 'Not Started Yet', 'Finance', '2024-11-10 10:00:00', 6),
('Mempersiapkan Presentasi', 'Working on it', 'Work', '2024-11-02 09:00:00', 7),
('Rapat Tim', 'Done', 'Work', '2024-10-25 14:00:00', 6),
('Yoga', 'Not Started Yet', 'Health', '2024-11-12 07:00:00', 7),
('Perbaikan Bug', 'Stuck', 'Work', '2024-11-08 16:00:00', 6),
('Kursus Online', 'Done', 'Education', '2024-10-30 18:00:00', 7);
