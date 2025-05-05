# 🚢 Ship Booking System

**Live Demo**: [https://ship-booking.onrender.com/](https://ship-booking.onrender.com/)

**Tech Stack**: PHP | Laravel | JavaScript | SSLCommerz | SMTP Mail

---

## 📦 Project Overview

The Ship Booking System is a full-featured web application that enables users to browse, book, and manage ship tickets. It includes role-based access for **Users**, **Managers**, and **Admins**, with secure payment integration and ticket management features.

---

## 🔧 How to Run Locally

1. Install [XAMPP](https://www.apachefriends.org/) and [Composer](https://getcomposer.org/)
2. Clone or download this repository
   ```bash
   git clone <repository-url>
   ```
3. Open the project directory and install dependencies
   ```bash
   composer install
   ```
4. Create a new MySQL database and import the SQL file:
    File path: ./MySql-Database_Export/ship_ticket.sql
5. Run the Laravel development server:
   ```bash
   php artisan serve
    ```
## 👤 User Roles & Features
🧑 User
-> Browse available ships by route, date, and number of seats

-> View and apply available discounts

-> Book tickets using SSLCommerz payment gateway

-> Download purchased tickets

-> Request refunds

🧑‍💼 Manager
-> Assign, update, and manage ships

-> Approve user refund requests

-> Request manager role (requires admin approval)

🛠️ Admin
-> Approve or reject manager access requests

-> Manage ships, discounts, and users

-> Full access to all system features

## How to Access pre-defined roles Roles -
There are three roles (User, Manager, Admin)

-> Access the admin Panel 

email: admin@gmail.com

password: 1122

-> Access the Manager Panel

email: manager@gmail.com

password: 1122

-> Access the User Panel

email: user@gmail.com

password: 1122
