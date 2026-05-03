# 🛒 MyShop - E-commerce Project (Laravel + JS)

## 📌 Description

MyShop is a simple e-commerce web application built using **Laravel (backend)** and **Vanilla JavaScript + TailwindCSS (frontend)**.

The project allows users to browse products, add them to cart, place orders, and interact with a modern shopping system. It also includes an **admin dashboard** to manage products and orders.

---

## 🚀 Features

### 👤 User

* Register & Login (secure validation)
* Browse products 🔍
* Add to cart 🛒
* Add to wishlist ❤️
* Place orders (checkout)
* View products with ratings ⭐

### 👑 Admin

* Admin authentication
* Dashboard access
* Manage products (CRUD)
* Manage categories
* View all orders 📦
* Update order status (pending → shipped)

---

## 🔐 Authentication

* Laravel Sanctum
* Token-based authentication
* Role system (admin / user)

---

## 🧠 Tech Stack

* Backend: Laravel
* Frontend: HTML, TailwindCSS, JavaScript
* Database: MySQL
* Auth: Laravel Sanctum

---

## ⚙️ Installation

```bash
git clone https://github.com/your-username/myshop.git
cd myshop

composer install
cp .env.example .env
php artisan key:generate

# configure database in .env

php artisan migrate
php artisan db:seed
php artisan serve
```

---

## 👑 Admin Access

```
Email: admin@test.com
Password: Admin123@
```

---

## 📦 API Routes (examples)

* POST `/api/register`
* POST `/api/login`
* GET `/api/products`
* POST `/api/cart`
* POST `/api/checkout`
* GET `/api/admin/orders`

---

## 📸 Screenshots (optional)

![alt text](image.png)

<img width="1918" height="905" alt="image" src="https://github.com/user-attachments/assets/67c05630-fdb2-4719-a9c0-182a6128dfc2" />

<img width="1918" height="903" alt="image" src="https://github.com/user-attachments/assets/906482d5-4a80-4419-9be8-93a69149a4c0" />

<img width="1920" height="1947" alt="screencapture-127-0-0-1-8000-admin-2026-05-03-12_42_58" src="https://github.com/user-attachments/assets/7ca18bfc-9aa0-49a0-99dc-dd3f5d936842" />

<img width="1902" height="905" alt="image" src="https://github.com/user-attachments/assets/e6db0cac-e673-4d06-b75f-eef2b7d61ee1" />

<img width="1918" height="907" alt="image" src="https://github.com/user-attachments/assets/ddfccc25-c908-4809-bc94-9abfbb7c48bb" />







---

## 🌍 Live Demo (optional)

(Add Render or hosting link here)

---

## 🎯 Future Improvements

* Order details (products per order)
* Payment integration 💳
* Notifications 🔔
* Advanced dashboard (statistics)

---

## 👨‍💻 Author

* Your Name
* GitHub: https://github.com/jaidiayoub55-spec
