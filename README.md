# 🚗 Driving School Management System

A **full-stack Driving School Management System** developed for the **Vajira Driving School**.  
The platform enables students to **enroll in driving courses online**, while administrators can **manage students, payments, packages, and system operations** through a centralized dashboard.

---

# 🛠 Tech Stack

<p align="left">

<img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white"/>
<img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white"/>
<img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white"/>
<img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white"/>
<img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black"/>
<img src="https://img.shields.io/badge/PHPMailer-8A2BE2?style=for-the-badge"/>
<img src="https://img.shields.io/badge/XAMPP-F37623?style=for-the-badge&logo=xampp&logoColor=white"/>

</p>

---

# 📌 Features

## 🔐 Authentication & Access Control

- Secure login system for administrators and staff
- Role-based access control (Admin / Instructor)
- Session management with dashboard redirection

---

## 👨‍🎓 Student Management

- Online student registration and enrollment
- Manage student records (view, edit, delete)
- Store detailed student information (personal + contact details)
- Track enrollment status:
  - Pending
  - Verified
  - In-session
  - Completed
  - Cancelled

---

## 📦 Training Package Management

- Create, update, and delete training packages
- Define package details:
  - Name
  - Description
  - Cost
  - Duration
  - Status (Active / Inactive)
- View all available driving courses

---

## 💳 Payment Management

- Record and manage student payments
- Maintain payment history per student
- Track total paid and remaining balance
- Add payment remarks for better tracking

---

## 🧾 Invoice Generation

- Generate printable invoices for students
- Includes:
  - Student details
  - Selected package
  - Payment breakdown
  - Remaining balance

---

## 📊 Reports & Analytics

- Generate payment reports with date filtering
- View transaction details:
  - Date
  - Registration number
  - Student name
  - Amount
- Calculate total revenue
- Print reports easily

---

## 📈 Admin Dashboard

- Overview of key system metrics:
  - Total packages
  - Pending enrollments
  - Verified students
  - Active sessions
  - Completed courses
  - Cancelled enrollments
- Quick navigation to all modules

---

## 👥 User Management

- Create and manage system users
- Assign roles (Admin / Staff)
- Edit or delete user accounts
- Manage login credentials and profiles

---

## 📝 Online Enrollment System

- Public enrollment form for students
- Collect:
  - Personal details
  - Package selection
  - Preferred schedule
- Simple and user-friendly registration process

---

## 🌐 Frontend Website

- Responsive homepage design
- Navigation:
  - Home
  - Packages
  - Enrollment
  - About Us
- “Enroll Now” call-to-action
- Display contact information

---

## ⚙️ System Settings

- Customize system information:
  - System name
  - Welcome message
  - About content
- Update school details (contact info, branding)

---

## 🗄 Database Management

- Structured MySQL database design
- Efficient relationships between:
  - Students
  - Packages
  - Payments
  - Users
- Ensures data consistency and scalability

---

## 🧪 Testing & Reliability

- Unit Testing
- Integration Testing
- System Testing
- User Acceptance Testing (UAT)
- Basic security validation

---

# 📂 Project Structure

```
Driving_School_Management_System
│
├── admin/
├── classes/
├── database/
├── inc/
├── phpmailer/
├── plugins/
├── libs/ & dist/
├── uploads/
├── config.php
├── index.php
├── initialize.php
├── enrollment.php
├── packages.php
├── message.php
├── home.php
└── README.md
```

---

# 🚀 Installation Guide

## ⚙️ Prerequisites

- XAMPP / WAMP / MAMP
- MySQL
- Git

---

## 1️⃣ Clone the Repository

```bash
cd C:/xampp/htdocs
git clone https://github.com/GayanKaushalya/Driving-School-Management-System.git
cd Driving-School-Management-System
```

---

## 2️⃣ Database Setup

```sql
CREATE DATABASE driving_school_db;
```

Import the `.sql` file from the `database/` folder.

---

## 3️⃣ Backend Setup

Open `config.php` and update:

```php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "driving_school_db";
```

---

## ▶ Run the Application

Start Apache & MySQL and open:

```
http://localhost/Driving-School-Management-System
```

---

## 🔐 Admin Panel

```
http://localhost/Driving-School-Management-System/admin
```

---

# 📜 License

This project was developed for **educational purposes** as part of the Diploma in Software Engineering.

---

# 👨‍💻 Author

**Gayan Kaushalya**  
Software Engineering Student  
Full-Stack Developer

---

⭐ If you found this project useful, consider giving it a **star** on GitHub.
