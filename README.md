# 🎓 Alumni Management System

This is a web-based Alumni Management System developed using PHP, MySQL, HTML, and CSS. It helps educational institutions manage alumni data, feedback, and interactions.

## 🚀 Features

- ✅ Alumni Registration and Login
- ✅ Password hashing and secure authentication
- ✅ Admin Dashboard with alumni list
- ✅ Edit and Delete alumni details
- ✅ Search alumni by name or batch
- ✅ Submit and View Feedback
- ✅ Logout functionality

## 🛠 Technologies Used

- PHP
- MySQL (phpMyAdmin)
- HTML/CSS
- Laragon (as local server)

## 📁 Project Structure
## 🧾 Database Tables

*Database name*: alumni_db

### alumni_users
| Field     | Type         |
|-----------|--------------|
| id        | INT, PRIMARY KEY, AUTO_INCREMENT |
| full_name | VARCHAR(100) |
| email     | VARCHAR(100), UNIQUE |
| password  | VARCHAR(255) |
| batch     | VARCHAR(10)  |

### feedback
| Field      | Type         |
|------------|--------------|
| id         | INT, PRIMARY KEY, AUTO_INCREMENT |
| name       | VARCHAR(100) |
| email      | VARCHAR(100) |
| message    | TEXT         |
| created_at | TIMESTAMP DEFAULT CURRENT_TIMESTAMP |

## 🧑‍💻 How to Run

1. Install *Laragon* and start Apache & MySQL.
2. Place the project folder in C:\laragon\www.
3. Open your browser and go to: http://alumni.test:8080/
4. Create database alumni_db using phpMyAdmin.
5. Import SQL or create tables manually.
6. Register a new user and log in.

## 📬 Feedback & Contributions

This project is built for educational purposes and can be extended with more features.