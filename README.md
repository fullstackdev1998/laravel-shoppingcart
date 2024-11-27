# Laravel Mini Shopping Cart

A simple shopping cart system built with Laravel that demonstrates e-commerce workflows, including product listing,
adding items to the cart, updating cart quantities, viewing the cart, and remove from cart.

---

## 🛠 Features

- **Fetch Products**: Retrieve a list of products.
- **Add to Cart**: Add items to a shopping cart.
- **View Cart**: See items, their quantities, and total price.
- **Update Cart**: Change product quantities in the cart.
- **Remove Items**: Remove products from the cart.

---

## 📋 Requirements

- **PHP**: >= 8.3
- **Laravel**: >= 11.x
- **Composer**: Installed
- **Database**: MySQL

---

## 🚀 Installation

### 1️⃣ Clone the Repository

```bash
git clone git@github.com:fullstackdev1998/laravel-shoppingcart.git
cd laravel-shoppingcart
composer install
cp .env.example .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
SESSION_DRIVER=file

php artisan key:generate
php artisan migrate --seed
php artisan serve
php artisan test
I have added a postman collection file on root you can also test apis for that
