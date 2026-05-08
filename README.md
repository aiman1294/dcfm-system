# DCFM System — Digital Court File Management System

## Overview

DCFM (Digital Court File Management System) is a Laravel-based web application designed to streamline court case management for lawyers, judges, and administrators.

The system provides secure role-based access control, case tracking, judge assignment, verdict management, hearing scheduling, and activity logging through a centralized platform.

Built using:

* Laravel
* Blade Templates
* Tailwind CSS
* SQLite/MySQL
* Laravel Breeze Authentication

---

# Features

## Authentication & Authorization

* User Registration & Login
* Laravel Breeze Authentication
* Role-based Access Control
* Pending Role Approval System
* Admin-only Approval Dashboard

### Roles

#### Admin

* Manage all cases
* Assign judges
* View all activity logs
* Approve/reject role requests
* Edit all case details

#### Lawyer

* Register cases
* View only their filed cases
* Edit their own cases
* Track verdicts and hearing updates

#### Judge

* View only assigned cases
* Update case status
* Add hearing dates
* Add judge notes
* Add verdicts

---

# Case Management

## Case Features

* Create cases
* Edit cases
* Delete cases
* Search cases
* Filter by:

  * Status
  * Priority
* Sort by:

  * Latest
  * Oldest
  * Priority
* Pagination support

---

# Judge Workflow

Admins can assign judges to cases.

Assigned judges can:

* Change case status
* Add hearing dates
* Add verdicts
* Add judge notes

Judges cannot:

* Edit title
* Edit description
* Edit priority
* Access unrelated cases

---

# Role-Based Security

The system includes strict authorization checks:

* Lawyers only access their own cases
* Judges only access assigned cases
* Admins access all cases
* Unauthorized URL access is blocked
* Pending users cannot access protected features

---

# Activity Timeline System

Every important action is logged into an activity timeline.

## Logged Activities

* Case creation
* Judge assignment
* Status updates
* Hearing scheduling
* Verdict additions

## Dashboard Activity Feed

### Admin Dashboard

Shows system-wide activity.

### Judge Dashboard

Shows activity only related to assigned cases.

### Lawyer Dashboard

Shows activity only related to their filed cases.

The activity feed includes:

* Timestamp
* User who performed the action
* Linked case reference
* Scrollable timeline UI

---

# UI Features

* Responsive dashboard layout
* Modern landing page
* Scrollable activity timeline
* Status badges
* Role-based navigation
* Clean Tailwind UI

---

# Database Structure

## Main Tables

### users

Stores:

* Authentication data
* Role information

### case_files

Stores:

* Case details
* Status
* Priority
* Judge assignment
* Hearing date
* Verdict
* Notes

### case_logs

Stores:

* Activity timeline logs
* User actions
* Related case references

---

# Technologies Used

| Technology     | Purpose           |
| -------------- | ----------------- |
| Laravel        | Backend Framework |
| Blade          | Templating Engine |
| Tailwind CSS   | Styling           |
| SQLite/MySQL   | Database          |
| Laravel Breeze | Authentication    |
| PHP            | Server-side Logic |

---

# Installation

## Clone Repository

```bash
git clone <repository-url>
cd project-name
```

## Install Dependencies

```bash
composer install
npm install
```

## Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

## Database Migration

```bash
php artisan migrate
```

## Start Development Server

### Terminal 1

```bash
php artisan serve
```

### Terminal 2

```bash
npm run dev
```

---

# Future Enhancements

* File upload system
* Notifications system
* Email alerts
* Advanced analytics dashboard
* Export reports (PDF)
* Multi-file evidence uploads
* Real-time notifications

---

# Project Highlights

* Secure role-based architecture
* Real-world legal workflow simulation
* Activity logging system
* Dashboard personalization
* Scalable Laravel structure
* Authorization-focused backend design

---

# Author

Aiman Malik

B.Tech Computer Science

---

# License

This project is developed for educational and academic purposes.
