# 📚 Library Management System (LMS)

A simple and efficient **Library Management System** built using **PHP & MySQL**.  
This project helps manage books, members, and their borrowing/return activities in a digital way.

---

## 🚀 Features
- 👨‍💼 **Admin Panel**
  - Add, update, delete books
  - Manage members/students
  - Issue/Return books
  - Track overdue books & fines

- 👩‍🎓 **Student/Member Panel**
  - View available books
  - Check issued books
  - Return history

- 🔍 **Search & Filter**
  - Quick search for books by title/author
  - Filter issued/available books

---

## 🛠️ Tech Stack
- **Frontend:** HTML, CSS, Bootstrap  
- **Backend:** PHP (Core)  
- **Database:** MySQL  
- **Server:** XAMPP / WAMP  

---

## ⚙️ Setup Instructions
1. Clone or download this repository:
   ```bash
   git clone https://github.com/<your-username>/library-management-system.git
   ```
2. Place the project folder inside `htdocs` (for XAMPP) or `www` (for WAMP).  
3. Open [phpMyAdmin](http://localhost/phpmyadmin) and create a database `lms`.  
4. Import the SQL file from `/database/lms.sql`.  
5. Update your database credentials in `config.php`.  
6. Run the project in browser:
   ```
   http://localhost/library-management-system/
   ```

---

## 🔑 Demo Credentials
- **Admin Login**  
  Email: `admin@example.com`  
  Password: `admin123`  

- **Student Login**  
  Email: `student@example.com`  
  Password: `student123`  

---

## 📸 Screenshots
![Dashboard](screenshots/dashboard.png)  
![Books](screenshots/books.png)  

---

## 📂 Project Structure
```
library-management-system/
│── database/           # SQL file
│── screenshots/        # Project screenshots
│── css/                # Stylesheets
│── js/                 # JavaScript files
│── index.php           # Entry point
│── config.php          # DB connection file
│── README.md           # Project info
```

---

## 📝 License
This project is licensed under the **MIT License** – feel free to use and modify it.  

---

## 🙋 Author
Developed by **[Your Name]**  
📧 Contact: your.email@example.com  
🌐 GitHub: [your-username](https://github.com/your-username)
