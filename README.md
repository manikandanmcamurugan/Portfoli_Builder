# Portfolio Builder

A complete, responsive, professional Portfolio Builder Web Application built with HTML5, CSS3, Vanilla JavaScript, PHP 8+, and MySQL. No external frontend/backend frameworks are used (except FontAwesome for icons).

## Features
- **Student Portal**: Registration, Login, Profile Management, Skills, Education, Projects, Certificates, Template Selection, Live Preview, and Publishing.
- **Admin Portal**: Dashboard statistics, Student activation/deactivation, Template management.
- **Template Engine**: Choose between multiple templates (Modern & Professional included) that dynamically render student data.
- **Security**: PDO Prepared Statements, `password_hash()`, Session Management, File Upload validation.

## Requirements
- XAMPP (Apache + MySQL)
- PHP 8.0 or higher

## Installation Instructions

1. **Clone/Copy Project**
   Place the entire `Portfolio_Builder` folder inside your XAMPP `htdocs` directory.
   `C:/xampp/htdocs/Portfolio_Builder/`

2. **Database Setup**
   - Open XAMPP Control Panel and start **Apache** and **MySQL**.
   - Open phpMyAdmin (`http://localhost/phpmyadmin/`).
   - Create a new database named `portfolio_builder`.
   - Import the `database.sql` file located in the root folder into the `portfolio_builder` database.

3. **Configure Database Connection**
   Open `config/database.php` and verify your MySQL credentials.
   ```php
   $host = 'localhost';
   $db   = 'portfolio_builder';
   $user = 'root'; // default XAMPP user
   $pass = '';     // default XAMPP password (empty)
   ```

4. **Run the Application**
   Open your browser and navigate to:
   `http://localhost/Portfolio_Builder/`

## Admin Access
To access the Admin panel, you need an Admin account. 
You can either manually change a user's role in the `users` table to `admin`, or run this SQL query:
```sql
INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES
('Admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
```
*(The password for this demo admin is `password`)*

## Folder Structure
- `/admin` - Admin dashboard files.
- `/assets` - CSS, JS, and image uploads (profile photos, certificates, projects).
- `/config` - Database configuration.
- `/dashboard` - Student dashboard and CRUD modules.
- `/includes` - Reusable header, footer, and authentication files.
- `/portfolio` - The dynamic public portfolio router (`view.php`).
- `/templates` - The actual HTML/PHP files for the portfolio designs.

## Common Errors and Solutions
- **"Database connection failed"**: Ensure MySQL is running in XAMPP and `config/database.php` has the correct username/password.
- **File Upload Errors**: Ensure the `assets/images/uploads` directories have correct write permissions.
- **404 Not Found**: Ensure you placed the folder inside `htdocs` and are accessing the correct URL.
