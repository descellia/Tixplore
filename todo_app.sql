CREATE DATABASE todo_app;

USE todo_app;

CREATE TABLE tasks (
  id int(11) NOT NULL,
  name VARCHAR(255) NOT NULL,
  category VARCHAR(30) NOT NULL,
  status VARCHAR(50) NOT NULL,
  due_date datetime NOT NULL,
  user_id int(11) DEFAULT NULL
);

CREATE TABLE users (
  id int(11) NOT NULL,
  firstname VARCHAR(50) NOT NULL,
  lastname VARCHAR(50) DEFAULT NULL,
  username VARCHAR(50) NOT NULL,
  birthdate date NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  profile_pic VARCHAR(255) DEFAULT 'uploads/default.png'
);

ALTER TABLE tasks
  ADD PRIMARY KEY (id),
  ADD KEY tasks_ibfk_1 (user_id);

ALTER TABLE users
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY username (username),
  ADD UNIQUE KEY email (email);

ALTER TABLE tasks
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE users
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;
