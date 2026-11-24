# Todora · Task Management Web App

**Todora** is a personal task management web application built with native PHP and MySQL. Users create an account, manage their own tasks by status, category, and deadline, and see today's tasks with a live countdown. The repository is named *Tixplore*, but the app itself is branded **Todora**.

![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)
![daisyUI](https://img.shields.io/badge/daisyUI-5A0EF8?style=flat-square&logo=daisyui&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black)
![Status](https://img.shields.io/badge/status-academic_project-ffc107?style=flat-square)

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Database Schema](#database-schema)
- [Getting Started](#getting-started)
- [Application Flow](#application-flow)
- [Known Issues](#known-issues)
- [Roadmap](#roadmap)
- [Team](#team)

---

## Overview

Todora helps users keep their daily work, study, and personal tasks in one place. Each user sees only their own tasks. Tasks are grouped by **status** and **category**, and the home page highlights what is due **today** with a live countdown to each deadline.

The app was built as a team project in the Informatics program at Universitas Multimedia Nusantara (UMN).

---

## Features

### Authentication & Account
- **Register** with first name, last name, username, birth date, email, and password, plus a terms checkbox
- **Login** with email and password. Passwords are hashed with PHP `password_hash()` and checked with `password_verify()`
- **Forgot password**: verify identity with email and birth date, then set a new password
- **Logout** that clears and destroys the session
- **Profile page** to edit personal details, change the password, and upload a profile picture (a default avatar is used if none is set)

### Task Management
- **Create** tasks in a modal form with name, status, category, and due date and time
- **Read** all of your tasks, sorted by nearest due date
- **Update** a task on a dedicated edit page
- **Delete** a task from the task table
- **Search** tasks by name and **filter** by category

### Home Dashboard
- Personalized welcome message and profile avatar
- **Today's tasks** table with a live countdown (`2h 15m`, `Overdue`, or `Finished`)
- Color-coded status badges

| Status | Badge |
|---|---|
| Not Started Yet | ⬛ Black |
| Working on it | 🟨 Yellow |
| Stuck | 🟥 Red |
| Done | 🟩 Green |

Categories: **Work · Education · Personal · Finance · Health · Hobby**

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP (native, procedural), MySQLi with prepared statements, PHP sessions |
| Database | MySQL / MariaDB |
| Frontend | HTML, Tailwind CSS, daisyUI components, vanilla JavaScript |
| Tooling | Tailwind CLI via npm (`dev` and `build` scripts), Apache `.htaccess` rewrite |

---

## Project Structure

```
Tixplore/
├── index.php                   # Entry point, redirects to the login page
├── .htaccess                   # Rewrites unknown paths to index.php
├── config/
│   └── router.php              # Experimental path router (not wired in yet)
├── assets/css/
│   ├── input.css               # Tailwind source
│   └── output.css              # Compiled Tailwind + daisyUI build
├── views/
│   ├── db.php                  # Database connection
│   ├── fungsi.php              # Task CRUD helpers (add, get, update, delete)
│   ├── home.php                # Dashboard: today's tasks + countdown
│   ├── task_page.php           # Task list, search, filter, new-task modal
│   ├── edit_task.php           # Edit a task
│   ├── delete_task.php         # Delete a task (POST)
│   ├── profile.php             # Edit profile and upload a photo
│   ├── 404.php                 # Not-found page
│   ├── uploads/                # Profile pictures (default avatar included)
│   └── auth/
│       ├── config.php          # Database connection for auth pages
│       ├── login.php / login_process.php
│       ├── register.php / register_process.php
│       ├── forget_password.php / forget_password_process.php
│       ├── reset_password.php / reset_password_process.php
│       └── logout.php
├── todo_app.sql                # Initial database script
├── tailwind.config.js
└── package.json
```

---

## Database Schema

The app uses a database named `todo_app` with two tables. The included `todo_app.sql` only defines a partial `tasks` table. The schema below is reconstructed from the queries in the code and matches what the app expects:

```sql
CREATE DATABASE IF NOT EXISTS todo_app;
USE todo_app;

CREATE TABLE users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    firstname   VARCHAR(100) NOT NULL,
    lastname    VARCHAR(100),
    username    VARCHAR(50)  NOT NULL,
    birthdate   DATE         NOT NULL,
    email       VARCHAR(255) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    profile_pic VARCHAR(255) NULL
);

CREATE TABLE tasks (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    user_id  INT          NOT NULL,
    name     VARCHAR(255) NOT NULL,
    category VARCHAR(30)  NOT NULL,
    status   VARCHAR(50)  NOT NULL,
    due_date DATETIME     NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

`due_date` is a `DATETIME` here because the app saves both the date and the time from a `datetime-local` input.

---

## Getting Started

### Prerequisites
- PHP 7.4+ with the `mysqli` extension
- MySQL or MariaDB
- A local server stack such as **XAMPP**, **Laragon**, or **MAMP**
- Node.js and npm (only needed to rebuild the CSS)

### Installation

```bash
# 1. Clone into your web root (for example xampp/htdocs)
git clone https://github.com/descellia/Tixplore.git
cd Tixplore

# 2. (Optional) Install and rebuild Tailwind CSS
npm install
npm run build        # or: npm run dev  (watch mode)
```

3. **Create the database.** Run the SQL from [Database Schema](#database-schema) in phpMyAdmin or the MySQL CLI.
4. **Configure the connection.** By default the app connects with `localhost / root / (empty password) / todo_app`. Change the values in `views/db.php`, `views/auth/config.php`, and the two password-reset scripts if your setup is different.
5. **Run the app.** Start Apache and MySQL, then open:

```
http://localhost/Tixplore/
```

You are redirected to the login page. Register an account first, then log in.

---

## Application Flow

```
index.php ──► Login ──► Home (today's tasks + countdown)
               │  ▲          │
               │  │          ├──► Task Management ──► Edit / Delete
               ▼  │          ├──► Profile (update info, photo, password)
          Register│          └──► Logout ──► Login
          Forgot password ──► Reset password
```

---

## Known Issues

This is an academic prototype. The following issues are known and documented for transparency:

| Area | Issue |
|---|---|
| Password reset | `reset_password_process.php` redirects before the update logic runs, so the new password is never saved. |
| Search & filter | On the Task Management page, the search and category filters are added to the SQL string after the statement is prepared, so they have no effect. Filtering on the Home page works. |
| Authorization | `edit_task.php` and `delete_task.php` do not check the session or task ownership, so any task ID can be edited or deleted. |
| Redirects | Unauthenticated users on `home.php`, `task_page.php`, and `profile.php` are sent to `login.php` in `views/`, but the login page lives in `views/auth/`. |
| Account recovery | Identity is verified only with email and birth date, which is weak protection. |
| File upload | Profile uploads check that the file is an image but do not restrict extensions or rename files. |
| Configuration | Database credentials are hard-coded in several files. |
| Styling | Most pages load Tailwind and daisyUI from a CDN instead of the compiled `output.css`. |
| Edit page | The countdown script on the edit page looks for a table row that does not exist, so it throws a console error. |

---

## Roadmap

- [ ] Fix the password reset flow and the task search and filter queries
- [ ] Add session and ownership checks to edit and delete, plus CSRF tokens on forms
- [ ] Move database settings into one config file or a `.env` file
- [ ] Replace birth-date verification with an emailed reset token
- [ ] Validate and rename uploaded profile pictures
- [ ] Update `todo_app.sql` to the full schema with sample users
- [ ] Use the compiled Tailwind build on every page
- [ ] Wire up `config/router.php` for clean URLs

---

## Team

Built collaboratively by Informatics students at Universitas Multimedia Nusantara.

**Repository maintainer:** Descellia Ng ([descellia](https://github.com/descellia))

**Contributors** (from the commit history):
[denjelll](https://github.com/denjelll) ·
[saduady](https://github.com/saduady) ·
[KerbyLimitandy](https://github.com/KerbyLimitandy) ·
[gratefulboi](https://github.com/gratefulboi)
