# ImpactGuru Mini CRM

## 📌 Project Overview
ImpactGuru Mini CRM is a Laravel-based Customer Relationship Management system designed to manage customers, their orders, and system roles efficiently. The project demonstrates hands-on expertise with Laravel fundamentals including authentication, authorization, database relationships, file handling, API security, and production-grade structuring.

This project was developed as part of the ImpactGuru Internship Program to simulate real-world enterprise application development.

---

## ⚙️ Technology Stack

- **Framework**: Laravel 10.x
- **Language**: PHP 8.1+
- **Database**: MySQL
- **Frontend**: Blade + Tailwind / Bootstrap
- **Authentication**: Laravel Breeze
- **Authorization**: Role-Based Access Control (RBAC)
- **API Security**: Laravel Sanctum
- **Version Control**: Git + GitHub

---

## ✅ Features

### 🔐 Authentication Module
- User Registration & Login
- Password Reset
- Session Authentication
- Role-Based Access Control (Admin / Staff)

### 👥 Customer Management
- Create, Read, Update, Delete (CRUD) Customers
- Profile Image Upload
- Form Validation
- Soft Deletes
- Pagination
- Export to CSV / PDF

### 🛒 Order Management
- Customer → Orders (One-to-Many Relationship)
- Order CRUD
- Status Tracking (Pending / Completed / Cancelled)
- Email Notifications
- Pagination
- Export to CSV / PDF

### 🔍 Search & Filtering
- Search Customers by Name/Email
- Filter Orders by Status
- AJAX-powered UI (optional enhancement)

### 📊 Dashboard
- Total Customers
- Total Orders
- Total Revenue
- Recent Customers
- Role-based dashboards (Admin vs Staff)

### 🌐 REST API
- Secure API with Sanctum
- Role-Based API Permissions
- Full CRUD API for customers

---

## 🔐 Role Permissions

| Module         | Admin | Staff |
|---------------|-------|------|
| Customers CRUD | ✅    | ✅   |
| Orders CRUD    | ✅    | ✅   |
| User Management| ✅    | ❌   |
| Delete Rights  | ✅    | ❌   |
| API Access     | ✅    | ✅   |

---

## 🛠 Installation Steps

### Step 1: Clone Repository
```bash
git clone https://github.com/your-username/impactguru-mini-crm.git
cd impactguru-mini-crm


Step 2: Install Dependencies
composer install
npm install
npm run dev


Step 3: Configure Environment
cp .env.example .env
php artisan key:generate


Update .env with database credentials:

DB_DATABASE=impactguru_crm
DB_USERNAME=root
DB_PASSWORD=

Step 4: Run Migrations
php artisan migrate

Step 5: Seed Roles
php artisan db:seed

Step 6: Start Application
php artisan serve


Access in browser:

http://127.0.0.1:8000

📂 Folder Structure Highlights
app/
 ├─ Models/
 ├─ Http/
 │   ├─ Controllers/
 │   ├─ Middleware/
 │   └─ Requests/
config/
database/
resources/
routes/


🌐 API Endpoints
Method	Endpoint	Description
GET	/api/customers	Get all customers
GET	/api/customers/{id}	Get single customer
POST	/api/customers	Create customer
PUT	/api/customers/{id}	Update customer
DELETE	/api/customers/{id}	Delete customer

Authentication: Bearer Token (Laravel Sanctum)

🧪 Sample Admin Login

Email: admin@impactguru.com
Password: admin123



